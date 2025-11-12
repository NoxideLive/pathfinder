# Pathfinder Feature Documentation

**Version:** v2.2.3  
**Purpose:** Complete feature documentation for migration to new stack (Convex + Vue 3)  
**Date:** November 2025  
**Current Stack:** PHP, JavaScript, HTML, SCSS

---

## Table of Contents

1. [Core Mapping Features](#core-mapping-features)
2. [User Management & Authentication](#user-management--authentication)
3. [Admin Features](#admin-features)
4. [System & Navigation Features](#system--navigation-features)
5. [Connection Management](#connection-management)
6. [Signature Management](#signature-management)
7. [Route Finding & Navigation](#route-finding--navigation)
8. [Data Visualization & UI](#data-visualization--ui)
9. [Integration Features](#integration-features)
10. [Background System Features](#background-system-features)
11. [API Endpoints](#api-endpoints)
12. [Configuration & Limits](#configuration--limits)
13. [Database Models](#database-models)
14. [Known Pain Points](#known-pain-points)

---

## Core Mapping Features

### Map Types
**File:** `app/pathfinder.ini`, `app/Model/Pathfinder/MapModel.php`

- **Private Maps**
  - Lifetime: 60 days
  - Max count per user: 3
  - Max shared entities: 10
  - Max systems: 50
  - Activity logging enabled
  - History logging enabled
  
- **Corporation Maps**
  - Lifetime: 99,999 days (effectively permanent)
  - Max count per corporation: 5
  - Max shared entities: 4
  - Max systems: 100
  - Activity logging enabled
  - History logging enabled
  - Slack/Discord integration enabled
  
- **Alliance Maps**
  - Lifetime: 99,999 days (effectively permanent)
  - Max count per alliance: 4
  - Max shared entities: 2
  - Max systems: 100
  - Activity logging disabled
  - History logging enabled
  - Slack/Discord integration enabled

### Map Operations
**File:** `app/Controller/Api/Map.php`, `js/app/map/map.js`

- Create new maps (with name, icon, scope, type)
- Edit map settings (name, icon, scope, type)
- Delete maps
- Import maps (JSON format with drag & drop support)
- Export maps (JSON format with formatted filename)
- Map sharing (characters, corporations, alliances)
- Map access control based on user roles
- Map scope management (public/private/corporation/alliance)
- Real-time map updates (AJAX long polling or WebSocket)

### Map Settings & Configuration
**File:** `js/app/ui/dialog/map_settings.js`

- **Connection Management:**
  - Auto-delete expired connections
  - Auto-delete EOL (End of Life) connections
  - Persistent aliases for systems
  - Persistent signatures across systems
  - Track abyssal jumps
  
- **Logging:**
  - History logging (map changes to separate log files)
  - Activity logging (user statistics)
  
- **Integration Settings:**
  - Slack webhook URL, username, icon, channels (history/rally)
  - Discord webhook URLs (history/rally), username
  
- **Access Control:**
  - Select characters with access
  - Select corporations with access
  - Select alliances with access

### Map Display Features
**File:** `js/app/map/map.js`, `js/app/map/overlay/`

- Multiple map tabs support (switch between maps)
- Map grid system with snap-to-grid
- System magnetization (auto-alignment)
- Zoom in/out functionality
- Pan/scroll the map canvas
- Drag-select multiple systems
- Compact system layout mode
- System region overlay toggle
- Connection signature overlays
- Active connection indicators (max 8 per map)

---

## User Management & Authentication

### Authentication
**File:** `app/Controller/Ccp/Sso.php`, `app/Controller/Api/User.php`

- CCP SSO (Single Sign-On) integration
- EVE Online character authentication
- OAuth2 token management
- Cookie-based session management
- Cookie expiration: 30 days (configurable)
- Multi-character support (character switching)
- Session sharing between characters (optional, configurable)

### Character Management
**File:** `app/Model/Pathfinder/CharacterModel.php`

- Character login tracking
- Character access logging
- Character location tracking (auto-location select)
- Character status tracking (online/offline)
- Character log data (system presence, ship type)
- Character authentication model
- Cookie character retrieval
- Multi-character switching in same session

### User Features
**File:** `js/app/ui/dialog/account_settings.js`, `app/Controller/Api/User.php`

- Account settings dialog
- Auto-location select toggle
- Character information display
- Logout functionality
- Delete account functionality
- Open in-game windows (ESI integration)
- User registration (can be disabled globally)

### Access Control
**File:** `app/pathfinder.ini`

- Character whitelist
- Corporation whitelist
- Alliance whitelist
- Login restrictions based on CCP IDs
- Role-based access (SUPER admin, CORPORATION admin)

---

## Admin Features

### Admin Panel
**File:** `app/Controller/Admin.php`, `public/templates/admin/`

- **Login Management:**
  - View logged-in users
  - Admin authentication via SSO with required scopes
  - Admin role verification (SUPER, CORPORATION)

- **Member Management:**
  - Kick users (5m, 1h, 24h options)
  - Ban users
  - View corporation members
  - Admin action logging

- **Map Management:**
  - View all maps
  - Map statistics
  - Map activity monitoring

- **Settings:**
  - System configuration
  - Notification settings
  - Server status monitoring

### Admin Actions
**File:** `app/Controller/Admin.php`

- Character kick/ban operations
- Kick duration options (5 minutes, 1 hour, 24 hours)
- Corporation-level admin capabilities
- Action logging (who kicked/banned whom)
- SSO scope validation for admin features

---

## System & Navigation Features

### System Display
**File:** `js/app/map/system.js`, `app/Model/Pathfinder/SystemModel.php`

- **System Information:**
  - System name
  - System security status (colors: highsec, lowsec, nullsec, wormhole)
  - System type (C1-C6 wormhole classes)
  - System region
  - System constellation
  - System effect (wormhole effects)
  - User counter (players in system)
  - System status (rally point, etc.)
  - System tags (custom labels)

- **System Body Items:**
  - Player names in system
  - Player ship types
  - Player status indicators
  - Real-time presence tracking

- **System Interactions:**
  - Click to select/deselect
  - Double-click to expand/collapse
  - Right-click context menu
  - Drag to move
  - Multi-system drag selection
  - Lock/unlock systems
  - Delete systems

### System Context Menu
**File:** `js/app/map/contextmenu.js`

- Set rally point
- Lock/unlock system
- Delete system
- Add connection
- Set as waypoint
- Show system info
- Find route from/to system
- Copy system name
- Open system in Dotlan
- Open system in zKillboard

### System Tags
**File:** `app/pathfinder.ini`

- Auto-tagging enabled/disabled
- Tag naming schemes (e.g., countConnections)
- Home system exclusion
- Custom tag styling

---

## Connection Management

### Connection Types
**File:** `app/Model/Pathfinder/ConnectionModel.php`

- Wormhole connections (WH)
- Stargate connections
- Jump bridge connections
- Abyssal connections (trackable)
- EOL (End of Life) connections

### Connection Properties
**File:** `js/app/map/map.js`, `app/Controller/Api/Rest/Connection.php`

- Connection scope (normal, WH, stargate, jumpbridge)
- Connection size (small, medium, large, XL)
- Connection type (specific WH types: K162, etc.)
- Connection mass status
- Connection lifetime/expiration
- EOL status
- Frigate-only flag
- Connection descriptions/notes

### Connection Operations

- Create connections (drag between systems)
- Delete connections
- Edit connection properties
- Connection signature overlay
- Auto-delete expired connections (cronjob)
- Auto-delete EOL connections (cronjob)
- Connection logging (activity tracking)
- Visual connection indicators (colors, line styles)

### Connection Limits
**File:** `js/app/map/map.js`

- Max active connections displayed: 8 per map
- Connection caching for performance
- Connection mass tracking
- Connection lifetime tracking

---

## Signature Management

### Signature Features
**File:** `js/app/ui/module/system_signature.js`, `app/Model/Pathfinder/SystemSignatureModel.php`

- **Signature Properties:**
  - Signature ID (from EVE)
  - Signature group (combat, data, gas, relic, wormhole)
  - Signature type
  - Signature name
  - Description
  - Created/updated timestamps
  - Created by/updated by tracking

- **Signature Operations:**
  - Add signatures
  - Edit signatures
  - Delete signatures
  - Bulk signature operations
  - Signature import from game
  - Signature paste from clipboard
  - Signature history tracking
  - Persistent signatures (optional)
  - Auto-delete expired signatures (cronjob: 3 days default)

- **Signature Display:**
  - DataTable interface
  - Progress bars for signature scanning
  - Tooltips with signature details
  - Signature type icons
  - Color-coding by group

### Signature History
**File:** `app/Controller/Api/Rest/SignatureHistory.php`

- Track signature changes over time
- View signature modification history
- User tracking for signature updates

---

## Route Finding & Navigation

### Route Search
**File:** `app/Controller/Api/Rest/Route.php`, `js/app/ui/module/system_route.js`

- **Route Algorithm:**
  - ESI /route/ API integration (primary)
  - Custom recursive search algorithm (fallback)
  - Search depth: 9,000 (configurable)
  - Initial route count: 4
  - Max selectable routes: 6
  - Total route limit: 8 (including custom)

- **Route Types:**
  - Shortest route
  - Safest route (avoid lowsec/nullsec)
  - Custom route preferences
  - Multiple route display

- **Route Display:**
  - Route table with system list
  - Jump count
  - Security status indicators
  - Gate/wormhole indicators
  - Route visualization on map

- **Route Settings Dialog:**
  - Select start system
  - Select destination system
  - Configure route preferences
  - Save custom routes

### Waypoint Management
**File:** `app/Controller/Api/System.php`

- Set in-game destination via ESI
- Clear waypoints
- Add waypoints
- Auto-pilot integration

---

## Data Visualization & UI

### Modules
**File:** `js/app/ui/module/`

- **System Info Module:** Detailed system information, sovereignty, statistics
- **System Signature Module:** Signature management interface
- **System Route Module:** Route finding and display
- **System Killboard Module:** zKillboard data integration
- **System Intel Module:** Intelligence and notes
- **System Graph Module:** Visual graphs and statistics
- **Connection Info Module:** Connection details and properties
- **Dotlan Module:** Dotlan map integration
- **Global Thera Module:** Eve-Scout Thera connections
- **Tags Module:** Tag management
- **Demo Module:** Tutorial/demonstration features
- **Empty Module:** Placeholder for future modules

### Dialogs
**File:** `js/app/ui/dialog/`

- **Map Settings Dialog:** Map configuration and preferences
- **Map Info Dialog:** Map statistics and information
- **Account Settings Dialog:** User preferences
- **Shortcuts Dialog:** Keyboard shortcuts reference
- **Manual Dialog:** User manual and help
- **Jump Info Dialog:** Jump bridge information
- **System Effects Dialog:** Wormhole effects reference
- **Stats Dialog:** Statistics and analytics
- **API Status Dialog:** CCP API status monitoring
- **Changelog Dialog:** Version history and updates
- **Credit Dialog:** Contributors and credits
- **Delete Account Dialog:** Account deletion confirmation
- **Notification Dialog:** System notifications

### UI Components
**File:** `js/app/ui/`

- Header (login status, character info)
- Character panel (character switching)
- Server panel (server status)
- Admin panel (admin controls)
- Info panel (contextual information)
- Debug panel (development tools)
- Timeline element (activity timeline)
- Notice/notification system
- Form elements (custom form controls)

### Visual Features

- **Map Overlays:**
  - System region labels
  - Connection signature overlays
  - Grid overlay
  - Magnetization guides

- **Color Coding:**
  - Security status colors (highsec, lowsec, nullsec, WH)
  - System status indicators
  - Player status colors
  - Connection type colors
  - Effect type colors

- **Interactive Elements:**
  - Tooltips (system info, player info, connection info)
  - Popovers (quick actions)
  - Context menus (right-click actions)
  - Editable fields (inline editing with xEditable)
  - Select2 dropdowns (enhanced select boxes)

---

## Integration Features

### CCP ESI API Integration
**File:** `app/pathfinder.ini`, `app/Cron/`

- **System Data Import:**
  - Jump statistics (cronjob: every 30 minutes)
  - Kill statistics (faction kills, pod kills, ship kills)
  - NPC kills
  - System sovereignty data
  - Faction warfare data

- **Character Data:**
  - Character location
  - Character ship type
  - Character online status
  - Character corporation/alliance

- **Universe Data:**
  - Static system data
  - Constellation data
  - Region data
  - Sovereignty updates (cronjob: every 30 minutes)

### Slack Integration
**File:** `app/pathfinder.ini`

- **Features:**
  - Global status toggle
  - Per-map webhook configuration
  - Custom username and icon
  - History channel (map updates)
  - Rally channel (rally point pokes)
  - Send history enabled/disabled per map type
  - Send rally enabled/disabled per map type

- **Events:**
  - System added/removed
  - Connection added/removed/updated
  - Rally point set
  - Signature changes (optional)

### Discord Integration
**File:** `app/pathfinder.ini`

- **Features:**
  - Global status toggle
  - Per-map webhook configuration (separate for history/rally)
  - Custom username
  - History webhook (map updates)
  - Rally webhook (rally point pokes)
  - Send history enabled/disabled per map type
  - Send rally enabled/disabled per map type

- **Events:**
  - Same as Slack integration

### Email Notifications
**File:** `app/pathfinder.ini`

- Rally point pokes via email
- Requires SMTP configuration
- Global email address configuration
- Per-map type enable/disable

### External APIs
**File:** `app/pathfinder.ini`

- **CCP Image Server:** `https://images.evetech.net`
- **zKillboard API:** `https://zkillboard.com/api`
- **EveEye:** `https://eveeye.com`
- **Dotlan:** `http://evemaps.dotlan.net`
- **Anoik.is:** `http://anoik.is` (wormhole info)
- **Eve-Scout:** `https://api.eve-scout.com/v2/public` (Thera connections)
- **GitHub API:** `https://api.github.com` (version checks, updates)

---

## Background System Features

### Cronjobs
**File:** `app/cron.ini`, `app/Cron/`

- **Every Minute:**
  - Delete character log data (inactive characters)

- **Every 5 Minutes:**
  - Delete EOL connections

- **Every 10 Minutes:**
  - (Reserved for future use)

- **Every 30 Minutes:**
  - Delete expired signatures
  - Truncate map history log files
  - Import system data from CCP API
  - Update sovereignty data

- **Hourly:**
  - Delete expired WH connections
  - Deactivate outdated maps
  - Clean up character data (kick, ban processing)

- **Daily (EVE Downtime - 11:00 UTC):**
  - Delete disabled/inactive maps
  - Delete expired authentication data
  - Delete expired cache files

- **Weekly:**
  - Delete old statistics/activity log data

### Caching
**File:** `app/pathfinder.ini`, `app/Lib/`

- **Cache Types:**
  - File cache (default)
  - Redis cache (optional)
  - Session cache

- **Cache Configuration:**
  - Character log inactive timeout: 180 seconds
  - Max cache file expiration: 10 days
  - Map history cache: 5 seconds
  - Init data cache: 1 hour

- **Cached Data:**
  - Map data
  - User data
  - System data
  - Route data
  - API responses
  - Static configuration

### Logging
**File:** `app/pathfinder.ini`

- **Log Files:**
  - Error log
  - SSO error log
  - Character login log
  - Character access log
  - Session suspect log (MySQL sessions)
  - Account deletion log
  - Admin action log
  - TCP socket error log
  - Debug log (development)

- **History Logging:**
  - Map history logs (separate files per map)
  - Log size threshold: 2 MB
  - Auto-truncate to 1,000 lines
  - Location: `history/` directory

### Database
**File:** `app/environment.ini`, `composer.json`

- MySQL/MariaDB support
- Database connection pooling (optional, experimental)
- Persistent connections (configurable)
- Session storage (database or file)
- ORM using Fat-Free Framework

---

## API Endpoints

### Public Routes
**File:** `app/routes.ini`

- `GET /` - Login page
- `GET /setup` - Database setup page (should be disabled in production)
- `GET /sso/:action` - CCP SSO callback
- `GET /map` - Main map interface
- `GET /admin` - Admin panel

### AJAX API Endpoints
**Format:** `/api/:controller/:action[/:arg1[/:arg2]]`

#### Map API (`/api/Map/`)
- `initData` - Get static initialization data
- `import` - Import map data
- `getAccessData` - Get map access information
- `updateData` - Update map data (long polling)
- `updateUnloadData` - Final map sync on page unload
- `updateUserData` - Update user data (long polling)
- `getConnectionData` - Get connection information
- `getLogData` - Get map history logs

#### System API (`/api/System/`)
- `setDestination` - Set in-game destination
- `pokeRally` - Send rally point notifications

#### User API (`/api/User/`)
- `getCookieCharacter` - Get character from cookie
- `getCaptcha` - Get CAPTCHA (if enabled)
- `logout` - Logout current character
- `openIngameWindow` - Open EVE client window
- `saveAccount` - Save account settings
- `deleteAccount` - Delete user account

#### Access API (`/api/Access/`)
- Character/corporation/alliance access verification

#### Universe API (`/api/Universe/`)
- Universe data queries
- System searches
- Region/constellation data

#### Statistic API (`/api/Statistic/`)
- Activity statistics
- Map usage statistics

#### GitHub API (`/api/GitHub/`)
- Version checks
- Release information

#### Setup API (`/api/Setup/`)
- Database setup operations
- System requirements check

### REST API Endpoints
**Format:** `/api/rest/:controller[/:id]`  
**Methods:** GET, POST, PUT, DELETE

#### Map REST (`/api/rest/Map`)
- CRUD operations for maps

#### System REST (`/api/rest/System`)
- CRUD operations for systems
- System search
- System graph data

#### Connection REST (`/api/rest/Connection`)
- CRUD operations for connections

#### Signature REST (`/api/rest/Signature`)
- CRUD operations for signatures
- Signature history

#### Structure REST (`/api/rest/Structure`)
- CRUD operations for structures (POCOs, Citadels)

#### Route REST (`/api/rest/Route`)
- Route search and pathfinding

#### Log REST (`/api/rest/Log`)
- Activity log queries

#### SystemThera REST (`/api/rest/SystemThera`)
- Thera connection data from Eve-Scout

---

## Configuration & Limits

### System Timers
**File:** `app/pathfinder.ini`

- **Login:** 480 minutes (8 hours) - auto-logout after inactivity
- **Double-click:** 250 milliseconds
- **Status visibility:** 5,000 milliseconds
- **Map update delay:** 5,000 milliseconds (AJAX long polling)
- **Map update execution limit:** 500 milliseconds
- **Client map update limit:** 100 milliseconds
- **User data update delay:** 5,000 milliseconds
- **User data update execution limit:** 1,000 milliseconds
- **Client user data update limit:** 100 milliseconds

### Connection Expiration
**File:** `app/pathfinder.ini`

- **EOL connections:** 15,300 seconds (4h 15m)
- **WH connections:** 172,800 seconds (2 days, configurable per map)
- **Signatures:** 259,200 seconds (3 days, configurable per map)

### Map Limits by Type

| Setting | Private | Corporation | Alliance |
|---------|---------|-------------|----------|
| Lifetime | 60 days | 99,999 days | 99,999 days |
| Max Count | 3 | 5 | 4 |
| Max Shared | 10 | 4 | 2 |
| Max Systems | 50 | 100 | 100 |

### System Configuration
**File:** `app/config.ini`

- Debug mode (0-3)
- Error reporting level
- Cache backend (file/redis)
- Database configuration
- Temp directory permissions
- Log directory permissions
- History directory permissions

---

## Database Models

### Pathfinder Models
**Location:** `app/Model/Pathfinder/`

- **User & Character:**
  - `UserModel` - User accounts
  - `CharacterModel` - EVE Online characters
  - `UserCharacterModel` - User-character relationships
  - `CharacterAuthenticationModel` - Authentication tokens
  - `CharacterLogModel` - Character activity logs
  - `CharacterStatusModel` - Character status types
  - `CharacterMapModel` - Character-map access

- **Corporation & Alliance:**
  - `CorporationModel` - Corporation data
  - `CorporationMapModel` - Corporation-map access
  - `CorporationRightModel` - Corporation permissions
  - `CorporationStructureModel` - Corporation structures
  - `AllianceModel` - Alliance data
  - `AllianceMapModel` - Alliance-map access

- **Map:**
  - `MapModel` - Map data and configuration
  - `MapTypeModel` - Map types (private, corp, alliance)
  - `MapScopeModel` - Map scopes

- **System:**
  - `SystemModel` - System instances on maps
  - `SystemTypeModel` - System types
  - `SystemStatusModel` - System status types
  - `SystemSignatureModel` - Signatures in systems
  - `SystemJumpModel` - Jump statistics
  - `SystemShipKillModel` - Ship kill statistics
  - `SystemPodKillModel` - Pod kill statistics
  - `SystemFactionKillModel` - Faction kill statistics

- **Connection:**
  - `ConnectionModel` - Connections between systems
  - `ConnectionScopeModel` - Connection scopes
  - `ConnectionLogModel` - Connection activity logs

- **Structure:**
  - `StructureModel` - Structures (POCOs, Citadels)
  - `StructureStatusModel` - Structure status types

- **Other:**
  - `ActivityLogModel` - Activity tracking
  - `RoleModel` - User roles
  - `RightModel` - Access rights
  - `CronModel` - Cronjob tracking

### Universe Models
**Location:** `app/Model/Universe/`

- Static EVE universe data
- System data (name, security, class, effect, statics)
- Constellation data
- Region data
- Sovereignty data
- Faction warfare data

### Abstract Models
**File:** `app/Model/AbstractModel.php`

- Base model with common functionality
- ORM integration
- Validation
- Timestamps
- Soft delete support
- Caching integration

---

## Known Pain Points

### Performance Issues

1. **AJAX Long Polling:**
   - Default update mechanism (5-second intervals)
   - Can cause high server load with many active users
   - WebSocket support exists but not default
   - Update execution time warnings if exceeds limits

2. **Character Auto-Location:**
   - Increases server load due to frequent location checks
   - Can be disabled globally or per-character
   - Requires ESI API calls per active character

3. **Large Maps:**
   - Performance degrades with 100+ systems
   - Connection rendering can be slow
   - DataTable performance with many signatures

4. **Map History Logging:**
   - Log files can grow large (2 MB threshold)
   - Truncation required via cronjob
   - File I/O overhead

### User Experience Issues

1. **Map Import/Export:**
   - JSON format only
   - No validation feedback before import
   - Large maps can fail to export

2. **Signature Management:**
   - Manual signature updates required
   - Paste from game clipboard not always reliable
   - No automatic signature scanning

3. **Connection Management:**
   - No bulk connection operations
   - Mass tracking is manual
   - EOL timer management is manual

4. **Mobile Support:**
   - Desktop-focused interface
   - Touch interactions not optimized
   - Small screen layout issues

### Integration Issues

1. **ESI API:**
   - Rate limiting can cause issues
   - Fallback to custom route search is slower
   - Character location updates require scopes
   - Token refresh complexity

2. **Slack/Discord:**
   - Configuration per map is tedious
   - No message formatting options
   - No retry on webhook failures
   - No message preview

3. **External APIs:**
   - Dotlan/zKillboard/Eve-Scout can be slow or unavailable
   - No caching of external API responses
   - No fallback when services are down

### Administration Issues

1. **Setup Route:**
   - Must be manually disabled in production
   - Presents security risk if left enabled
   - No automated setup process

2. **Character Kick/Ban:**
   - Limited duration options
   - No clear permanent ban option
   - No IP-based blocking

3. **Map Management:**
   - No bulk map operations
   - No map archiving
   - Limited map statistics

4. **Cronjob Dependency:**
   - Requires external cron setup
   - No built-in scheduler
   - No job failure notifications

### Security Concerns

1. **SSO Token Storage:**
   - Tokens stored in database
   - Token refresh mechanism complexity
   - No token encryption at rest

2. **Session Management:**
   - Cookie-based sessions
   - Session sharing can be security risk
   - No IP validation

3. **Access Control:**
   - Role system is basic
   - No granular permissions
   - No audit trail for access changes

---

## Migration Considerations

### Critical Features (Must Have in New System)

1. **Map CRUD** - Create, read, update, delete maps
2. **System Management** - Add, move, update, delete systems
3. **Connection Management** - Create, update, delete connections
4. **Signature Management** - Add, edit, delete signatures
5. **Route Finding** - Find routes between systems
6. **Real-time Updates** - Multi-user collaboration
7. **CCP SSO** - EVE Online authentication
8. **Character Switching** - Multiple characters per user
9. **Access Control** - Map sharing with characters/corps/alliances
10. **Map Import/Export** - Backup and restore functionality

### High-Priority Features

1. Slack/Discord integration
2. Rally point notifications
3. Character location tracking
4. System statistics (jumps, kills)
5. Wormhole effect information
6. Map history logging
7. Activity statistics
8. Admin panel (kick/ban)
9. External API integration (Dotlan, zKillboard, Eve-Scout)
10. Auto-cleanup (expired connections, signatures, maps)

### Medium-Priority Features

1. Structure management
2. System tags
3. Connection mass tracking
4. Signature history
5. Map settings (persistent aliases, track abyssal, etc.)
6. Thera connections
7. System intel/notes
8. Keyboard shortcuts
9. Map overlays (region labels, grid)
10. Compact system layout

### Low-Priority Features

1. Email notifications
2. Demo module
3. Manual/help dialog
4. Changelog display
5. API status monitoring
6. Credits/contributors
7. Session sharing
8. Custom map icons
9. Advanced statistics
10. Debug panel

### Features to Reconsider/Improve

1. **AJAX Long Polling** → Replace with WebSocket or Server-Sent Events
2. **File-based History Logs** → Use database or structured logging service
3. **Manual Setup Route** → Automated setup wizard with security
4. **JSON Import/Export** → Add validation, progress indicators, error recovery
5. **File Cache** → Default to Redis or modern caching solution
6. **Manual Signature Updates** → Auto-sync if possible
7. **Limited Kick/Ban Options** → Improved admin moderation tools
8. **Static ESI Scopes** → Dynamic scope management
9. **Single-language UI** → Multi-language support
10. **Desktop-only UI** → Mobile-responsive design

### Technical Debt to Address

1. Modernize authentication flow (token storage, refresh)
2. Improve error handling and user feedback
3. Add comprehensive API documentation
4. Implement proper API versioning
5. Add integration tests
6. Improve database query performance
7. Add monitoring and observability
8. Implement rate limiting
9. Add feature flags for gradual rollout
10. Improve security (token encryption, CSP, CORS)

---

## Summary Statistics

- **Total PHP Controllers:** 8+ main controllers
- **Total API Endpoints:** 40+ distinct endpoints
- **Total REST Resources:** 13 resource types
- **Total Database Models:** 40+ models
- **Total JavaScript Modules:** 13 UI modules
- **Total Dialogs:** 13 dialog types
- **Total Cronjobs:** 13 scheduled jobs
- **Lines of Code (Main Files):**
  - `map.js`: ~3,449 lines
  - `MapModel.php`: ~1,500 lines
  - `CharacterModel.php`: ~1,482 lines
  - `Map.php` (Controller): ~1,097 lines

---

## Next Steps for Migration

1. **Review & Validate:** Share this document with stakeholders and power users
2. **Prioritize Features:** Rank features by business value and technical feasibility
3. **Define MVP:** Determine minimum viable product for new stack
4. **Architecture Design:** Design Convex schema and Vue 3 component structure
5. **Migration Plan:** Create phased migration plan with rollback strategy
6. **Data Migration:** Plan database migration from MySQL to Convex
7. **Testing Strategy:** Define testing approach (unit, integration, E2E)
8. **User Communication:** Prepare users for transition and gather feedback
9. **Parallel Development:** Consider running both systems during transition
10. **Documentation:** Create user and developer documentation for new system

---

**Document Version:** 1.0  
**Last Updated:** November 2025  
**Maintained By:** Migration Team
