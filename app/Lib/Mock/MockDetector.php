<?php
/**
 * MockDetector.php
 * 
 * Detects if PHP-level mock mode should be active
 */

namespace Exodus4D\Pathfinder\Lib\Mock;

use Exodus4D\Pathfinder\Controller\Controller;

class MockDetector extends \Prefab {

    /**
     * Check if mock mode is enabled and should be active
     * @return bool
     */
    public static function isMockMode() : bool {
        $f3 = \Base::instance();
        
        // Check if we're in DEVELOP environment
        $server = $f3->get('ENVIRONMENT.SERVER');
        if($server !== 'DEVELOP'){
            // Security check: log if someone tries to enable mock mode in production
            $mockAllowedProd = Controller::getEnvironmentData('MOCK_ALLOWED');
            $mockPhpEnabledProd = Controller::getEnvironmentData('MOCK_PHP_ENABLED');
            if(!empty($mockAllowedProd) || !empty($mockPhpEnabledProd)){
                error_log('[PATHFINDER SECURITY WARNING] Attempt to enable mock mode in PRODUCTION environment was blocked!');
            }
            return false;
        }
        
        // Check if MOCK_ALLOWED is enabled
        $mockAllowed = Controller::getEnvironmentData('MOCK_ALLOWED');
        if(empty($mockAllowed)){
            return false;
        }
        
        // Check if MOCK_PHP_ENABLED is specifically enabled
        $mockPhpEnabled = Controller::getEnvironmentData('MOCK_PHP_ENABLED');
        
        return !empty($mockPhpEnabled);
    }
    
    /**
     * Log warning when mock mode is active
     */
    public static function logMockWarning() : void {
        if(self::isMockMode()){
            error_log('[PATHFINDER MOCK MODE] PHP-level mocking is ENABLED. This should NEVER be active in production!');
        }
    }
}
