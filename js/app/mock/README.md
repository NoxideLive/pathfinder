# Mock Mode Implementation

This directory contains the mock/dev mode implementation for Pathfinder UI development.

## Structure

```
mock/
├── README.md               (This file)
├── mockInterceptor.js      (AJAX request interceptor)
├── mockDataLoader.js       (Mock data management)
└── data/                   (Mock data files)
    ├── initData.json       (App initialization data)
    ├── serverStatus.json   (Server status data)
    ├── userData.json       (User/character data)
    └── mapData.json        (Map data with systems/connections)
```

## Quick Start

### Enable Mock Mode
Add `?mockMode=true` to your URL:
```
http://localhost/pathfinder/?mockMode=true
```

### Check Console
When mock mode is active, you'll see:
```
[MOCK MODE ENABLED]
[MOCK] GET /api/Map/initData {...}
[MOCK] POST /api/Map/updateData {...}
```

## How It Works

1. **Initialization**: `MockInterceptor.init()` is called in `login.js` and `mappage.js`
2. **Detection**: Checks URL param, localStorage, or global config
3. **Interception**: Overrides `$.ajax` to intercept API requests
4. **Routing**: Maps requests to mock data files
5. **Response**: Returns mock data with simulated delays

## Components

### mockInterceptor.js
- Detects if mock mode should be enabled
- Intercepts AJAX requests to `/api/*`
- Simulates network delays and failures
- Logs requests to console
- Provides configuration methods

### mockDataLoader.js
- Loads JSON mock data files
- Maps endpoints to mock data
- Returns deep copies of data
- Provides utility functions for delays and failures

### data/*.json
- Static mock data files
- One file per logical data group
- Easy to edit and maintain
- Version controlled

## Adding New Endpoints

1. **Create JSON file** in `data/` directory:
   ```json
   {
     "yourField": "value",
     "data": [...]
   }
   ```

2. **Update mockDataLoader.js**:
   ```javascript
   // Import the file
   define([
       ...,
       'text!app/mock/data/yourFile.json'
   ], (..., yourFileJSON) => {
       
       // Parse it
       let mockData = {
           ...,
           yourData: JSON.parse(yourFileJSON)
       };
       
       // Map endpoint
       let getMockData = (endpoint) => {
           const endpointMap = {
               ...,
               '/api/Your/endpoint': 'yourData'
           };
           ...
       };
   });
   ```

3. **Test**: Make request to your endpoint, check console

## Configuration

All mock mode behavior can be configured:

```javascript
MockInterceptor.configure({
    enabled: true,              // Enable/disable
    simulateDelay: true,        // Simulate network delays
    delayMin: 100,             // Min delay (ms)
    delayMax: 500,             // Max delay (ms)
    failureRate: 0,            // Failure probability (0-1)
    logRequests: true          // Console logging
});
```

## Current Mock Endpoints

| Endpoint | Data File | Description |
|----------|-----------|-------------|
| `/api/Map/initData` | `initData.json` | Application initialization |
| `/api/User/getEveServerStatus` | `serverStatus.json` | Server status |
| `/api/User/getCookieCharacter` | `userData.json` | Character from cookie |
| `/api/Map/updateUserData` | `userData.json` | User data updates |
| `/api/Map/updateData` | `mapData.json` | Map data updates |

Unmapped endpoints return: `{ status: 'success', message: 'Mock response for [endpoint]' }`

## Activation Methods

### Method 1: URL Parameter (Recommended)
```
?mockMode=true
```
- Quickest method
- No code changes
- Easy to share

### Method 2: localStorage (Persistent)
```javascript
localStorage.setItem('pathfinder_mock_mode', 'true');
```
- Persists across sessions
- No URL modification needed
- Good for extended development

### Method 3: Global Config (Development Builds)
```javascript
window.PATHFINDER_MOCK_MODE = true;
```
- Set before app loads
- Good for development builds
- Can be in HTML or config file

## Debugging

### Enable Logging
```javascript
MockInterceptor.configure({ logRequests: true });
```

### Disable Delays
```javascript
MockInterceptor.configure({ simulateDelay: false });
```

### Test Failures
```javascript
MockInterceptor.configure({ failureRate: 0.1 }); // 10% failures
```

## Best Practices

1. **Keep mock data realistic** - Match actual API response structure
2. **Version control mock data** - Include in commits
3. **Document new endpoints** - Update this README
4. **Test both modes** - Ensure code works with real and mock data
5. **Use delays** - Catch timing issues early
6. **Update with API changes** - Keep mock data in sync

## Documentation

For complete documentation, see:
- **[MOCK_MODE.md](../../MOCK_MODE.md)** - Comprehensive guide
- **[ARCHITECTURE.md](../../ARCHITECTURE.md)** - Architecture diagrams
- **[IMPLEMENTATION_SUMMARY.md](../../IMPLEMENTATION_SUMMARY.md)** - Technical details
- **[CHECKLIST.md](../../CHECKLIST.md)** - Implementation checklist

## Support

If you encounter issues:
1. Check browser console for errors
2. Verify mock mode is enabled (check console banner)
3. Ensure JSON files are valid
4. Check endpoint mapping in `mockDataLoader.js`
5. Review documentation linked above

## Examples

See:
- **[mock-mode-example.html](../../mock-mode-example.html)** - Interactive guide
- **[mock-mode-test.html](../../mock-mode-test.html)** - Testing tool

---

**Note**: Mock mode is for development only. Never use in production.
