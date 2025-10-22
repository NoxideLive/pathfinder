# Mock/Dev Mode for Pathfinder UI

## Overview

The Mock Mode feature allows developers to run and test the Pathfinder UI without requiring a live backend server. This is useful for:

- Frontend development without backend dependencies
- Testing UI components and interactions
- Demonstrating features without a full setup
- Creating reproducible test scenarios
- Rapid prototyping and iteration

## Architecture

The mock mode system consists of three main components:

### 1. Mock Data Loader (`js/app/mock/mockDataLoader.js`)
- Loads and manages mock data from JSON files
- Provides utility functions for data access
- Supports delay simulation and failure testing
- Allows dynamic addition of custom mock data

### 2. Mock Interceptor (`js/app/mock/mockInterceptor.js`)
- Intercepts all AJAX requests to `/api/*` endpoints
- Routes requests to mock data instead of real backend
- Simulates network delays for realistic testing
- Supports failure simulation for error handling tests
- Provides console logging for debugging

### 3. Mock Data (`js/app/mock/data/*.json`)
- JSON files containing sample data for various API endpoints
- Easy to extend with new endpoints
- Mirrors actual API response structures

## How to Enable Mock Mode

### Method 1: URL Parameter (Recommended for quick testing)
Add `?mockMode=true` to the URL:
```
http://localhost/pathfinder/?mockMode=true
```

To disable:
```
http://localhost/pathfinder/?mockMode=false
```

### Method 2: localStorage (Persistent across sessions)
Open browser console and run:
```javascript
localStorage.setItem('pathfinder_mock_mode', 'true');
```

Then refresh the page. To disable:
```javascript
localStorage.removeItem('pathfinder_mock_mode');
```

### Method 3: Global Configuration (For development builds)
Set the global variable before the app loads (in HTML or before scripts load):
```html
<script>
    window.PATHFINDER_MOCK_MODE = true;
</script>
```

## Configuration

You can configure mock mode behavior using the browser console:

```javascript
// Access the mock interceptor (available in browser console when mock mode is active)
// Note: MockInterceptor is loaded as an AMD module, so you need to access it through the app

// To configure after initialization, you can set properties directly:
// Example configurations (these would need to be set before initialization):

// Disable delay simulation
MockInterceptor.configure({ simulateDelay: false });

// Adjust delay range (in milliseconds)
MockInterceptor.configure({ 
    delayMin: 200, 
    delayMax: 1000 
});

// Enable request failures (10% failure rate)
MockInterceptor.configure({ failureRate: 0.1 });

// Disable request logging
MockInterceptor.configure({ logRequests: false });
```

## Extending Mock Data

### Adding New Endpoints

1. Create a new JSON file in `js/app/mock/data/`:
   ```json
   {
     "yourData": "example value",
     "moreData": [1, 2, 3]
   }
   ```

2. Update `mockDataLoader.js` to include your new file:
   ```javascript
   define([
       'jquery',
       'text!app/mock/data/initData.json',
       'text!app/mock/data/serverStatus.json',
       'text!app/mock/data/userData.json',
       'text!app/mock/data/mapData.json',
       'text!app/mock/data/yourNewFile.json'  // Add this line
   ], ($, initDataJSON, serverStatusJSON, userDataJSON, mapDataJSON, yourNewFileJSON) => {
       // ...
       let mockData = {
           initData: JSON.parse(initDataJSON),
           serverStatus: JSON.parse(serverStatusJSON),
           userData: JSON.parse(userDataJSON),
           mapData: JSON.parse(mapDataJSON),
           yourNewData: JSON.parse(yourNewFileJSON)  // Add this line
       };
       // ...
   ```

3. Map your endpoint in the `getMockData` function:
   ```javascript
   let getMockData = (endpoint) => {
       const endpointMap = {
           '/api/Map/initData': 'initData',
           '/api/User/getEveServerStatus': 'serverStatus',
           '/api/Map/updateUserData': 'userData',
           '/api/Map/updateData': 'mapData',
           '/api/YourController/yourAction': 'yourNewData'  // Add this line
       };
       // ...
   };
   ```

