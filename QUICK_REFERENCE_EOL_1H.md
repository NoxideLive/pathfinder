# Quick Reference: EOL 1h Critical Feature

## What Changed

### Context Menu (Right-click on wormhole connection)
```
BEFORE:
☰ toggle EOL
  ⚠ preserve mass
  🔄 rolling
  
AFTER:
☰ toggle EOL (4h)      ← Renamed for clarity, still purple/pink
☰ toggle EOL (1h)      ← NEW! Red color for critical warning
  ⚠ preserve mass
  🔄 rolling
```

### Visual Appearance

**Connection Colors:**
- **Normal wormhole**: Gray
- **EOL 4h** (existing): Purple/Pink (#d747d6)
- **EOL 1h** (NEW): Red (#d9534f)
- **Both EOL flags**: Shows both purple and red

**Map Overlay Icons:**
- **⌛ EOL icon**: Shows connections with 4h EOL status (hourglass icon)
- **❗ EOL Critical icon**: Shows connections with 1h EOL status (exclamation circle icon) - NEW!

## Technical Details

### Files Modified
1. `app/Model/Pathfinder/ConnectionModel.php` - Backend model (1 line added)
2. `js/app/init.js` - Connection type definition (3 lines added)
3. `js/app/map/contextmenu.js` - Menu options (1 line added + 1 renamed)
4. `js/app/map/map.js` - Toggle handling (4 sections modified)
5. `js/app/map/overlay/overlay.js` - Overlay configuration (35 lines added)
6. `js/app/map/overlay/util.js` - Overlay ID constant (1 line added)
7. `sass/layout/_map.scss` - Connection & overlay styling (8 lines added)
8. `sass/layout/_main.scss` - Border styling (8 lines added)
9. `public/css/v2.2.3/pathfinder.css` - Compiled CSS (auto-generated)

### Connection Type Values
```javascript
// Can have any combination:
type: []                              // No EOL status
type: ['wh_eol']                      // 4h EOL only (purple)
type: ['wh_eol_critical']             // 1h EOL only (red)
type: ['wh_eol', 'wh_eol_critical']   // Both statuses (purple + red)
```

## Testing Checklist

### Basic Functionality
- [ ] Right-click wormhole → Both EOL options appear
- [ ] Click "toggle EOL (4h)" → Connection turns purple
- [ ] Click "toggle EOL (1h)" → Connection turns red
- [ ] Enable both → Both colors visible
- [ ] Disable one → Other color remains
- [ ] Non-wormhole connections → No EOL options shown

### Visual Verification
- [ ] Purple color matches existing EOL appearance
- [ ] Red color is clearly distinguishable from purple
- [ ] Map overlay shows two separate icons for EOL statuses
- [ ] Hovering overlay icons shows time remaining
- [ ] Connection tooltip shows correct types

### Persistence
- [ ] Set EOL 1h → Save map → Reload → Status persists
- [ ] Set both EOL types → Reload → Both persist
- [ ] Import/Export map → EOL critical status preserved

### API/Integration
- [ ] Connection API endpoint returns 'wh_eol_critical' in type array
- [ ] Map export includes new type
- [ ] No errors in browser console

## Migration Notes

**No database migration required** - The connection type is stored as JSON array in existing `type` column, which already supports multiple values.

**No API breaking changes** - The new type is additive only. Clients that don't recognize it will simply ignore it.

**No configuration changes required** - Feature is automatically available after deployment.

## Color Reference

```scss
// Existing
$pink-dark: #d747d6;     // EOL 4h color

// New  
$red: #d9534f;           // EOL 1h critical color
$red-dark: #a52521;      // EOL 1h overlay background
```

## Icon Reference

```javascript
// Existing
fa-hourglass-end         // EOL 4h icon

// New
fa-exclamation-circle    // EOL 1h critical icon
```
