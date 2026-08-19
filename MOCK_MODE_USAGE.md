# PHP Mock Mode - Usage Guide

This guide explains how to use the PHP-level mock mode for development.

## Quick Start

### 1. Enable Mock Mode

Edit `app/environment.ini` and update the `[ENVIRONMENT.DEVELOP]` section:

```ini
[ENVIRONMENT.DEVELOP]
SERVER = DEVELOP
MOCK_ALLOWED = 1
MOCK_PHP_ENABLED = 1
```

### 2. Verify Setup

Run the test script to ensure everything is configured correctly:

```bash
php test-mock-mode.php
```

Expected output:
```
=== Mock Mode Test Script ===
Test 1: Checking mock files...
  ✓ All files exist
Test 2: Validating JSON files...
  ✓ All JSON files are valid
Test 3: Checking PHP syntax...
  ✓ All PHP files have valid syntax
Test 4: Checking environment.ini configuration...
  ✓ Environment configuration looks good
=== All Tests Passed ===
```

### 3. Start the Development Server

```bash
php -S localhost:8000
```

The server will now run without requiring MySQL or EVE SSO.

## What Gets Mocked

When mock mode is enabled, the following are bypassed/mocked:

### Database Layer
- MySQL connections are replaced with `MockDatabase`
- Database queries return mock data from JSON files
- No actual database connection is established

### Authentication
- EVE SSO login is bypassed
- Mock character session is automatically created
- No CCP OAuth flow required

### Template Data
- Mock data is injected into template variables
- Character, corporation, alliance info comes from mock files
- Server status, maps, and other data use mock values

## Mock Data Files

All mock data is stored in `app/mock/php/data/`:

### character.json
Contains mock EVE character information:
```json
{
  "CharacterID": 123456789,
  "CharacterName": "Mock Character",
  "corporation_id": 98000001,
  "corporation_name": "Mock Corporation"
}
```

### session.json
Contains mock session data:
```json
{
  "character_id": 123456789,
  "logged_in": true,
  "login_time": 1234567890
}
```

### queries.json
Contains mock database query results:
```json
{
  "tables": ["sessions", "character", "user"],
  "row_counts": {
    "sessions": 1,
    "character": 1
  }
}
```

### templates.json
Contains mock template variables:
```json
{
  "character": {...},
  "maps": [],
  "serverStatus": {...}
}
```

## Customizing Mock Data

### Adding a New Mock Character

Edit `app/mock/php/data/character.json`:

```json
{
  "CharacterID": 987654321,
  "CharacterName": "Your Character Name",
  "corporation_id": 98000001,
  "corporation_name": "Your Corp",
  "alliance_id": 99000001,
  "alliance_name": "Your Alliance"
}
```

### Adding Mock Database Query Results

Edit `app/mock/php/data/queries.json` and add query patterns:

```json
{
  "tables": ["your_table"],
  "row_counts": {
    "your_table": 10
  },
  "custom_queries": {
    "SELECT * FROM your_table": [
      {"id": 1, "name": "test"}
    ]
  }
}
```

### Adding Mock Template Data

Edit `app/mock/php/data/templates.json`:

```json
{
  "your_variable": {
    "key": "value"
  }
}
```

## Console Warnings

When mock mode is active, warning messages appear in PHP error logs:

```
[PATHFINDER MOCK MODE] PHP-level mocking is ENABLED. This should NEVER be active in production!
```

These warnings help prevent accidentally running mock mode in production.

## Debugging Mock Mode

### Check if Mock Mode is Active

The `MockDetector::isMockMode()` method determines if mock mode should be active:

1. Checks `SERVER = DEVELOP`
2. Checks `MOCK_ALLOWED = 1`
3. Checks `MOCK_PHP_ENABLED = 1`

All three conditions must be true.

### Debug Database Queries

Enable query logging in `MockDatabase::exec()`:

```php
public function exec($cmds, $args = null, $ttl = 0, $log = true, $stamp = false) {
    // Set $log = true to see all queries in error_log
```

### Debug Authentication

Check PHP error logs for mock authentication events:

```
[PATHFINDER MOCK MODE] PHP-level mocking is ENABLED...
```

## Limitations

Mock mode has some limitations:

1. **Limited Query Support**: Only common query patterns are mocked
2. **No Real Data**: All data is static from JSON files
3. **Basic Functionality**: Advanced features may not work
4. **No External APIs**: ESI calls are not mocked at PHP level

## Troubleshooting

### Mock Mode Not Activating

**Problem**: Mock mode doesn't seem to be active

**Solutions**:
1. Verify `SERVER = DEVELOP` in environment.ini
2. Verify `MOCK_ALLOWED = 1`
3. Verify `MOCK_PHP_ENABLED = 1`
4. Check PHP error logs for mock warnings
5. Run `php test-mock-mode.php` to verify setup

### Database Errors

**Problem**: Errors about missing database tables or queries

**Solutions**:
1. Add mock responses to `queries.json`
2. Add table names to the `tables` array
3. Add row counts to `row_counts`

### Authentication Fails

**Problem**: Still redirected to SSO login

**Solutions**:
1. Verify mock mode is active (check error logs)
2. Verify `character.json` exists and is valid
3. Verify `session.json` exists and is valid
4. Clear browser cookies and try again

### Template Variables Missing

**Problem**: Template shows undefined variables

**Solutions**:
1. Add variables to `templates.json`
2. Check that `MockDataProvider::getTemplateData()` includes your variable
3. Verify the variable is being injected in `Controller::injectMockData()`

## Security Notes

⚠️ **IMPORTANT SECURITY FEATURES**:

- Mock mode **ONLY** works with `SERVER = DEVELOP`
- Mock mode **CANNOT** be enabled in production
- Console warnings alert when mock mode is active
- All mock checks happen server-side

## Development Workflow

### Typical Development Flow

1. Enable mock mode in `environment.ini`
2. Run `php test-mock-mode.php` to verify
3. Start PHP dev server: `php -S localhost:8000`
4. Develop features without external dependencies
5. Test with real services before deployment
6. Disable mock mode for production

### Best Practices

1. **Keep Mock Data Updated**: Update JSON files when schema changes
2. **Test Without Mocks**: Periodically test with real database/SSO
3. **Document Changes**: Update mock data when adding features
4. **Version Control**: Commit mock data files for team consistency

## Advanced Usage

### Extending MockDatabase

To add support for specific queries, edit `app/Lib/Mock/MockDatabase.php`:

```php
public function exec($cmds, $args = null, ...) {
    $query = is_array($cmds) ? implode(';', $cmds) : $cmds;
    
    // Add custom query patterns
    if(preg_match('/YOUR_PATTERN/i', $query)){
        return $this->mockData['your_custom_data'] ?? [];
    }
    
    // ... existing code ...
}
```

### Custom Mock Data Providers

Create custom providers in `app/Lib/Mock/`:

```php
<?php
namespace Exodus4D\Pathfinder\Lib\Mock;

class CustomMockProvider extends \Prefab {
    public static function getCustomData() : array {
        // Your custom mock data logic
    }
}
```

## Getting Help

If you encounter issues:

1. Run `php test-mock-mode.php` to diagnose
2. Check PHP error logs for warnings/errors
3. Review `app/mock/README.md` for details
4. Check the implementation in `app/Lib/Mock/`

## Summary

Mock mode enables development without external services:
- ✅ No MySQL required
- ✅ No EVE SSO required
- ✅ No external API calls required
- ✅ Fast development iteration
- ✅ Safe for development (cannot activate in production)
