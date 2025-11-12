# Pathfinder Quick Feature Reference

**Quick reference for developers and stakeholders**  
**For complete details, see:** [FEATURE_DOCUMENTATION.md](./FEATURE_DOCUMENTATION.md)

---

## User Workflows

### Daily User Activities

1. **Login & Character Selection**
   - Login via CCP SSO
   - Select active character
   - Switch between owned characters
   - Auto-location tracking (optional)

2. **Working with Maps**
   - View shared maps (personal/corp/alliance)
   - Create new map (within limits)
   - Select active map from tabs
   - Import/export map data (JSON)

3. **Managing Systems**
   - Add systems to map (drag or search)
   - Move systems around (drag-and-drop)
   - View system information (click)
   - Set rally points
   - Tag systems

4. **Managing Connections**
   - Create connections (drag between systems)
   - Edit connection type/properties
   - Mark EOL (End of Life)
   - Track mass status
   - View connection info

5. **Managing Signatures**
   - Paste signatures from game
   - Edit signature details
   - Track signature scanning progress
   - View signature history
   - Auto-cleanup of old signatures

6. **Finding Routes**
   - Search for route between systems
   - View multiple route options
   - Set in-game waypoints
   - Configure route preferences

---

## Admin Workflows

### Administrative Tasks

1. **User Management**
   - View logged-in users
   - Kick users (temporary)
   - Ban users
   - Monitor user activity

2. **Map Management**
   - View all maps
   - Monitor map statistics
   - Manage map access

3. **System Configuration**
   - Configure global settings
   - Manage integrations
   - Monitor server status

---

## Integration Points

### CCP ESI API
- **Character Data:** Location, ship type, online status
- **Universe Data:** System info, sovereignty, statistics
- **Actions:** Set waypoints, open windows

### Slack
- **Map Updates:** System/connection changes
- **Rally Points:** Notification pokes
- **Configuration:** Per-map webhooks

### Discord
- **Map Updates:** System/connection changes
- **Rally Points:** Notification pokes
- **Configuration:** Per-map webhooks

### External Services
- **Dotlan:** System/region maps
- **zKillboard:** Kill statistics
- **Eve-Scout:** Thera connections
- **Anoik.is:** Wormhole information

---

## Map Type Comparison

| Feature | Private | Corporation | Alliance |
|---------|---------|-------------|----------|
| **Max Maps** | 3 | 5 | 4 |
| **Max Systems** | 50 | 100 | 100 |
| **Max Shared** | 10 | 4 | 2 |
| **Lifetime** | 60 days | Permanent | Permanent |
| **Activity Logs** | Yes | Yes | No |
| **History Logs** | Yes | Yes | Yes |
| **Slack/Discord** | Rally only | All | All |

---

## Key Configuration Limits

### System Limits
- **Session timeout:** 8 hours (480 minutes)
- **Cookie expiration:** 30 days
- **Max active connections per map:** 8 displayed
- **Update interval:** 5 seconds (AJAX long polling)

### Auto-Cleanup Timers
- **EOL connections:** 4 hours 15 minutes
- **WH connections:** 2 days (configurable per map)
- **Signatures:** 3 days (configurable per map)
- **Inactive character logs:** 3 minutes
- **Old maps:** Deleted at EVE downtime if past lifetime

---

## Common API Endpoints

### Map Operations
```
GET  /api/Map/initData              - Get static initialization data
POST /api/Map/updateData            - Update map (long polling)
POST /api/Map/updateUserData        - Update user data (long polling)
GET  /api/Map/getLogData            - Get map history
```

### REST Operations
```
GET    /api/rest/Map/:id            - Get map data
POST   /api/rest/Map                - Create map
PUT    /api/rest/Map/:id            - Update map
DELETE /api/rest/Map/:id            - Delete map

GET    /api/rest/System/:id         - Get system data
POST   /api/rest/System             - Create system
PUT    /api/rest/System/:id         - Update system
DELETE /api/rest/System/:id         - Delete system

GET    /api/rest/Connection/:id     - Get connection data
POST   /api/rest/Connection         - Create connection
PUT    /api/rest/Connection/:id     - Update connection
DELETE /api/rest/Connection/:id     - Delete connection

GET    /api/rest/Signature/:id      - Get signature data
POST   /api/rest/Signature          - Create signature
PUT    /api/rest/Signature/:id      - Update signature
DELETE /api/rest/Signature/:id      - Delete signature

POST   /api/rest/Route              - Find route
```

