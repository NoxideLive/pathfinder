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

### Option 1: Docker (Recommended)

**Easiest way - No configuration needed!**

```bash
# Start with one command
./start-mock.sh

# Access the application
open http://localhost:8000/mock-mode-demo.php
```

See **[DOCKER_MOCK_MODE.md](DOCKER_MOCK_MODE.md)** for full Docker documentation.

### Option 2: Manual Setup

Edit `app/environment.ini`:
```ini
[ENVIRONMENT.DEVELOP]
SERVER = DEVELOP
MOCK_ALLOWED = 1
MOCK_PHP_ENABLED = 1
```

Verify and start:
```bash
php test-mock-mode.php
php -S localhost:8000
```

## Documentation

- **[DOCKER_MOCK_MODE.md](DOCKER_MOCK_MODE.md)** - Docker setup guide (NEW!)
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
