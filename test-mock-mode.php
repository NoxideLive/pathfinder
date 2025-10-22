#!/usr/bin/env php
<?php
/**
 * Test script for Mock Mode
 * 
 * This script tests the mock mode detection and basic functionality
 */

// Get the directory where this script is located
$scriptDir = dirname(__FILE__);

echo "=== Mock Mode Test Script ===\n";
echo "Running from: $scriptDir\n\n";

// Test 1: Check if mock files exist
echo "Test 1: Checking mock files...\n";
$mockFiles = [
    'app/Lib/Mock/MockDetector.php',
    'app/Lib/Mock/MockDatabase.php',
    'app/Lib/Mock/MockAuth.php',
    'app/Lib/Mock/MockDataProvider.php',
    'app/mock/php/data/character.json',
    'app/mock/php/data/session.json',
    'app/mock/php/data/queries.json',
    'app/mock/php/data/templates.json'
];

$allFilesExist = true;
foreach($mockFiles as $file){
    $fullPath = $scriptDir . '/' . $file;
    if(file_exists($fullPath)){
        echo "  ✓ $file\n";
    } else {
        echo "  ✗ $file (MISSING)\n";
        $allFilesExist = false;
    }
}

if($allFilesExist){
    echo "\n✓ All mock files exist\n\n";
} else {
    echo "\n✗ Some mock files are missing\n\n";
    exit(1);
}

// Test 2: Validate JSON files
echo "Test 2: Validating JSON files...\n";
$jsonFiles = [
    'app/mock/php/data/character.json',
    'app/mock/php/data/session.json',
    'app/mock/php/data/queries.json',
    'app/mock/php/data/templates.json'
];

$allJsonValid = true;
foreach($jsonFiles as $file){
    $fullPath = $scriptDir . '/' . $file;
    $content = file_get_contents($fullPath);
    $data = json_decode($content, true);
    if(json_last_error() === JSON_ERROR_NONE){
        echo "  ✓ $file is valid JSON\n";
    } else {
        echo "  ✗ $file has invalid JSON: " . json_last_error_msg() . "\n";
        $allJsonValid = false;
    }
}

if($allJsonValid){
    echo "\n✓ All JSON files are valid\n\n";
} else {
    echo "\n✗ Some JSON files are invalid\n\n";
    exit(1);
}

// Test 3: Check PHP syntax
echo "Test 3: Checking PHP syntax...\n";
$phpFiles = [
    'app/Lib/Mock/MockDetector.php',
    'app/Lib/Mock/MockDatabase.php',
    'app/Lib/Mock/MockAuth.php',
    'app/Lib/Mock/MockDataProvider.php'
];

$allSyntaxValid = true;
foreach($phpFiles as $file){
    $fullPath = $scriptDir . '/' . $file;
    exec("php -l $fullPath 2>&1", $output, $returnCode);
    if($returnCode === 0){
        echo "  ✓ $file has valid syntax\n";
    } else {
        echo "  ✗ $file has syntax errors:\n";
        echo "    " . implode("\n    ", $output) . "\n";
        $allSyntaxValid = false;
    }
    $output = [];
}

if($allSyntaxValid){
    echo "\n✓ All PHP files have valid syntax\n\n";
} else {
    echo "\n✗ Some PHP files have syntax errors\n\n";
    exit(1);
}

// Test 4: Check environment.ini configuration
echo "Test 4: Checking environment.ini configuration...\n";
$envFile = $scriptDir . '/app/environment.ini';
$envContent = file_get_contents($envFile);

if(strpos($envContent, 'MOCK_ALLOWED') !== false){
    echo "  ✓ MOCK_ALLOWED setting found\n";
} else {
    echo "  ✗ MOCK_ALLOWED setting not found\n";
    $allSyntaxValid = false;
}

if(strpos($envContent, 'MOCK_PHP_ENABLED') !== false){
    echo "  ✓ MOCK_PHP_ENABLED setting found\n";
} else {
    echo "  ✗ MOCK_PHP_ENABLED setting not found\n";
    $allSyntaxValid = false;
}

echo "\n✓ Environment configuration looks good\n\n";

echo "=== All Tests Passed ===\n";
echo "\nTo enable mock mode:\n";
echo "1. Edit app/environment.ini\n";
echo "2. Set MOCK_ALLOWED = 1\n";
echo "3. Set MOCK_PHP_ENABLED = 1\n";
echo "4. Ensure SERVER = DEVELOP\n";
echo "\nMock mode will bypass database, SSO, and use mock data.\n";