---

## Database Models Overview

### Core Models
- **MapModel** - Map configuration and metadata
- **SystemModel** - Systems placed on maps
- **ConnectionModel** - Connections between systems
- **SystemSignatureModel** - Signatures in systems

### User Models
- **UserModel** - User accounts
- **CharacterModel** - EVE characters
- **CharacterAuthenticationModel** - Auth tokens

### Organization Models
- **CorporationModel** - Corporation data
- **AllianceModel** - Alliance data

### Access Control
- **CharacterMapModel** - Character access to maps
- **CorporationMapModel** - Corporation access to maps
- **AllianceMapModel** - Alliance access to maps

### Tracking Models
- **ActivityLogModel** - User activity tracking
- **ConnectionLogModel** - Connection change tracking
- **CharacterLogModel** - Character presence tracking

---

## UI Modules

### System Modules (Right Panel)
- **System Info** - Basic system information
- **System Signature** - Signature management
- **System Route** - Route finding
- **System Killboard** - Kill statistics
- **System Intel** - Notes and intelligence
- **System Graph** - Visual statistics

### Map Modules
- **Connection Info** - Connection details
- **Global Thera** - Thera connections
- **Tags** - Tag management
- **Dotlan** - Dotlan integration

---

## Keyboard Shortcuts

**Note:** Full shortcuts available in app via Shortcuts dialog

- **Map Navigation:** Drag to pan, scroll to zoom
- **System Selection:** Click to select, Ctrl+Click for multi-select
- **System Movement:** Drag selected systems
- **Connection Creation:** Drag from system to system
- **Context Menu:** Right-click on system/connection
- **Delete:** Select and press Delete key

---

## Background Jobs (Cronjobs)

### High-Frequency (Every minute)
- Delete inactive character logs

### Medium-Frequency (Every 30 minutes)
- Delete expired signatures
- Import system statistics from ESI
- Update sovereignty data
- Truncate large log files

### Low-Frequency (Daily at EVE downtime)
- Delete old maps
- Clean expired cache
- Clean expired authentication tokens

---

## Known Issues & Workarounds

### Performance
- **Issue:** Large maps (100+ systems) can be slow
- **Workaround:** Use compact layout, reduce active connections

### Signatures
- **Issue:** Paste from game clipboard not always reliable
- **Workaround:** Manual entry or re-paste

### Map Updates
- **Issue:** AJAX long polling can cause server load
- **Workaround:** Consider WebSocket configuration

### Mobile
- **Issue:** Desktop-focused interface, limited mobile support
- **Workaround:** Use desktop browser or wait for responsive design

---

## Security Considerations

### Authentication
- SSO tokens stored in database
- Cookie-based sessions (30-day expiration)
- Session sharing available but optional

### Access Control
- Map-level access control (character/corp/alliance)
- Role-based admin access (SUPER, CORPORATION)
- Whitelist support for characters/corps/alliances

### Setup Route
- **IMPORTANT:** Disable `/setup` route in production
- Security risk if left enabled
- Should be commented out in `routes.ini`

---

## Support & Resources

### Documentation
- **Feature Documentation:** [FEATURE_DOCUMENTATION.md](./FEATURE_DOCUMENTATION.md)
- **Migration Checklist:** [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md)

### Community
- **Slack:** pathfinder-eve-online.slack.com
- **GitHub:** https://github.com/NoxideLive/pathfinder
- **Project URL:** https://www.pathfinder-w.space

### External Resources
- **Screenshots:** http://imgur.com/a/k2aVa
- **Videos:** https://www.youtube.com/channel/UC7HU7XEoMbqRwqxDTbMjSPg

---

**Last Updated:** November 2025  
**Version:** 1.0
