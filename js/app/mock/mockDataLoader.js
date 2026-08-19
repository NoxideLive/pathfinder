/**
 * Mock Data Loader
 * Provides utility functions for loading and managing mock data
 */

define([
    'jquery',
    'text!app/mock/data/initData.json',
    'text!app/mock/data/serverStatus.json',
    'text!app/mock/data/userData.json',
    'text!app/mock/data/mapData.json'
], ($, initDataJSON, serverStatusJSON, userDataJSON, mapDataJSON) => {
    'use strict';

    // Parse JSON data
    let mockData = {
        initData: JSON.parse(initDataJSON),
        serverStatus: JSON.parse(serverStatusJSON),
        userData: JSON.parse(userDataJSON),
        mapData: JSON.parse(mapDataJSON)
    };

    /**
     * Get mock data for a specific endpoint
     * @param {string} endpoint - The API endpoint path
     * @returns {object|null} - Mock data or null if not found
     */
    let getMockData = (endpoint) => {
        // Map endpoints to mock data
        const endpointMap = {
            '/api/Map/initData': 'initData',
            '/api/User/getEveServerStatus': 'serverStatus',
            '/api/Map/updateUserData': 'userData',
            '/api/Map/updateData': 'mapData',
            '/api/User/getCookieCharacter': 'userData'
        };

        let dataKey = endpointMap[endpoint];
        if (dataKey && mockData[dataKey]) {
            // Return a deep copy to prevent mutations
            return JSON.parse(JSON.stringify(mockData[dataKey]));
        }

        // Return empty success response for unmapped endpoints
        return {
            status: 'success',
            message: 'Mock response for ' + endpoint
        };
    };

    /**
     * Add custom mock data for an endpoint
     * @param {string} endpoint - The API endpoint path
     * @param {object} data - The mock data to return
     */
    let addMockData = (endpoint, data) => {
        mockData[endpoint] = data;
    };

    /**
     * Simulate network delay
     * @param {number} min - Minimum delay in ms
     * @param {number} max - Maximum delay in ms
     * @returns {Promise}
     */
    let simulateDelay = (min = 100, max = 500) => {
        let delay = Math.floor(Math.random() * (max - min + 1)) + min;
        return new Promise(resolve => setTimeout(resolve, delay));
    };

    /**
     * Simulate random failures for testing error handling
     * @param {number} failureRate - Probability of failure (0-1)
     * @returns {boolean}
     */
    let shouldSimulateFailure = (failureRate = 0) => {
        return Math.random() < failureRate;
    };

    return {
        getMockData: getMockData,
        addMockData: addMockData,
        simulateDelay: simulateDelay,
        shouldSimulateFailure: shouldSimulateFailure
    };
});
