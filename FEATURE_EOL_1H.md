# EOL 1h Critical Feature Implementation

## Summary
This implementation adds support for tracking wormholes with less than 1 hour remaining until collapse (EOL 1h), as introduced in EVE Online Patch 23.01.

## Changes Made

### Backend (PHP)
1. **ConnectionModel.php**
   - Added `wh_eol_critical` to the connection type whitelist
   - This allows the new type to be stored and validated in the database

### Frontend (JavaScript)
1. **init.js**
   - Added `wh_eol_critical` connection type definition with CSS class `pf-map-connection-wh-eol-critical`

2. **contextmenu.js**
   - Added new menu option "toggle EOL (1h)" for the critical EOL state
   - Renamed existing option to "toggle EOL (4h)" for clarity

3. **map.js**
   - Added `wh_eol_critical` to the toggle types array
   - Added handler for `wh_eol_critical` action in the context menu switch statement
   - Added visibility rules for hiding/showing the EOL critical option based on connection scope
   - Added active state tracking for the EOL critical toggle

4. **overlay/util.js**
   - Added `connectionOverlayEolCriticalId` constant for the new overlay identifier

5. **overlay/overlay.js**
   - Added `connectionEolCritical` overlay configuration
   - Uses exclamation-circle icon to distinguish from regular EOL (hourglass-end)
   - Positioned at location 0.15 to avoid overlap with regular EOL overlay (0.25)
   - Shows time remaining when hovering over the overlay icon

### Styling (SASS/CSS)
1. **_map.scss**
   - Added `pf-map-connection-wh-eol-critical` to z-index group
   - Added styling for critical EOL connections using red color ($red: #d9534f)
   - Added `.eol-critical` overlay label styling with red background

2. **_main.scss**
   - Added border color styling for `pf-map-connection-wh-eol-critical` class
   - Added text styling for `pf-wh-eol-critical` fake connection class

## User Interface Changes

### Context Menu
When right-clicking a wormhole connection, users now see:
- **toggle EOL (4h)** - Purple/pink color, existing 4-hour EOL status
- **toggle EOL (1h)** - Red color, new 1-hour critical EOL status

Both options can be toggled independently, allowing connections to have:
- No EOL status
- EOL 4h only (purple)
- EOL 1h only (red)
- Both EOL 4h and EOL 1h (both colors shown)

### Visual Indicators
- **Regular EOL (4h)**: Purple/pink connection line color (#d747d6)
- **Critical EOL (1h)**: Red connection line color (#d9534f)
- **Overlay icons**: 
  - Regular EOL: Hourglass icon
  - Critical EOL: Exclamation circle icon

### Map Overlay
- Two separate overlay icons appear in the map info panel
- Hovering over each icon shows the time remaining for connections with that status
- Icons can be toggled on/off independently

## API/Data Integration
- The new `wh_eol_critical` type is automatically included in all API responses via the existing `getData()` method in ConnectionModel
- Connection type is stored as a JSON array in the database, supporting multiple simultaneous types
- No changes needed to existing integrations as the type system is extensible by design

## Backward Compatibility
- All existing EOL (4h) functionality remains completely unchanged
- Existing connections with `wh_eol` type continue to work exactly as before
- The new type is additive and doesn't affect any existing behavior

## Testing Recommendations
1. Create a new wormhole connection
2. Right-click and verify both "toggle EOL (4h)" and "toggle EOL (1h)" options appear
3. Toggle EOL (4h) - verify purple/pink color appears
4. Toggle EOL (1h) - verify red color appears
5. Toggle both - verify both colors are visible
6. Verify non-wormhole connections (stargate, jumpbridge, abyssal) don't show EOL options
7. Hover over map overlay icons - verify time displays correctly
8. Save and reload map - verify EOL states persist correctly

## Known Limitations
- The timestamp tracking (eolUpdated) is shared between both EOL types
- EVE Scout/Thera integration continues to map their 'critical' status to regular `wh_eol` (not affected by this change)
