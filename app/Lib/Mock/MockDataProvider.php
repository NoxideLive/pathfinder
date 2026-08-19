<?php
/**
 * MockDataProvider.php
 * 
 * Centralized mock data provider for template variables and other data
 */

namespace Exodus4D\Pathfinder\Lib\Mock;

class MockDataProvider extends \Prefab {

    /**
     * Get mock template data
     * @return array
     */
    public static function getTemplateData() : array {
        $mockDataPath = realpath(__DIR__ . '/../../mock/php/data/');
        $templateFile = $mockDataPath . '/templates.json';
        
        if(file_exists($templateFile)){
            $json = file_get_contents($templateFile);
            return json_decode($json, true) ?: [];
        }
        
        // Return default mock template data
        return [
            'character' => [
                'id' => 123456789,
                'name' => 'Mock Character',
                'corporation' => [
                    'id' => 98000001,
                    'name' => 'Mock Corporation'
                ],
                'alliance' => [
                    'id' => 99000001,
                    'name' => 'Mock Alliance'
                ]
            ],
            'maps' => [],
            'serverStatus' => [
                'online' => true,
                'players' => 25000
            ],
            'user' => [
                'id' => 1,
                'name' => 'Mock User'
            ]
        ];
    }

    /**
     * Get mock data for a specific key
     * @param string $key
     * @return mixed|null
     */
    public static function getMockData(string $key) {
        $data = self::getTemplateData();
        return $data[$key] ?? null;
    }
}
