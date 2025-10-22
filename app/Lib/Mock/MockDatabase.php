<?php
/**
 * MockDatabase.php
 * 
 * Mock database implementation that reads from JSON files instead of MySQL
 */

namespace Exodus4D\Pathfinder\Lib\Mock;

class MockDatabase extends \DB\SQL {

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
        // Don't call parent constructor - we don't want a real DB connection
        
        // Set mock data path
        $this->mockDataPath = realpath(__DIR__ . '/../../mock/php/data/');
        
        // Load mock data
        $this->loadMockData();
        
        // Mock the PDO property that parent class expects
        $this->pdo = null;
        $this->dsn = $dsn;
        
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
     * Get DSN config string
     * @return string
     */
    public function getDSN() : string {
        return $this->dsn;
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

    /**
     * Quote a table/column key (simple implementation)
     * @param string $key
     * @return string
     */
    public function quotekey(string $key) : string {
        return '`' . $key . '`';
    }

    /**
     * Get database driver (mocked)
     * @return string
     */
    public function driver() : string {
        return 'mysql';
    }
}
