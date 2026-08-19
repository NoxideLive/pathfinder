# PHP-Level Mock Mode

This directory contains mock data files for running Pathfinder in development mode without external services (MySQL, EVE SSO, ESI API).

## Overview

When `MOCK_PHP_ENABLED=1` is set in `app/environment.ini`, the application will:
- Use mock database queries instead of MySQL
- Bypass EVE SSO authentication
- Return mock data for templates and API calls

## Enabling Mock Mode

1. Edit `app/environment.ini` in the `[ENVIRONMENT.DEVELOP]` section:
   ```ini
   MOCK_ALLOWED = 1
   MOCK_PHP_ENABLED = 1
   ```

2. Ensure `SERVER = DEVELOP` is set in `app/environment.ini`

3. Start the PHP server:
   ```bash
   php -S localhost:8000
   ```

## Mock Data Files

- **character.json** - Mock EVE character data
- **session.json** - Mock session data
- **queries.json** - Mock database query results
- **templates.json** - Mock template variables

## Security

⚠️ **IMPORTANT**: Mock mode is **ONLY** available when:
- `SERVER = DEVELOP` (from environment.ini)
- `MOCK_ALLOWED = 1`
- `MOCK_PHP_ENABLED = 1`

Mock mode will **NEVER** activate in production (`SERVER = PRODUCTION`).

## Console Warnings

When mock mode is active, warning messages are logged to PHP error_log:
```
[PATHFINDER MOCK MODE] PHP-level mocking is ENABLED. This should NEVER be active in production!
```

## Implementation Details

### Mock Classes

Located in `app/Lib/Mock/`:
- **MockDetector.php** - Detects if mock mode should be active
- **MockDatabase.php** - Mock database implementation
- **MockAuth.php** - Mock authentication bypass
- **MockDataProvider.php** - Centralized mock data provider

### Modified Files

- `app/Lib/Db/Pool.php` - Returns MockDatabase when mock mode is active
- `app/Controller/AccessController.php` - Bypasses login checks in mock mode
- `app/Controller/Ccp/Sso.php` - Bypasses SSO in mock mode
- `app/Controller/Controller.php` - Injects mock data into templates

## Customizing Mock Data

Edit the JSON files in `app/mock/php/data/` to customize:
- Character information
- Database query results
- Template variables

## Limitations

- Mock mode provides basic functionality only
- Not all database queries are mocked
- Some advanced features may not work
- External API calls (ESI) are not fully mocked at PHP level

## Troubleshooting

### Mock mode not activating

1. Check `SERVER = DEVELOP` in environment.ini
2. Verify `MOCK_ALLOWED = 1` and `MOCK_PHP_ENABLED = 1`
3. Check PHP error logs for mock mode warnings

### Database errors

Add mock query responses to `queries.json` for specific queries.

### Authentication issues

Verify `character.json` and `session.json` contain valid mock data.