### Customizing Mock Data at Runtime

You can add or override mock data dynamically:

```javascript
// This would need to be called through the app's module system
MockDataLoader.addMockData('/api/Custom/endpoint', {
    customField: 'custom value',
    data: [1, 2, 3]
});
```

## Current Mock Data

The following endpoints are currently mocked:

| Endpoint | Description | Data File |
|----------|-------------|-----------|
| `/api/Map/initData` | Application initialization data | `initData.json` |
| `/api/User/getEveServerStatus` | EVE Online server status | `serverStatus.json` |
| `/api/User/getCookieCharacter` | Character data from cookie | `userData.json` |
| `/api/Map/updateUserData` | User data updates | `userData.json` |
| `/api/Map/updateData` | Map data updates | `mapData.json` |

Unmapped endpoints will return a generic success response:
```json
{
    "status": "success",
    "message": "Mock response for [endpoint]"
}
```

## Development Workflow

### Typical Development Session

1. Enable mock mode using URL parameter or localStorage
2. Develop and test your UI changes
3. Check browser console for mock request logs
4. Add new mock data as needed for new features
5. Test with delay simulation enabled for realistic behavior
6. Test error scenarios with failure simulation

### Console Output

When mock mode is active, you'll see:
- A prominent banner indicating mock mode is enabled
- Colored logs for each intercepted request showing:
  - HTTP method
  - Endpoint URL
  - Response data

Example console output:
```
[MOCK MODE ENABLED]
[MOCK] GET /api/Map/initData {...}
[MOCK] POST /api/Map/updateData {...}
```

## Testing Error Scenarios

Enable failure simulation to test error handling:

```javascript
MockInterceptor.configure({ failureRate: 0.2 }); // 20% of requests will fail
```

Failed requests will return a 500 error with message:
```
Internal Server Error (Simulated)
```

## Best Practices

1. **Keep mock data realistic**: Use data structures that match actual API responses
2. **Version your mock data**: Keep mock data in sync with API changes
3. **Document custom endpoints**: Add comments when adding new mock endpoints
4. **Test both modes**: Ensure your code works with both mock and real data
5. **Use delay simulation**: Test with delays enabled to catch timing issues
6. **Commit mock data**: Include mock data in version control for team collaboration

## Troubleshooting

### Mock mode not activating
- Check browser console for errors
- Verify RequireJS is loading the mock modules
- Clear localStorage and try again
- Check that URL parameter is exactly `mockMode=true`

### Mock data not loading
- Verify JSON files are valid (use a JSON validator)
- Check browser Network tab for 404 errors on JSON files
- Ensure paths in `mockDataLoader.js` are correct

### Requests not being intercepted
- Verify requests are going to `/api/*` endpoints
- Check that `MockInterceptor.init()` is called before AJAX requests
- Look for JavaScript errors in console

### Need to disable mock mode quickly
Add `?mockMode=false` to URL or run in console:
```javascript
localStorage.removeItem('pathfinder_mock_mode');
location.reload();
```

## Future Enhancements

Potential improvements to the mock system:

- **Mock Data Generator**: Tool to automatically generate mock data from API schemas
- **Scenario Management**: Save and load different mock data scenarios
- **Request Recording**: Record real API responses to create mock data
- **Visual Mock Manager**: UI for enabling/disabling and configuring mock mode
- **Advanced Filtering**: Mock only specific endpoints while using real backend for others
- **Mock Data Validation**: Ensure mock data matches API schema

## Contributing

When adding new features that require API endpoints:

1. Create corresponding mock data files
2. Update the endpoint mapping in `mockDataLoader.js`
3. Test your feature with mock mode enabled
4. Document any new endpoints in this file
5. Commit mock data with your feature changes

## Support

If you encounter issues with mock mode:

1. Check the browser console for errors
2. Review this documentation
3. Check that your mock data JSON is valid
4. Verify RequireJS module paths are correct
5. Report issues with detailed console output

---

**Note**: Mock mode is for development and testing only. Never use mock mode in production environments.
