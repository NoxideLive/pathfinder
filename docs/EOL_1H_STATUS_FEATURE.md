# EOL 1 Hour Status Feature

## Overview

The new "EOL 1h Critical" status feature allows users to mark wormhole connections as critically end-of-life, indicating that the wormhole has approximately 1 hour remaining before it collapses.

## Feature Description

Previously, wormholes could only be marked with a standard "EOL (4h)" status, indicating the wormhole was in its final 4 hours of life. The new "EOL (1h)" option provides more granular control for tracking wormhole lifetime, specifically for the critical final hour.

## How to Use

1. **Access the Feature**: Right-click on any wormhole connection on the map
2. **Select EOL Status**: In the context menu, you will see two EOL options:
   - "toggle EOL (4h)" - Standard end-of-life marker (existing feature)
   - "toggle EOL (1h)" - Critical end-of-life marker (NEW feature)
3. **Apply the Status**: Click on "toggle EOL (1h)" to mark the connection as critically end-of-life

## Visual Indicators

When a connection is marked with the EOL 1h status:
- The connection will be visually marked to indicate its critical state
- The status can be toggled on/off by clicking the same menu option again
- The status persists on the map until manually changed or the connection is removed

## Technical Implementation

- **Context Menu Entry**: The feature is implemented in `js/app/map/contextmenu.js` line 106
  - Icon: `fa-hourglass-end`
  - Action: `wh_eol_critical`
  - Text: `toggle EOL (1h)`

- **Map Handler**: The feature is handled in `js/app/map/map.js` line 769
  - Integrates with the map overlay timer
  - Uses the same toggle mechanism as other connection types

## Use Cases

1. **Time-Critical Operations**: When you know a wormhole has less than 1 hour remaining
2. **Fleet Operations**: Coordinating fleet movements through critical wormholes
3. **Route Planning**: Better decision-making for navigation through wormhole chains
4. **Risk Assessment**: Identifying high-risk connections that may collapse soon

## Screenshots

### Screenshot 1: Context Menu

![Context Menu showing EOL options](https://github.com/user-attachments/assets/19f5d469-fa3a-4d92-8307-96c8e5107db0)

*Right-click context menu on a wormhole connection showing both EOL (4h) and the new EOL (1h) options.*

**Location:** `img/gallery/connection_eol_menu.jpg`

### Screenshot 2: EOL 1h Status Applied

![Connection with EOL 1h status active](https://github.com/user-attachments/assets/8e17aa34-35f0-4b90-9c76-9c64ddd1580f)

*A wormhole connection with the EOL 1h (critical) status applied, showing the red glowing connection line and EOL 1h indicator.*

**Location:** `img/gallery/connection_eol_1h_active.jpg`

### Screenshot 3: Status Comparison

![Comparison of connection states](https://github.com/user-attachments/assets/41c5750b-7aad-4a26-977f-3cc8c012fd15)

*Visual comparison showing three connection states: Normal (green), EOL 4h (orange), and EOL 1h Critical (red).*

**Location:** `img/gallery/connection_eol_comparison.jpg`

## Notes

- The EOL 1h status is independent of other connection statuses (mass status, preserve mass, rolling, etc.)
- Multiple status types can be applied to the same connection
- The feature follows the same toggle pattern as other connection modifiers
