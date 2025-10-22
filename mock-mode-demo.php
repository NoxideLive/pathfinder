<?php
/**
 * Mock Mode Demonstration Page
 * 
 * This page demonstrates that mock mode is active and working
 */

// Set up basic autoloading for our mock classes
spl_autoload_register(function ($class) {
    $prefix = 'Exodus4D\\Pathfinder\\';
    $base_dir = __DIR__ . '/app/';
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Simple function to parse INI file and get values
function getEnvValue($section, $key) {
    $iniFile = 'app/environment.ini';
    $lines = file($iniFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $currentSection = '';
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line) || $line[0] === ';') continue;
        
        if (preg_match('/^\[([^\]]+)\]$/', $line, $matches)) {
            $currentSection = $matches[1];
        } elseif (preg_match('/^([^=]+)=(.*)$/', $line, $matches)) {
            $iniKey = trim($matches[1]);
            $iniValue = trim($matches[2]);
            
            if ($currentSection === $section && $iniKey === $key) {
                return $iniValue;
            }
        }
    }
    return null;
}

// Check if mock mode is enabled
$server = getEnvValue('ENVIRONMENT', 'SERVER');
$mockAllowed = getEnvValue('ENVIRONMENT.DEVELOP', 'MOCK_ALLOWED');
$mockPhpEnabled = getEnvValue('ENVIRONMENT.DEVELOP', 'MOCK_PHP_ENABLED');

$isMockMode = ($server === 'DEVELOP' && $mockAllowed == '1' && $mockPhpEnabled == '1');

// Load mock data
function loadJsonData($file) {
    $path = 'app/mock/php/data/' . $file;
    if (file_exists($path)) {
        return json_decode(file_get_contents($path), true);
    }
    return null;
}

$characterData = loadJsonData('character.json');
$templateData = loadJsonData('templates.json');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pathfinder - Mock Mode Demo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 800px;
            width: 100%;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .logo {
            font-size: 48px;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
        }
        
        .subtitle {
            color: #666;
            font-size: 18px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
        }
        
        .status-active {
            background: #10b981;
            color: white;
        }
        
        .status-inactive {
            background: #ef4444;
            color: white;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .info-card {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
        }
        
        .info-card h3 {
            color: #1e293b;
            font-size: 16px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .info-card .icon {
            font-size: 24px;
        }
        
        .info-card p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .info-card .value {
            color: #0f172a;
            font-weight: 600;
            font-size: 18px;
            margin-top: 8px;
        }
        
        .details {
            background: #f1f5f9;
            border-radius: 12px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .details h3 {
            color: #1e293b;
            margin-bottom: 15px;
        }
        
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .details th,
        .details td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #cbd5e1;
        }
        
        .details th {
            color: #475569;
            font-weight: 600;
            font-size: 14px;
        }
        
        .details td {
            color: #1e293b;
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success {
            background: #dcfce7;
            color: #166534;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .alert {
            background: #fef3c7;
            border: 2px solid #fbbf24;
            border-radius: 12px;
            padding: 16px;
            margin-top: 30px;
            display: flex;
            gap: 12px;
        }
        
        .alert .icon {
            font-size: 24px;
        }
        
        .alert .content {
            flex: 1;
        }
        
        .alert .content strong {
            color: #92400e;
            display: block;
            margin-bottom: 4px;
        }
        
        .alert .content p {
            color: #78350f;
            font-size: 14px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">PATHFINDER</div>
            <div class="subtitle">Mock Mode Demonstration</div>
            
            <?php if ($isMockMode): ?>
                <div class="status-badge status-active">
                    ✓ Mock Mode Active
                </div>
            <?php else: ?>
                <div class="status-badge status-inactive">
                    ✗ Mock Mode Inactive
                </div>
            <?php endif; ?>
        </div>
        
        <div class="info-grid">
            <div class="info-card">
                <h3><span class="icon">🔧</span> Environment</h3>
                <p>Server environment setting</p>
                <div class="value"><?php echo htmlspecialchars($server); ?></div>
            </div>
            
            <div class="info-card">
                <h3><span class="icon">🎭</span> Mock Status</h3>
                <p>Mock mode configuration</p>
                <div class="value"><?php echo $isMockMode ? 'Enabled' : 'Disabled'; ?></div>
            </div>
        </div>
        
        <?php if ($isMockMode): ?>
            <div class="details">
                <h3>Mock Configuration Details</h3>
                <table>
                    <tr>
                        <th>Setting</th>
                        <th>Value</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>SERVER</td>
                        <td><?php echo htmlspecialchars($server); ?></td>
                        <td><span class="badge badge-success">DEVELOP</span></td>
                    </tr>
                    <tr>
                        <td>MOCK_ALLOWED</td>
                        <td><?php echo htmlspecialchars($mockAllowed); ?></td>
                        <td><span class="badge badge-success">Enabled</span></td>
                    </tr>
                    <tr>
                        <td>MOCK_PHP_ENABLED</td>
                        <td><?php echo htmlspecialchars($mockPhpEnabled); ?></td>
                        <td><span class="badge badge-success">Enabled</span></td>
                    </tr>
                </table>
            </div>
            
            <?php if ($characterData): ?>
            <div class="details">
                <h3>Mock Character Data</h3>
                <table>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Character ID</td>
                        <td><?php echo htmlspecialchars($characterData['CharacterID']); ?></td>
                    </tr>
                    <tr>
                        <td>Character Name</td>
                        <td><?php echo htmlspecialchars($characterData['CharacterName']); ?></td>
                    </tr>
                    <tr>
                        <td>Corporation</td>
                        <td><?php echo htmlspecialchars($characterData['corporation_name']); ?></td>
                    </tr>
                    <tr>
                        <td>Alliance</td>
                        <td><?php echo htmlspecialchars($characterData['alliance_name']); ?></td>
                    </tr>
                </table>
            </div>
            <?php endif; ?>
            
            <?php if ($templateData): ?>
            <div class="details">
                <h3>Mock Template Data</h3>
                <table>
                    <tr>
                        <th>Key</th>
                        <th>Value</th>
                    </tr>
                    <?php foreach ($templateData as $key => $value): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($key); ?></td>
                        <td><pre style="margin:0; font-size:12px; max-height:100px; overflow:auto;"><?php echo htmlspecialchars(json_encode($value, JSON_PRETTY_PRINT)); ?></pre></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            
            <div class="alert">
                <div class="icon">⚠️</div>
                <div class="content">
                    <strong>Development Mode Active</strong>
                    <p>This application is running in mock mode. Database connections, SSO authentication, and external API calls are bypassed with mock data. This mode should NEVER be used in production.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="alert">
                <div class="icon">ℹ️</div>
                <div class="content">
                    <strong>Mock Mode Disabled</strong>
                    <p>To enable mock mode, edit app/environment.ini and set SERVER=DEVELOP, MOCK_ALLOWED=1, and MOCK_PHP_ENABLED=1.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
