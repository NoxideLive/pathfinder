# Visual Guide: EOL 1h Critical Feature

## Context Menu Changes

### BEFORE (Right-click on wormhole connection)
```
┌─────────────────────────────┐
│ ⏳ toggle EOL               │
│ ⚠️  preserve mass            │
│ 🔄 rolling                   │
│ ━━━━━━━━━━━━━━━━━━━━━━━━━━  │
│ ↩️  mass status          ▶   │
│ ↩️  ship size            ▶   │
│ ↩️  change scope         ▶   │
│ ━━━━━━━━━━━━━━━━━━━━━━━━━━  │
│ 🔗 detach                    │
└─────────────────────────────┘
```

### AFTER (Right-click on wormhole connection)
```
┌─────────────────────────────┐
│ ⏳ toggle EOL (4h)    ← RENAMED FOR CLARITY
│ ❗ toggle EOL (1h)    ← NEW! CRITICAL STATUS
│ ⚠️  preserve mass            │
│ 🔄 rolling                   │
│ ━━━━━━━━━━━━━━━━━━━━━━━━━━  │
│ ↩️  mass status          ▶   │
│ ↩️  ship size            ▶   │
│ ↩️  change scope         ▶   │
│ ━━━━━━━━━━━━━━━━━━━━━━━━━━  │
│ 🔗 detach                    │
└─────────────────────────────┘
```

## Connection Visual States

### State 1: Normal Wormhole (No EOL)
```
System A ═══════════════ System B
         (gray line)
```

### State 2: EOL 4h Only (Existing behavior, unchanged)
```
System A ═══════════════ System B
         (purple/pink line #d747d6)
```

### State 3: EOL 1h Only (NEW!)
```
System A ═══════════════ System B
         (red line #d9534f)
```

### State 4: Both EOL 4h AND EOL 1h
```
System A ═══════════════ System B
         (purple + red - both colors visible)
```

## Map Overlay Icons

### BEFORE
```
┌────────────────────────┐
│  Map Info Overlay      │
├────────────────────────┤
│  👤 System Popover     │
│  ═  Connections        │
│  ⏳ EOL                │  ← Shows all EOL connections
└────────────────────────┘
```

### AFTER
```
┌────────────────────────┐
│  Map Info Overlay      │
├────────────────────────┤
│  👤 System Popover     │
│  ═  Connections        │
│  ⏳ EOL (4h)           │  ← Regular EOL connections
│  ❗ EOL Critical (1h)  │  ← NEW! Critical EOL connections
└────────────────────────┘
```

### Overlay Behavior
When hovering over an overlay icon:
- **⏳ EOL (4h)**: Shows time remaining for connections with purple EOL
- **❗ EOL Critical (1h)**: Shows time remaining for connections with red EOL

Example overlay label on connection:
```
Regular EOL:
┌──────────────────┐
│ ⏳ 2h 45m        │  ← Gray background, purple text
└──────────────────┘

Critical EOL:
┌──────────────────┐
│ ❗ 35m           │  ← Red background, white text
└──────────────────┘
```

## Color Palette

### Regular EOL (4h) - UNCHANGED
- **Connection Line**: #d747d6 (purple/pink)
- **Border**: #d747d6
- **Overlay Background**: #3c3f41 (gray)
- **Overlay Text**: #d747d6 (purple/pink)
- **Icon**: fa-hourglass-end ⏳

### Critical EOL (1h) - NEW
- **Connection Line**: #d9534f (red)
- **Border**: #d9534f (red)
- **Overlay Background**: #a52521 (dark red)
- **Overlay Text**: #eaeaea (light gray)
- **Icon**: fa-exclamation-circle ❗

## Usage Examples

### Scenario 1: Fresh wormhole discovered
```
Action: Create connection
Result: Gray line (no EOL markers)
```

### Scenario 2: Wormhole showing signs of decay
```
Action: Right-click → "toggle EOL (4h)"
Result: Connection turns purple
Overlay: Shows "⏳ EOL" when hovering map icon
```

### Scenario 3: Wormhole nearly collapsing
```
Action: Right-click → "toggle EOL (1h)" 
Result: Connection turns red
Overlay: Shows "❗ EOL Critical" when hovering map icon
```

### Scenario 4: Wormhole transitioning states
```
Initial: Purple (EOL 4h marked)
Action: Right-click → "toggle EOL (1h)"
Result: Both purple AND red visible
Both overlays active
```

### Scenario 5: Removing EOL status
```
Action: Right-click → "toggle EOL (4h)" (to uncheck)
Result: Purple color removed (red remains if still checked)
```

## Integration Notes

### API Response Format
```json
{
  "id": 12345,
  "source": 101,
  "target": 102,
  "scope": "wh",
  "type": ["wh_fresh", "wh_eol_critical"],
  "eolUpdated": 1634567890
}
```

### Map Export/Import
The new connection type is automatically included in map exports and will be preserved when importing maps.

### Backward Compatibility
- Old clients: Will ignore unknown `wh_eol_critical` type
- New clients: Can display both old and new EOL types
- Database: No migration needed (uses existing JSON type column)

## Quick Tip for Users

**When to use which:**
- **EOL (4h)**: Wormhole showing "This wormhole has not yet begun its natural cycle" (< 4 hours)
- **EOL (1h)**: Wormhole showing "This wormhole is reaching the end of its life" (< 1 hour)
- **Both**: When uncertain or during transition period

**Visual reminder:**
- 🟣 Purple = 4 hours left
- 🔴 Red = 1 hour left (CRITICAL!)
