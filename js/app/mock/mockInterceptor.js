/**
 * Mock Mode Interceptor
 * Intercepts AJAX requests and returns mock data when mock mode is enabled
 */

define([
    'jquery',
    'app/mock/mockDataLoader'
], ($, MockDataLoader) => {
    'use strict';

    let isMockMode = false;
    let mockConfig = {
        enabled: false,
        simulateDelay: true,
        delayMin: 100,
        delayMax: 500,
        failureRate: 0, // 0 = no failures, 0.1 = 10% failure rate
        logRequests: true
    };

    /**
     * Check if mock mode should be enabled
     * Checks for URL parameter, localStorage, or global config
     * Also verifies that mock mode is allowed in current environment
     * @returns {boolean}
     */
    let checkMockMode = () => {
        // First check if mock mode is allowed in this environment (from environment.ini)
        let mockAllowed = document.body.getAttribute('data-mock-allowed');
        if (mockAllowed !== '1') {
            // Mock mode is disabled in environment.ini (e.g., PRODUCTION)
            console.warn('[MOCK] Mock mode is disabled in this environment. Set MOCK_ALLOWED=1 in environment.ini to enable.');
            return false;
        }

        // Check URL parameter (highest priority)
        let urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('mockMode')) {
            let mockParam = urlParams.get('mockMode');
            return mockParam === 'true' || mockParam === '1';
        }

        // Check localStorage (persistent across sessions)
        try {
            let storedMode = localStorage.getItem('pathfinder_mock_mode');
            if (storedMode !== null) {
                return storedMode === 'true';
            }
        } catch (e) {
            console.warn('localStorage not available');
        }

        // Check global config (set in HTML or via script)
        if (window.PATHFINDER_MOCK_MODE !== undefined) {
            return window.PATHFINDER_MOCK_MODE === true;
        }

        return false;
    };

    /**
     * Log mock request for debugging
     * @param {string} url - Request URL
     * @param {string} method - HTTP method
     * @param {object} response - Mock response
     */
    let logMockRequest = (url, method, response) => {
        if (mockConfig.logRequests) {
            console.log(
                '%c[MOCK] %c' + method + ' %c' + url,
                'color: #ff6b6b; font-weight: bold',
                'color: #4ecdc4; font-weight: bold',
                'color: #95e1d3',
                response
            );
        }
    };

    /**
     * Initialize mock mode interceptor
     */
    let init = () => {
        isMockMode = checkMockMode();

        if (!isMockMode) {
            return;
        }

        console.log(
            '%c[MOCK MODE ENABLED]',
            'background: #ff6b6b; color: white; padding: 5px 10px; font-size: 14px; font-weight: bold'
        );

        // Store original $.ajax function
        let originalAjax = $.ajax;

        // Override $.ajax
        $.ajax = function(url, options) {
            // Handle both $.ajax(url, options) and $.ajax(options) signatures
            if (typeof url === 'object') {
                options = url;
                url = options.url;
            }

            // Check if this request should be mocked
            if (shouldMockRequest(url, options)) {
                return mockAjaxRequest(url, options);
            }

            // Pass through to original ajax for non-mocked requests
            return originalAjax.apply(this, arguments);
        };

        console.log('[MOCK] Interceptor initialized. All API calls will return mock data.');
    };

    /**
     * Determine if a request should be mocked
     * @param {string} url - Request URL
     * @param {object} options - Request options
     * @returns {boolean}
     */
    let shouldMockRequest = (url, options) => {
        // Only mock requests to /api/* endpoints
        return url && url.indexOf('/api/') !== -1;
    };

    /**
     * Mock an AJAX request
     * @param {string} url - Request URL
     * @param {object} options - Request options
     * @returns {Promise}
     */
    let mockAjaxRequest = (url, options) => {
        let method = (options.type || options.method || 'GET').toUpperCase();
        let deferred = $.Deferred();

        // Simulate network delay if configured
        let delayPromise = mockConfig.simulateDelay ?
            MockDataLoader.simulateDelay(mockConfig.delayMin, mockConfig.delayMax) :
            Promise.resolve();

        delayPromise.then(() => {
            // Simulate random failures if configured
            if (MockDataLoader.shouldSimulateFailure(mockConfig.failureRate)) {
                let errorResponse = {
                    status: 500,
                    statusText: 'Internal Server Error (Simulated)',
                    responseText: 'Mock failure simulation'
                };
                logMockRequest(url, method, 'FAILED');
                deferred.reject(errorResponse, 'error', 'Internal Server Error (Simulated)');
                return;
            }

            // Get mock data for this endpoint
            let mockResponse = MockDataLoader.getMockData(url);
            
            logMockRequest(url, method, mockResponse);

            // Trigger success callbacks
            if (options.success) {
                options.success.call(options.context || this, mockResponse, 'success', {
                    status: 200,
                    statusText: 'OK'
                });
            }

            // Resolve the deferred with mock data
            deferred.resolve(mockResponse, 'success', {
                status: 200,
                statusText: 'OK',
                getResponseHeader: () => null
            });
        });

        // Return a promise-like object that matches jQuery's ajax return value
        let promise = deferred.promise();
        
        // Add done, fail, always methods for chaining
        promise.done = function(callback) {
            deferred.done(callback);
            return promise;
        };
        
        promise.fail = function(callback) {
            deferred.fail(callback);
            return promise;
        };
        
        promise.always = function(callback) {
            deferred.always(callback);
            return promise;
        };

        return promise;
    };

    /**
     * Enable mock mode
     * @param {boolean} persist - Whether to persist the setting in localStorage
     */
    let enable = (persist = true) => {
        isMockMode = true;
        if (persist) {
            try {
                localStorage.setItem('pathfinder_mock_mode', 'true');
            } catch (e) {
                console.warn('Failed to persist mock mode setting');
            }
        }
        console.log('[MOCK] Mock mode enabled');
    };

    /**
     * Disable mock mode
     * @param {boolean} persist - Whether to persist the setting in localStorage
     */
    let disable = (persist = true) => {
        isMockMode = false;
        if (persist) {
            try {
                localStorage.removeItem('pathfinder_mock_mode');
            } catch (e) {
                console.warn('Failed to persist mock mode setting');
            }
        }
        console.log('[MOCK] Mock mode disabled');
    };

    /**
     * Check if mock mode is currently enabled
     * @returns {boolean}
     */
    let isEnabled = () => {
        return isMockMode;
    };

    /**
     * Configure mock mode settings
     * @param {object} config - Configuration options
     */
    let configure = (config) => {
        $.extend(mockConfig, config);
        console.log('[MOCK] Configuration updated:', mockConfig);
    };

    return {
        init: init,
        enable: enable,
        disable: disable,
        isEnabled: isEnabled,
        configure: configure
    };
});
