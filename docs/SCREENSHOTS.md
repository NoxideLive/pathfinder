# Mock Mode Screenshots

This document provides visual examples of the Pathfinder UI mock/dev mode in action.

## Overview

The mock mode feature allows developers to run the Pathfinder UI without a backend server by intercepting AJAX requests and returning mock data. This documentation showcases the visual appearance and console output when mock mode is active.

## Screenshot 1: Mock Mode Demo Page

![Mock Mode Demo Page](https://github.com/user-attachments/assets/7e56a10e-2b8d-4747-85ed-ea5cc16c1e7f)

This screenshot shows the mock mode demo page with:
- **Green status banner** indicating mock mode is enabled (`MOCK_ALLOWED = 1`)
- **Console simulation** showing the color-coded logging format:
  - Red `[MOCK MODE ENABLED]` banner
  - Red `[MOCK]` prefix for each intercepted request
  - Teal HTTP methods (GET/POST)
  - Light teal URLs
  - Green response objects
- **Test buttons** for triggering mock API requests
- **Instructions** on how to enable mock mode

## Screenshot 2: Mock Request in Action

![Mock Request Result](https://github.com/user-attachments/assets/aabb512b-85b7-4333-8082-bfcd67fa7614)

This screenshot shows the result after clicking the "Test initData" button:
- **Success message** displayed in green with checkmark
- **Request details** showing URL (`/api/Map/initData`) and method (GET)
- **Mock response** displayed as formatted JSON
- **Console output** visible in the background showing the intercepted request

## Console Output Details

When mock mode is active, the browser console displays:

### 1. Activation Banner
```
[MOCK MODE ENABLED]
```
- **Color**: White text on red background (#ff6b6b)
- **Style**: Bold, with padding
- **Visibility**: Appears immediately when mock mode initializes

### 2. Intercepted Requests
```
[MOCK] GET /api/Map/initData
▼ Object {timer: {...}, mapTypes: {...}, mapScopes: {...}}

[MOCK] POST /api/Map/updateData
▼ Object {mapData: Array(1)}
```
- **[MOCK] prefix**: Red (#ff6b6b), bold
- **HTTP Method**: Teal (#4ecdc4), bold
- **URL**: Light teal (#95e1d3)
- **Response**: Expandable object in browser's default formatting

### 3. Production Safety Warning (when blocked)
When `MOCK_ALLOWED = 0`:
```
⚠️ [MOCK] Mock mode is disabled in this environment.
Set MOCK_ALLOWED=1 in environment.ini to enable.
```
- **Color**: Orange/yellow (browser's warning style)
- **Icon**: Warning triangle
- **Visibility**: Appears when attempting to enable mock mode in production

## Key Visual Indicators

### ✅ Mock Mode Enabled
- Green status banner at top of page
- Red `[MOCK MODE ENABLED]` in console
- Color-coded request logs in console
- Mock data returned instantly (no loading delays)

### ❌ Mock Mode Disabled
- No console banner
- Standard error messages for API failures
- Real network requests visible in Network tab
- Authentication errors if no backend available

## How to View These in Your Browser

1. **Enable Mock Mode**:
   - Set `MOCK_ALLOWED = 1` in `app/environment.ini`
   - Add `?mockMode=true` to your URL
   - Or set via localStorage: `localStorage.setItem('pathfinder_mock_mode', 'true')`

2. **Open Developer Tools**:
   - Press `F12` (Windows/Linux) or `Cmd+Option+I` (Mac)
   - Click the "Console" tab
   - Look for the red `[MOCK MODE ENABLED]` banner

3. **Interact with the UI**:
   - Navigate through different pages
   - Watch the console for intercepted requests
   - Each API call will show as `[MOCK] METHOD /api/endpoint`

4. **Verify Mock Data**:
   - Click on the expandable objects in console
   - View the mock response data structure
   - Compare with expected API response format

## Console Color Reference

| Element | Hex Color | CSS Style | Purpose |
|---------|-----------|-----------|---------|
| Banner Background | `#ff6b6b` | `background: #ff6b6b` | High visibility activation indicator |
| Banner Text | `#ffffff` | `color: white` | Contrast for readability |
| [MOCK] Prefix | `#ff6b6b` | `color: #ff6b6b; font-weight: bold` | Request identifier |
| HTTP Method | `#4ecdc4` | `color: #4ecdc4; font-weight: bold` | Method type (GET/POST) |
| URL Path | `#95e1d3` | `color: #95e1d3` | Endpoint path |
| Success Messages | `#98c379` | `color: #98c379` | Positive feedback |
| Warning Messages | Browser default | Browser's warning style | Production blocking alerts |

## Browser Compatibility

These visual elements are consistent across all modern browsers:
- ✅ Chrome/Edge (Chromium-based)
- ✅ Firefox
- ✅ Safari
- ✅ Opera
- ✅ Brave

## Additional Resources

- **Full Documentation**: [MOCK_MODE.md](../MOCK_MODE.md)
- **Architecture Details**: [ARCHITECTURE.md](../ARCHITECTURE.md)
- **Interactive Demo**: [mock-mode-demo.html](../mock-mode-demo.html)
- **Example Page**: [mock-mode-example.html](../mock-mode-example.html)
- **Test Page**: [mock-mode-test.html](../mock-mode-test.html)

## Taking Your Own Screenshots

To capture screenshots in your environment:

1. Enable mock mode in your Pathfinder instance
2. Open the page you want to capture
3. Open DevTools (F12) and position the Console tab
4. Use one of these methods:
   - **Browser screenshot**: Right-click → "Capture Screenshot" (Chrome)
   - **OS screenshot**: Use PrintScreen or Cmd+Shift+4
   - **DevTools screenshot**: Cmd+Shift+P → "Capture screenshot"
5. Save to `docs/screenshots/` directory

## Screenshot Files

Current screenshots in this repository:
- `mock-mode-demo-page.png` - Full demo page showing mock mode UI
- `mock-mode-with-request.png` - Demo page with successful mock request

---

**Note**: These screenshots demonstrate the visual appearance of mock mode. The actual Pathfinder application will have similar console output when mock mode is enabled, but with the full Pathfinder UI instead of this demo page.
