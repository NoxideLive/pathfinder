<?php
/**
 * MockDatabase.php
 * 
 * Mock database implementation that reads from JSON files instead of MySQL
 */

namespace Exodus4D\Pathfinder\Lib\Mock;

use Exodus4D\Pathfinder\Lib\Db\Sql;

class MockDatabase extends Sql {

    /**
     * @var array Mock data storage
     */
    private $mockData = [];
    
    /**
     * @var string Path to mock data directory
     */
    private $mockDataPath;

    /**
     * MockDatabase constructor.
     * @param string $dsn (ignored in mock mode)
     * @param null $user (ignored in mock mode)
     * @param null $pw (ignored in mock mode)
     * @param array|null $options (ignored in mock mode)
     */
    public function __construct($dsn, $user = null, $pw = null, array $options = null){
        // Set mock data path
        $this->mockDataPath = realpath(__DIR__ . '/../../mock/php/data/');
        
        // Load mock data
        $this->loadMockData();
        
        // Store DSN for getDSN() method
        $this->dsn = $dsn;
        
        // Create a mock PDO-like object to avoid errors
        // We use a stub object that won't actually connect to a database
        try {
            // Create an in-memory SQLite database as a placeholder
            // This prevents errors from code expecting a PDO connection
            parent::__construct('sqlite::memory:', null, null, null);
        } catch(\Exception $e) {
            // If that fails, we'll just set dsn manually
            $this->dsn = $dsn;
        }
        
        MockDetector::logMockWarning();
    }

    /**
     * Load mock data from JSON files
     */
    private function loadMockData() : void {
        $queriesFile = $this->mockDataPath . '/queries.json';
        if(file_exists($queriesFile)){
            $json = file_get_contents($queriesFile);
            $this->mockData = json_decode($json, true) ?: [];
        }
    }

    /**
     * Execute a mock SQL query
     * @param array|string $cmds
     * @param null $args
     * @param int $ttl
     * @param bool $log
     * @param bool $stamp
     * @return array|FALSE|int
     */
    public function exec($cmds, $args = null, $ttl = 0, $log = false, $stamp = false) {
        // Return mock data based on query patterns
        $query = is_array($cmds) ? implode(';', $cmds) : $cmds;
        
        // Log mock query in debug mode
        if($log){
            error_log('[MOCK DB] Query: ' . $query);
        }
        
        // Pattern matching for common queries
        if(preg_match('/SELECT DATABASE\(\)/i', $query)){
            return [['pathfinder']];
        }
        
        if(preg_match('/SHOW TABLE STATUS/i', $query)){
            return $this->mockData['table_status'] ?? [];
        }
        
        if(preg_match('/SELECT COUNT\(\*\)/i', $query)){
            return [['num' => 0]];
        }
        
        // Default empty result
        return [];
    }

    /**
     * Get database name (mocked)
     * @return string|null
     */
    public function name() : ?string {
        return 'pathfinder';
    }

    /**
     * Get all table names (mocked)
     * @return array|bool
     */
    public function getTables(){
        return $this->mockData['tables'] ?? ['sessions', 'character', 'user', 'map'];
    }

    /**
     * Check if a table exists (mocked)
     * @param string $table
     * @return bool
     */
    public function tableExists(string $table) : bool {
        return in_array($table, $this->getTables());
    }

    /**
     * Get row count for a table (mocked)
     * @param string $table
     * @return int
     */
    public function getRowCount(string $table) : int {
        return $this->mockData['row_counts'][$table] ?? 0;
    }

    /**
     * Get table status (mocked)
     * @param string|null $table
     * @return array|null
     */
    public function getTableStatus(?string $table) : ?array {
        return $this->mockData['table_status'] ?? null;
    }

    /**
     * Prepare database (no-op in mock mode)
     * @param string $characterSetDatabase
     * @param string $collationDatabase
     */
    public function prepareDatabase(string $characterSetDatabase, string $collationDatabase){
        // No-op in mock mode
    }
}
