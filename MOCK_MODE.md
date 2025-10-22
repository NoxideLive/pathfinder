# PHP Mock Mode - Quick Reference

This project now includes a PHP-level mock mode for development without external dependencies.

## What is Mock Mode?

Mock mode allows you to run the Pathfinder application without:
- MySQL database
- EVE Online SSO authentication
- External API calls (ESI)

Perfect for:
- Local development
- Testing features
- Working offline
- Rapid iteration

## Quick Start

### Enable Mock Mode

Edit `app/environment.ini`:
```ini
[ENVIRONMENT.DEVELOP]
SERVER = DEVELOP
MOCK_ALLOWED = 1
MOCK_PHP_ENABLED = 1
```

### Verify Setup

```bash
php test-mock-mode.php
```

### Start Development Server

```bash
php -S localhost:8000
```

## Documentation

- **[MOCK_MODE_USAGE.md](MOCK_MODE_USAGE.md)** - Comprehensive usage guide
- **[app/mock/README.md](app/mock/README.md)** - Implementation details
- **[test-mock-mode.php](test-mock-mode.php)** - Validation test script

## Security

✅ Mock mode is **SECURE BY DEFAULT**:
- Only works when `SERVER = DEVELOP`
- Cannot be enabled in production
- Console warnings when active
- Production attempts are logged

## Support

Mock mode was implemented according to the plan in [Issue #6](https://github.com/NoxideLive/pathfinder/issues/6).

For detailed information, see:
- Usage guide: `MOCK_MODE_USAGE.md`
- Implementation: `app/mock/README.md`
