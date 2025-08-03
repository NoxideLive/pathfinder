# Multi-Character Tracking

The Multi-Character Tracking feature allows users to monitor multiple characters from a single browser tab, eliminating the need to keep multiple tabs open for character tracking. This feature provides a centralized character management interface with cross-tab coordination.

## Table of Contents

- [User Guide](#user-guide)
  - [How to Use](#how-to-use)
  - [Visual Indicators](#visual-indicators)
  - [Cross-Tab Coordination](#cross-tab-coordination)
- [Technical Implementation](#technical-implementation)
  - [Architecture Overview](#architecture-overview)
  - [File Structure](#file-structure)
  - [Data Flow](#data-flow)
  - [Storage System](#storage-system)
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
- Automatically cleaning up tracking state when tabs are closed

## Technical Implementation

### Architecture Overview

The multi-character tracking system is built on three core components:

1. **UI Layer**: Enhanced character switcher popover with tracking checkboxes
2. **State Management**: localStorage-based persistence with tab-specific keys
3. **Event System**: Real-time updates and cross-component communication

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
   ├── Initialize current character tracking
   ├── Clean up closed tab states
   └── Update tracking counter

2. Character Switcher Popover
   ├── Render tracking checkboxes
   ├── Check cross-tab conflicts
   ├── Handle checkbox changes
   └── Trigger tracking updates

3. State Management
   ├── Store per-tab character lists
   ├── Coordinate across browser tabs
   └── Persist to localStorage
```

### Storage System

The tracking state is stored in localStorage using the following structure:

```javascript
// localStorage key: 'pf-character-tracking'
{
  "tab_123456": [1001, 1002, 1003],  // Tab ID -> Character IDs array
  "tab_789012": [1004, 1005],
  // ... other tabs
}
```

**Key Features:**
- Tab-specific storage prevents conflicts
- Automatic cleanup on page load
- Cross-tab state coordination
- Fallback error handling

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
```

#### 2. UI Integration (page.js)

Main page controller functions:

```javascript
// Initialize tracking for current character
initializeCharacterTracking() -> void

// Clean up tracking state from closed tabs
cleanupTrackingState() -> void

// Update header tracking counter
updateCharacterTrackingCounter() -> void
```

#### 3. Popover Enhancement (character_switch.html)

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
- Description: Updates tracked characters for current tab

**`Util.isCharacterTrackedElsewhere(characterId)`**
- Parameters: `characterId` (Number) - Character ID to check
- Returns: `boolean` - True if character is tracked in another tab
- Description: Checks for cross-tab tracking conflicts

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