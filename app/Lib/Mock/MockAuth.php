<?php
/**
 * MockAuth.php
 * 
 * Mock authentication handler that bypasses SSO and creates mock sessions
 */

namespace Exodus4D\Pathfinder\Lib\Mock;

class MockAuth extends \Prefab {

    /**
     * Get mock character data
     * @return array|null
     */
    public static function getMockCharacterData() : ?array {
        $mockDataPath = realpath(__DIR__ . '/../../mock/php/data/');
        $characterFile = $mockDataPath . '/character.json';
        
        if(file_exists($characterFile)){
            $json = file_get_contents($characterFile);
            return json_decode($json, true);
        }
        
        // Return default mock character if file doesn't exist
        return [
            'CharacterID' => 123456789,
            'CharacterName' => 'Mock Character',
            'CharacterOwnerHash' => 'mock_owner_hash_' . md5('mock'),
            'ExpiresOn' => date('Y-m-d\TH:i:s', strtotime('+1 hour')),
            'Scopes' => '',
            'TokenType' => 'Character',
            'IntellectualProperty' => 'EVE'
        ];
    }

    /**
     * Get mock session data
     * @return array
     */
    public static function getMockSessionData() : array {
        $mockDataPath = realpath(__DIR__ . '/../../mock/php/data/');
        $sessionFile = $mockDataPath . '/session.json';
        
        if(file_exists($sessionFile)){
            $json = file_get_contents($sessionFile);
            return json_decode($json, true) ?: [];
        }
        
        // Return default mock session
        return [
            'character_id' => 123456789,
            'character_name' => 'Mock Character',
            'logged_in' => true,
            'login_time' => time()
        ];
    }

    /**
     * Check if SSO should be bypassed
     * @return bool
     */
    public static function shouldBypassSSO() : bool {
        return MockDetector::isMockMode();
    }
}
