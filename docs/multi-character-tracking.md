# Multi-Character Tracking

The Multi-Character Tracking feature allows users to monitor multiple characters from a single browser tab, eliminating the need to keep multiple tabs open for character tracking. This feature provides a centralized character management interface with cross-tab coordination and robust tab lifecycle management.

## Table of Contents

- [User Guide](#user-guide)
  - [How to Use](#how-to-use)
  - [Visual Indicators](#visual-indicators)
  - [Cross-Tab Coordination](#cross-tab-coordination)
  - [Tab Lifecycle Management](#tab-lifecycle-management)
- [Technical Implementation](#technical-implementation)
  - [Architecture Overview](#architecture-overview)
  - [File Structure](#file-structure)
  - [Data Flow](#data-flow)
  - [Storage System](#storage-system)
  - [Heartbeat System](#heartbeat-system)
- [Developer Guide](#developer-guide)
  - [Key Components](#key-components)
  - [API Reference](#api-reference)
  - [Extending the Feature](#extending-the-feature)

## User Guide

### How to Use

1. **Access Character Switcher**: Click on your character name in the header to open the character switcher popover
2. **Enable Tracking**: Use the checkboxes in the "Track" column to select which characters you want to monitor
3. **Visual Feedback**: The tracking counter badge appears next to your character name when multiple characters are tracked
4. **Current Character**: Your current character is automatically tracked and highlighted with "(current)" label

![Character Switch Popover Preview](https://github.com/user-attachments/assets/12ab21da-2867-4cf5-bc9c-dfe27fc2c6b0)

### Visual Indicators

- **Current Character**: Highlighted row with "(current)" label and pre-checked tracking
- **Tracking Counter**: Badge next to character name showing total tracked characters (when > 1)
- **Disabled Checkboxes**: Characters tracked in other tabs are grayed out with explanatory tooltips
- **Table Structure**: Clean layout with columns for Character image, Name, Track checkbox, and Actions

### Cross-Tab Coordination

The system prevents tracking conflicts by:
- Detecting when a character is tracked in another browser tab
- Disabling the tracking checkbox for characters already tracked elsewhere
- Providing visual feedback with tooltips explaining why a checkbox is disabled
- Automatically handling character switching conflicts with smart resolution

### Tab Lifecycle Management

The enhanced system now handles complex scenarios:

#### Tab Closing
- **Heartbeat System**: Each tab sends periodic "heartbeat" signals to indicate it's still active
- **Automatic Cleanup**: When a tab is closed, its heartbeat stops and the tracking state is automatically cleaned up
- **No Impact on Other Tabs**: Closing one tab doesn't affect tracking state in other open tabs

#### Browser Crashes
- **Orphan Detection**: When the browser restarts, the system detects "orphaned" tracking states from crashed tabs
- **Smart Recovery**: Old tracking states are automatically removed based on heartbeat timestamps
- **State Preservation**: Current session tracking state is preserved and restored properly

#### Character Switching Conflicts
- **Conflict Detection**: When switching to a character tracked in another tab, the system detects the conflict
- **Automatic Resolution**: Tracking is automatically transferred from the other tab to the current tab
- **User Notification**: Users receive informative notifications about conflict resolution

## Technical Implementation

### Architecture Overview

The multi-character tracking system is built on four core components:

1. **UI Layer**: Enhanced character switcher popover with tracking checkboxes
2. **State Management**: localStorage-based persistence with tab-specific keys
3. **Event System**: Real-time updates and cross-component communication
4. **Heartbeat System**: Tab lifecycle management and automatic cleanup

### File Structure

```
js/app/
├── page.js                     # Main page controller with tracking logic
├── util.js                     # Utility functions for state management
public/templates/
├── layout/header_map.html      # Header with tracking counter badge
├── tooltip/character_switch.html # Character switcher popover template
```

### Data Flow

```
1. Page Load
   ├── Initialize heartbeat system
   ├── Clean up dead tab states
   ├── Initialize current character tracking
   └── Update tracking counter

2. Character Switcher Popover
   ├── Render tracking checkboxes
   ├── Check cross-tab conflicts
   ├── Handle checkbox changes
   ├── Trigger tracking updates
   └── Handle character switching conflicts

3. State Management
   ├── Store per-tab character lists with metadata
   ├── Coordinate across browser tabs
   ├── Persist to localStorage
   └── Maintain heartbeat timestamps

4. Tab Lifecycle
   ├── Send periodic heartbeat signals
   ├── Detect inactive/closed tabs
   ├── Clean up orphaned states
   └── Handle conflict resolution
```

### Storage System

The tracking state is stored in localStorage using the following enhanced structure:

```javascript
// localStorage key: 'pf-character-tracking'
{
  "tab_123456": {
    "characters": [1001, 1002, 1003],
    "currentCharacter": 1001,
    "lastUpdate": 1632150000000
  },
  "tab_789012": {
    "characters": [1004, 1005],
    "currentCharacter": 1004,
    "lastUpdate": 1632150030000
  }
}

// localStorage key: 'pf-tab-heartbeats'
{
  "tab_123456": 1632150045000,  // Last heartbeat timestamp
  "tab_789012": 1632150048000
}
```

### Heartbeat System

**Key Features:**
- **Periodic Updates**: Each tab updates its heartbeat every 10 seconds
- **Activity Detection**: Tabs are considered active if heartbeat is within 30 seconds
- **Automatic Cleanup**: Dead tabs are cleaned up automatically on page load and periodically
- **Conflict Resolution**: Character switching conflicts are resolved automatically

**Key Features:**
- Tab-specific storage with metadata prevents conflicts
- Heartbeat-based lifecycle management for robust cleanup
- Cross-tab state coordination with conflict resolution
- Automatic orphan detection and cleanup
- Fallback error handling for all edge cases

## Developer Guide

### Key Components

#### 1. Character Tracking State (util.js)

Core functions for managing tracking state:

```javascript
// Get all tracking state
getCharacterTrackingState() -> Object

// Save tracking state
setCharacterTrackingState(state) -> void

// Get tracked characters for current tab
getTrackedCharacters() -> Array

// Update tracked characters for current tab
setTrackedCharacters(characterIds) -> void

// Check if character is tracked elsewhere
isCharacterTrackedElsewhere(characterId) -> boolean

// Handle character switching conflicts
handleCharacterSwitchConflict(characterId) -> Object
```

#### 2. Heartbeat System (util.js)

Tab lifecycle management functions:

```javascript
// Get/Set heartbeat state
getTabHeartbeatState() -> Object
setTabHeartbeatState(state) -> void

// Update current tab heartbeat
updateTabHeartbeat() -> void

// Get list of active tabs
getActiveTabs(maxAge) -> Array

// Clean up dead tabs
cleanupDeadTabs() -> void
```

#### 3. UI Integration (page.js)

Main page controller functions:

```javascript
// Initialize tracking for current character
initializeCharacterTracking() -> void

// Clean up tracking state using heartbeat system
cleanupTrackingState() -> void

// Update header tracking counter
updateCharacterTrackingCounter() -> void
```

#### 4. Popover Enhancement (character_switch.html)

Template structure with tracking column:

```html
<table class="table table-condensed">
  <thead>
    <tr>
      <th></th>
      <th>Character</th>
      <th class="text-center"><i class="fas fa-crosshairs" title="Track"></i></th>
      <th class="text-center">Actions</th>
    </tr>
  </thead>
  <!-- Character rows with tracking checkboxes -->
</table>
```

### API Reference

#### Utility Functions

**`Util.getCharacterTrackingState()`**
- Returns: `Object` - Complete tracking state from localStorage
- Description: Retrieves all tab tracking data with error handling

**`Util.setCharacterTrackingState(state)`**
- Parameters: `state` (Object) - Complete tracking state to save
- Description: Persists tracking state to localStorage with error handling

**`Util.getTrackedCharacters()`**
- Returns: `Array` - Character IDs tracked in current tab
- Description: Gets tracked characters for the current browser tab

**`Util.setTrackedCharacters(characterIds)`**
- Parameters: `characterIds` (Array) - Character IDs to track
- Description: Updates tracked characters for current tab with metadata

**`Util.isCharacterTrackedElsewhere(characterId)`**
- Parameters: `characterId` (Number) - Character ID to check
- Returns: `boolean` - True if character is tracked in another active tab
- Description: Checks for cross-tab tracking conflicts using heartbeat data

**`Util.handleCharacterSwitchConflict(characterId)`**
- Parameters: `characterId` (Number) - Character ID being switched to
- Returns: `Object` - Conflict resolution result
- Description: Automatically resolves character switching conflicts

#### Heartbeat System Functions

**`Util.updateTabHeartbeat()`**
- Description: Updates heartbeat timestamp for current tab

**`Util.getActiveTabs(maxAge)`**
- Parameters: `maxAge` (Number) - Maximum age in milliseconds (default: 30000)
- Returns: `Array` - List of active tab IDs
- Description: Gets tabs that have recent heartbeat activity

**`Util.cleanupDeadTabs()`**
- Description: Removes tracking data for tabs without recent heartbeats

#### Event System

**`pf:updateCharacterTracking`**
- Type: jQuery custom event
- Trigger: When tracking state changes
- Usage: Listen for tracking updates to refresh UI components

```javascript
$(document).on('pf:updateCharacterTracking', () => {
    // Handle tracking update
    updateCharacterTrackingCounter();
});
```

**`pf:beforeCharacterSwitch`**
- Type: jQuery custom event
- Trigger: Before character switching occurs
- Usage: Handle character switching conflicts

```javascript
$(document).on('pf:beforeCharacterSwitch', (e, data) => {
    // Handle character switch conflict
    let conflict = Util.handleCharacterSwitchConflict(data.characterId);
});
```

### Extending the Feature

#### Adding New Tracking Metadata

To add additional metadata to the tracking state:

```javascript
// In setTrackedCharacters function
state[tabId].characters = characterIds;
state[tabId].currentCharacter = currentCharacterId;
state[tabId].lastUpdate = Date.now();
state[tabId].customMetadata = yourData; // Add your metadata here
```

#### Customizing Heartbeat Intervals

To adjust heartbeat timing:

```javascript
// In cleanupTrackingState function
setInterval(() => {
    Util.updateTabHeartbeat();
}, 5000); // Change from 10000 to 5000 for 5-second intervals
```

#### Adding Custom Conflict Resolution

To implement custom conflict resolution logic:

```javascript
// Override handleCharacterSwitchConflict function
let customHandleConflict = (characterId) => {
    // Your custom logic here
    return {
        hadConflict: false,
        message: 'Custom resolution applied'
    };
};
```

## Troubleshooting

### Common Issues

**Issue**: Tracking counter not updating
- **Cause**: Event listener not properly attached
- **Solution**: Ensure `initializeCharacterTracking()` is called on page load

**Issue**: Characters appear tracked elsewhere when they shouldn't be
- **Cause**: Dead tab states not cleaned up
- **Solution**: Check that heartbeat system is running and cleanup function is called

**Issue**: Browser crash recovery not working
- **Cause**: localStorage corruption or heartbeat data missing
- **Solution**: Clear localStorage or implement additional fallback mechanisms

### Debugging

Enable debug logging:

```javascript
// Add to tracking functions
console.log('Tracking state:', Util.getCharacterTrackingState());
console.log('Active tabs:', Util.getActiveTabs());
console.log('Heartbeats:', Util.getTabHeartbeatState());
```

### Performance Considerations

- Heartbeat updates occur every 10 seconds to balance responsiveness and performance
- localStorage operations are wrapped in try-catch for error handling
- Active tab detection uses 30-second timeout to prevent false positives
- Dead tab cleanup runs on page load and during heartbeat intervals
});
```

### Extending the Feature

#### Adding New Tracking Actions

To add new functionality when characters are tracked/untracked:

```javascript
// Listen for tracking changes
$(document).on('pf:updateCharacterTracking', () => {
    let trackedCharacters = Util.getTrackedCharacters();
    // Your custom logic here
});
```

#### Custom Storage Backends

To replace localStorage with a different storage system:

1. Modify `getCharacterTrackingState()` and `setCharacterTrackingState()` in util.js
2. Maintain the same data structure format
3. Ensure error handling for storage failures

#### UI Customization

The tracking interface can be customized by modifying:
- `character_switch.html` - Popover template structure
- `header_map.html` - Tracking counter badge appearance
- CSS classes for styling tracking elements

#### Performance Considerations

- State cleanup runs on page load to prevent localStorage bloat
- Cross-tab checks are performed only when popover is opened
- Event listeners are properly namespaced to avoid conflicts
- localStorage operations include try-catch error handling

## Browser Compatibility

The feature uses standard web APIs and is compatible with:
- localStorage (required)
- jQuery events
- Modern browsers supporting ES6+ features

## Troubleshooting

**Issue**: Tracking state not persisting
- **Solution**: Check browser localStorage permissions and quota

**Issue**: Cross-tab coordination not working
- **Solution**: Verify browser tab ID generation and localStorage access

**Issue**: Tracking counter not updating
- **Solution**: Check `pf:updateCharacterTracking` event triggering

**Issue**: Checkboxes not responding
- **Solution**: Verify jQuery event binding and DOM element presence