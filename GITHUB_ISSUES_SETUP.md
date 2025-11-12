# GitHub Issues Setup for Pathfinder Migration

**Epic and Issue Structure for Migration to Convex + Vue 3**  
**Based on:** [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md)

---

## Epic: Pathfinder Migration to Convex + Vue 3

**Epic Title:** Migrate Pathfinder to Convex self-hosted database and Vue 3 frontend

**Epic Description:**

Complete migration of the Pathfinder EVE Online mapping tool from the current stack (PHP, JavaScript, MySQL) to a modern stack with Convex self-hosted database and Vue 3 frontend.

**Goals:**
- Maintain all existing features (100+ documented features)
- Improve performance (especially for large maps with 100+ systems)
- Replace AJAX long polling with WebSocket for real-time updates
- Enhance mobile responsiveness
- Modernize codebase for better maintainability

**Timeline:** 42 weeks (~10 months)

**Documentation:**
- [FEATURE_DOCUMENTATION.md](./FEATURE_DOCUMENTATION.md) - Complete feature inventory
- [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md) - Detailed migration plan
- [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) - Quick feature reference
- [MIGRATION_README.md](./MIGRATION_README.md) - Documentation guide

**Labels:** `epic`, `migration`, `enhancement`

---

## Pre-Migration Phase Issues

### Issue 1: Documentation Review and Validation

**Title:** Review and validate migration documentation with stakeholders

**Description:**

Review the comprehensive migration documentation with all stakeholders to ensure completeness and accuracy.

**Tasks:**
- [ ] Review `FEATURE_DOCUMENTATION.md` with all stakeholders
- [ ] Identify any missing features or undocumented behaviors
- [ ] Validate feature priorities with actual users
- [ ] Document power user workflows
- [ ] Interview admins about hidden features
- [ ] Review existing GitHub issues for reported bugs and feature requests

**Acceptance Criteria:**
- All stakeholders have reviewed and approved the documentation
- Any missing features have been documented
- Feature priorities have been validated and documented

**Estimated Time:** 1 week

**Labels:** `documentation`, `pre-migration`, `stakeholder-review`

**Dependencies:** None

---

### Issue 2: Architecture Planning and Technical Design

**Title:** Design architecture for Convex + Vue 3 stack

**Description:**

Create comprehensive architecture design for the new Pathfinder system using Convex and Vue 3.

**Tasks:**
- [ ] Design Convex database schema
- [ ] Map current MySQL models to Convex schema
- [ ] Plan data migration strategy
- [ ] Design Vue 3 component hierarchy
- [ ] Choose state management solution (Pinia/Vuex)
- [ ] Plan real-time update strategy (WebSocket/SSE)
- [ ] Design API layer architecture
- [ ] Plan authentication/authorization flow

**Deliverables:**
- Architecture diagrams
- Database schema documentation
- Component hierarchy documentation
- API specification

**Estimated Time:** 2 weeks

**Labels:** `architecture`, `pre-migration`, `technical-design`

**Dependencies:** Issue #1 (Documentation Review)

---

### Issue 3: Technology Stack Selection

**Title:** Select and validate technology choices for migration

**Description:**

Make final decisions on technology choices and validate them with prototypes.

**Tasks:**
- [ ] Choose UI component library (Vuetify/Element Plus/etc.)
- [ ] Select map rendering library (jsPlumb replacement)
- [ ] Decide on routing library (Vue Router)
- [ ] Choose form handling approach
- [ ] Select testing framework (Vitest/Jest)
- [ ] Decide on build tool (Vite/Webpack)
- [ ] Plan deployment strategy
- [ ] Choose monitoring/observability tools

**Deliverables:**
- Technology stack documentation
- Proof-of-concept prototypes
- Justification for each technology choice

**Estimated Time:** 2 weeks

**Labels:** `pre-migration`, `technical-decision`, `research`

**Dependencies:** Issue #2 (Architecture Planning)

---

## Phase 1: MVP (Minimum Viable Product)

### Issue 4: Core Authentication System

**Title:** Implement CCP SSO authentication and character management

**Description:**

Build the core authentication system using CCP SSO with character management and session handling.

**Tasks:**
- [ ] Implement CCP SSO integration
- [ ] Create character authentication flow
- [ ] Implement session management
- [ ] Add character switching capability
- [ ] Set up token refresh mechanism
- [ ] Create login/logout UI

**Acceptance Criteria:**
- Users can log in via CCP SSO
- Character switching works correctly
- Sessions persist across page reloads
- Token refresh works automatically
- UI matches design specifications

**Estimated Time:** 2 weeks

**Labels:** `phase-1`, `mvp`, `authentication`, `critical`

**Dependencies:** Issue #3 (Technology Stack Selection)

---

### Issue 5: Basic Map Management

**Title:** Implement map CRUD operations and UI

**Description:**

Create the foundational map management system with create, read, update, delete operations.

**Tasks:**
- [ ] Create map data model in Convex
- [ ] Implement map CRUD operations
- [ ] Build map creation UI
- [ ] Build map list/selection UI
- [ ] Implement map settings dialog
- [ ] Add map import/export (JSON)

**Acceptance Criteria:**
- Users can create, edit, and delete maps
- Map settings can be configured
- Maps can be imported and exported
- Map limits are enforced (private: 3, corp: 5, alliance: 4)

**Estimated Time:** 2 weeks

**Labels:** `phase-1`, `mvp`, `maps`, `critical`

**Dependencies:** Issue #4 (Core Authentication)

---

### Issue 6: System Management

**Title:** Implement system placement and management on maps

**Description:**

Build the system management features including adding, moving, and configuring systems on maps.

**Tasks:**
- [ ] Create system data model in Convex
- [ ] Implement system CRUD operations
- [ ] Build system rendering on map canvas
- [ ] Add drag-and-drop system positioning
- [ ] Implement system selection
- [ ] Add system information display
- [ ] Integrate EVE universe data

**Acceptance Criteria:**
- Systems can be added to maps
- Systems can be moved via drag-and-drop
- System information displays correctly
- EVE universe data integrates properly
- System limits are enforced (private: 50, corp/alliance: 100)

**Estimated Time:** 2 weeks

**Labels:** `phase-1`, `mvp`, `systems`, `critical`

**Dependencies:** Issue #5 (Basic Map Management)

---

### Issue 7: Connection Management

**Title:** Implement connection creation and management between systems

**Description:**

Build connection management features for creating and managing connections between systems.

**Tasks:**
- [ ] Create connection data model in Convex
- [ ] Implement connection CRUD operations
- [ ] Build connection rendering
- [ ] Add drag-to-connect functionality
- [ ] Implement connection properties editing
- [ ] Add connection type indicators (WH/stargate/jumpbridge)

**Acceptance Criteria:**
- Connections can be created by dragging between systems
- Connection properties can be edited
- Connection types display correctly
- Visual rendering works for all connection types

**Estimated Time:** 2 weeks

**Labels:** `phase-1`, `mvp`, `connections`, `critical`

**Dependencies:** Issue #6 (System Management)

---

### Issue 8: Real-time Updates

**Title:** Implement WebSocket-based real-time collaboration

**Description:**

Replace AJAX long polling with WebSocket for real-time map updates and collaboration.

**Tasks:**
- [ ] Implement WebSocket/SSE for map updates
- [ ] Add optimistic UI updates
- [ ] Handle conflict resolution
- [ ] Implement user presence indicators
- [ ] Add activity notifications

**Acceptance Criteria:**
- Map updates appear in real-time for all users
- Optimistic updates work correctly
- Conflicts are resolved gracefully
- User presence is visible
- Performance is better than current AJAX polling

**Estimated Time:** 2 weeks

**Labels:** `phase-1`, `mvp`, `real-time`, `critical`, `performance`

**Dependencies:** Issue #7 (Connection Management)

---

### Issue 9: MVP Testing and Refinement

**Title:** Test and refine MVP features

**Description:**

Comprehensive testing and refinement of all MVP features before moving to Phase 2.

**Tasks:**
- [ ] Write unit tests for core features
- [ ] Write integration tests
- [ ] Perform user acceptance testing
- [ ] Fix critical bugs
- [ ] Optimize performance

**Acceptance Criteria:**
- Test coverage > 80% for critical features
- All critical bugs fixed
- UAT feedback incorporated
- Performance benchmarks met

**Estimated Time:** 2 weeks

**Labels:** `phase-1`, `mvp`, `testing`, `quality-assurance`

**Dependencies:** Issue #8 (Real-time Updates)

---

## Phase 2: Essential Features

### Issue 10: Signature Management

**Title:** Implement signature tracking and management

**Description:**

Build signature management system for tracking wormhole signatures and anomalies.

**Tasks:**
- [ ] Create signature data model
- [ ] Implement signature CRUD operations
- [ ] Build signature table UI
- [ ] Add signature paste from clipboard
- [ ] Implement signature history
- [ ] Add signature auto-cleanup

**Acceptance Criteria:**
- Signatures can be added, edited, deleted
- Paste from game works correctly
- Signature history is tracked
- Auto-cleanup works (3-day default)

**Estimated Time:** 1.5 weeks

**Labels:** `phase-2`, `signatures`, `high-priority`

**Dependencies:** Issue #9 (MVP Testing)

---

### Issue 11: Route Finding

**Title:** Implement route finding and waypoint system

**Description:**

Build route finding features using ESI API and custom pathfinding algorithm.

**Tasks:**
- [ ] Integrate ESI route API
- [ ] Implement custom pathfinding algorithm
- [ ] Build route display UI
- [ ] Add route settings dialog
- [ ] Implement waypoint setting

**Acceptance Criteria:**
- Routes can be found between any two systems
- ESI API integration works
- Fallback algorithm works when ESI fails
- Waypoints can be set in-game via ESI

**Estimated Time:** 1.5 weeks

**Labels:** `phase-2`, `routing`, `high-priority`

**Dependencies:** Issue #9 (MVP Testing)

---

### Issue 12: Access Control

**Title:** Implement map sharing and access control

**Description:**

Build access control system for sharing maps with characters, corporations, and alliances.

**Tasks:**
- [ ] Implement map sharing model
- [ ] Add character access control
- [ ] Add corporation access control
- [ ] Add alliance access control
- [ ] Build access management UI

**Acceptance Criteria:**
- Maps can be shared with specific characters/corps/alliances
- Access limits are enforced
- Permissions work correctly
- UI is intuitive

**Estimated Time:** 1.5 weeks

**Labels:** `phase-2`, `access-control`, `high-priority`

**Dependencies:** Issue #9 (MVP Testing)

---

### Issue 13: Map Type Features

**Title:** Implement map type-specific features and constraints

**Description:**

Implement specific features and constraints for private, corporation, and alliance maps.

**Tasks:**
- [ ] Implement private map constraints
- [ ] Implement corporation map constraints
- [ ] Implement alliance map constraints
- [ ] Add map type-specific features
- [ ] Enforce map limits

**Acceptance Criteria:**
- All map type limits enforced correctly
- Type-specific features work as documented
- Logging/notifications work per type

**Estimated Time:** 1.5 weeks

**Labels:** `phase-2`, `maps`, `high-priority`

**Dependencies:** Issue #12 (Access Control)

---

## Phase 3: Integration Features

### Issue 14: CCP ESI Integration

**Title:** Implement CCP ESI API integration for system data

**Description:**

Integrate with CCP's ESI API for system statistics, character location, and sovereignty data.

**Tasks:**
- [ ] Implement system statistics import (jumps, kills)
- [ ] Add character location tracking
- [ ] Implement sovereignty data import
- [ ] Add structure discovery
- [ ] Implement auto-location select feature

**Acceptance Criteria:**
- System statistics update regularly
- Character location tracking works
- Sovereignty data is accurate
- Performance is acceptable

**Estimated Time:** 2 weeks

**Labels:** `phase-3`, `integration`, `esi-api`

**Dependencies:** Issue #13 (Map Type Features)

---

### Issue 15: Slack Integration

**Title:** Implement Slack webhook integration

**Description:**

Build Slack integration for map update notifications and rally point pokes.

**Tasks:**
- [ ] Create Slack webhook integration
- [ ] Add map history notifications
- [ ] Add rally point notifications
- [ ] Build Slack settings UI
- [ ] Test notification delivery

**Acceptance Criteria:**
- Slack notifications work correctly
- Settings are configurable per map
- Messages are formatted properly

**Estimated Time:** 1 week

**Labels:** `phase-3`, `integration`, `slack`

**Dependencies:** Issue #14 (CCP ESI Integration)

---

### Issue 16: Discord Integration

**Title:** Implement Discord webhook integration

**Description:**

Build Discord integration for map update notifications and rally point pokes.

**Tasks:**
- [ ] Create Discord webhook integration
- [ ] Add map history notifications
- [ ] Add rally point notifications
- [ ] Build Discord settings UI
- [ ] Test notification delivery

**Acceptance Criteria:**
- Discord notifications work correctly
- Settings are configurable per map
- Messages are formatted properly

**Estimated Time:** 1 week

**Labels:** `phase-3`, `integration`, `discord`

**Dependencies:** Issue #15 (Slack Integration)

---

### Issue 17: External API Integration

**Title:** Integrate external APIs (Dotlan, zKillboard, Eve-Scout, Anoik)

**Description:**

Integrate with external third-party APIs for additional data and functionality.

**Tasks:**
- [ ] Integrate Dotlan links
- [ ] Integrate zKillboard data
- [ ] Integrate Eve-Scout Thera connections
- [ ] Add Anoik.is wormhole info
- [ ] Implement API caching

**Acceptance Criteria:**
- All external links work correctly
- Data displays properly
- Caching improves performance
- Graceful fallback when APIs are down

**Estimated Time:** 2 weeks

**Labels:** `phase-3`, `integration`, `external-apis`

**Dependencies:** Issue #16 (Discord Integration)

---

## Phase 4: Advanced Features

### Issue 18: Admin Panel

**Title:** Build admin panel for user and map management

**Description:**

Create admin panel with user management, moderation, and monitoring capabilities.

**Tasks:**
- [ ] Create admin authentication
- [ ] Build admin dashboard
- [ ] Implement user management (kick/ban)
- [ ] Add map management tools
- [ ] Implement admin action logging
- [ ] Create admin notifications

**Acceptance Criteria:**
- Admins can access admin panel
- User moderation works correctly
- All actions are logged
- UI is functional and intuitive

**Estimated Time:** 2 weeks

**Labels:** `phase-4`, `admin`, `moderation`

**Dependencies:** Issue #17 (External API Integration)

---

### Issue 19: Visualization Modules

**Title:** Build data visualization modules

**Description:**

Create modules for visualizing system information, statistics, and analytics.

**Tasks:**
- [ ] Build system info module
- [ ] Build connection info module
- [ ] Build killboard module
- [ ] Build intel module
- [ ] Build graph/statistics module
- [ ] Build route module

**Acceptance Criteria:**
- All modules display correctly
- Data updates in real-time
- UI is responsive and performant

**Estimated Time:** 2.5 weeks

**Labels:** `phase-4`, `visualization`, `ui-modules`

**Dependencies:** Issue #18 (Admin Panel)

---

### Issue 20: Advanced Map Features

**Title:** Implement advanced map features and overlays

**Description:**

Add advanced map features like tagging, overlays, and multi-select operations.

**Tasks:**
- [ ] Implement system tagging
- [ ] Add map overlays (regions, grid)
- [ ] Implement compact layout mode
- [ ] Add connection signature overlays
- [ ] Implement magnetization/snapping
- [ ] Add multi-select operations

**Acceptance Criteria:**
- All features work as documented
- Performance is acceptable
- UI is intuitive

**Estimated Time:** 2.5 weeks

**Labels:** `phase-4`, `maps`, `advanced-features`

**Dependencies:** Issue #19 (Visualization Modules)

---

### Issue 21: Structure Management

**Title:** Implement structure tracking and management

**Description:**

Build structure management system for tracking POCOs, citadels, and other structures.

**Tasks:**
- [ ] Create structure data model
- [ ] Implement structure CRUD operations
- [ ] Add structure tracking
- [ ] Build structure UI

**Acceptance Criteria:**
- Structures can be tracked on maps
- ESI integration works for structures
- UI is functional

**Estimated Time:** 1 week

**Labels:** `phase-4`, `structures`

**Dependencies:** Issue #20 (Advanced Map Features)

---

## Phase 5: Optimization & Polish

### Issue 22: Performance Optimization

**Title:** Optimize performance for large maps and datasets

**Description:**

Optimize rendering, queries, and data handling for better performance.

**Tasks:**
- [ ] Optimize map rendering for large maps
- [ ] Implement lazy loading for signatures
- [ ] Add pagination for large datasets
- [ ] Optimize database queries
- [ ] Implement caching strategy
- [ ] Add CDN for static assets

**Acceptance Criteria:**
- 100+ system maps render smoothly
- Load times are < 2 seconds
- Database queries are optimized
- Caching improves performance measurably

**Estimated Time:** 2 weeks

**Labels:** `phase-5`, `performance`, `optimization`

**Dependencies:** Issue #21 (Structure Management)

---

### Issue 23: User Experience Enhancements

**Title:** Improve user experience and mobile responsiveness

**Description:**

Polish the user experience with better error handling, mobile support, and UX improvements.

**Tasks:**
- [ ] Improve error messages
- [ ] Add loading indicators
- [ ] Implement undo/redo
- [ ] Add keyboard shortcuts
- [ ] Improve mobile responsiveness
- [ ] Add drag-and-drop improvements

**Acceptance Criteria:**
- Error messages are helpful and clear
- Mobile experience is usable
- Keyboard shortcuts work
- Undo/redo works correctly

**Estimated Time:** 2 weeks

**Labels:** `phase-5`, `ux`, `mobile`, `polish`

**Dependencies:** Issue #22 (Performance Optimization)

---

### Issue 24: Background Jobs

**Title:** Implement background jobs and scheduled tasks

**Description:**

Create background job system for cleanup and maintenance tasks in Convex.

**Tasks:**
- [ ] Implement scheduled jobs in Convex
- [ ] Add expired connection cleanup
- [ ] Add expired signature cleanup
- [ ] Add expired map cleanup
- [ ] Add character log cleanup
- [ ] Implement statistics aggregation

**Acceptance Criteria:**
- All cleanup jobs run on schedule
- Jobs don't impact user performance
- Statistics are aggregated correctly

**Estimated Time:** 1 week

**Labels:** `phase-5`, `background-jobs`, `maintenance`

**Dependencies:** Issue #23 (UX Enhancements)

---

### Issue 25: Security Hardening

**Title:** Implement security improvements and perform audit

**Description:**

Harden security with encryption, rate limiting, and security best practices.

**Tasks:**
- [ ] Implement token encryption at rest
- [ ] Add rate limiting
- [ ] Implement CSP headers
- [ ] Add CORS configuration
- [ ] Perform security audit
- [ ] Fix identified vulnerabilities

**Acceptance Criteria:**
- Security audit passes
- All vulnerabilities fixed
- Rate limiting prevents abuse
- CSP and CORS configured correctly

**Estimated Time:** 1 week

**Labels:** `phase-5`, `security`, `critical`

**Dependencies:** Issue #24 (Background Jobs)

---

## Phase 6: Migration & Deployment

### Issue 26: Data Migration

**Title:** Migrate existing data from MySQL to Convex

**Description:**

Execute data migration from current MySQL database to new Convex database.

**Tasks:**
- [ ] Export existing MySQL data
- [ ] Transform data for Convex schema
- [ ] Import data to Convex
- [ ] Validate data integrity
- [ ] Test data access patterns

**Acceptance Criteria:**
- All data migrated successfully
- Zero data loss
- Data integrity validated
- Performance is acceptable

**Estimated Time:** 2 weeks

**Labels:** `phase-6`, `migration`, `data`, `critical`

**Dependencies:** Issue #25 (Security Hardening)

---

### Issue 27: Deployment Preparation

**Title:** Prepare production environment and deployment strategy

**Description:**

Set up production infrastructure and prepare for deployment.

**Tasks:**
- [ ] Set up production Convex instance
- [ ] Configure production environment
- [ ] Set up monitoring and logging
- [ ] Create deployment documentation
- [ ] Plan rollback strategy

**Acceptance Criteria:**
- Production environment ready
- Monitoring and logging configured
- Rollback plan documented
- Deployment documentation complete

**Estimated Time:** 1.5 weeks

**Labels:** `phase-6`, `deployment`, `infrastructure`

**Dependencies:** Issue #26 (Data Migration)

---

### Issue 28: User Communication and Training

**Title:** Prepare user communication and training materials

**Description:**

Create user guides, announcements, and training materials for the migration.

**Tasks:**
- [ ] Create migration announcement
- [ ] Write user guide for new system
- [ ] Create video tutorials
- [ ] Plan user training sessions
- [ ] Set up support channels

**Acceptance Criteria:**
- User guide is complete
- Video tutorials are published
- Support channels are ready
- Migration announcement is prepared

**Estimated Time:** 1.5 weeks

**Labels:** `phase-6`, `documentation`, `training`

**Dependencies:** Issue #27 (Deployment Preparation)

---

### Issue 29: Gradual Rollout and Monitoring

**Title:** Execute gradual rollout and monitor production

**Description:**

Roll out the new system gradually and monitor for issues.

**Tasks:**
- [ ] Deploy to staging environment
- [ ] Beta test with power users
- [ ] Fix beta feedback issues
- [ ] Gradual production rollout
- [ ] Monitor system performance
- [ ] Address production issues

**Acceptance Criteria:**
- Beta testing successful
- All critical issues resolved
- Production rollout successful
- System performance meets targets

**Estimated Time:** 2 weeks

**Labels:** `phase-6`, `deployment`, `rollout`, `critical`

**Dependencies:** Issue #28 (User Communication)

---

### Issue 30: Legacy System Sunset

**Title:** Sunset legacy system and final cleanup

**Description:**

Plan and execute the sunset of the old PHP/MySQL system.

**Tasks:**
- [ ] Plan legacy system sunset
- [ ] Maintain parallel systems during transition
- [ ] Migrate remaining users
- [ ] Archive legacy data
- [ ] Decommission old system

**Acceptance Criteria:**
- All users migrated
- Legacy data archived
- Old system decommissioned
- Migration complete

**Estimated Time:** 1 week

**Labels:** `phase-6`, `migration`, `cleanup`

**Dependencies:** Issue #29 (Gradual Rollout)

---

## Issue Dependencies Graph

```
Epic: Pathfinder Migration to Convex + Vue 3
│
├─ Pre-Migration Phase
│  ├─ Issue #1: Documentation Review
│  ├─ Issue #2: Architecture Planning (depends on #1)
│  └─ Issue #3: Technology Stack Selection (depends on #2)
│
├─ Phase 1: MVP
│  ├─ Issue #4: Core Authentication (depends on #3)
│  ├─ Issue #5: Basic Map Management (depends on #4)
│  ├─ Issue #6: System Management (depends on #5)
│  ├─ Issue #7: Connection Management (depends on #6)
│  ├─ Issue #8: Real-time Updates (depends on #7)
│  └─ Issue #9: MVP Testing (depends on #8)
│
├─ Phase 2: Essential Features
│  ├─ Issue #10: Signature Management (depends on #9)
│  ├─ Issue #11: Route Finding (depends on #9)
│  ├─ Issue #12: Access Control (depends on #9)
│  └─ Issue #13: Map Type Features (depends on #12)
│
├─ Phase 3: Integration Features
│  ├─ Issue #14: CCP ESI Integration (depends on #13)
│  ├─ Issue #15: Slack Integration (depends on #14)
│  ├─ Issue #16: Discord Integration (depends on #15)
│  └─ Issue #17: External API Integration (depends on #16)
│
├─ Phase 4: Advanced Features
│  ├─ Issue #18: Admin Panel (depends on #17)
│  ├─ Issue #19: Visualization Modules (depends on #18)
│  ├─ Issue #20: Advanced Map Features (depends on #19)
│  └─ Issue #21: Structure Management (depends on #20)
│
├─ Phase 5: Optimization & Polish
│  ├─ Issue #22: Performance Optimization (depends on #21)
│  ├─ Issue #23: UX Enhancements (depends on #22)
│  ├─ Issue #24: Background Jobs (depends on #23)
│  └─ Issue #25: Security Hardening (depends on #24)
│
└─ Phase 6: Migration & Deployment
   ├─ Issue #26: Data Migration (depends on #25)
   ├─ Issue #27: Deployment Preparation (depends on #26)
   ├─ Issue #28: User Communication (depends on #27)
   ├─ Issue #29: Gradual Rollout (depends on #28)
   └─ Issue #30: Legacy System Sunset (depends on #29)
```

---

## Labels to Create

- `epic`
- `migration`
- `enhancement`
- `documentation`
- `pre-migration`
- `stakeholder-review`
- `architecture`
- `technical-design`
- `technical-decision`
- `research`
- `phase-1`
- `phase-2`
- `phase-3`
- `phase-4`
- `phase-5`
- `phase-6`
- `mvp`
- `authentication`
- `maps`
- `systems`
- `connections`
- `signatures`
- `routing`
- `access-control`
- `integration`
- `esi-api`
- `slack`
- `discord`
- `external-apis`
- `admin`
- `moderation`
- `visualization`
- `ui-modules`
- `advanced-features`
- `structures`
- `performance`
- `optimization`
- `ux`
- `mobile`
- `polish`
- `background-jobs`
- `maintenance`
- `security`
- `data`
- `deployment`
- `infrastructure`
- `training`
- `rollout`
- `cleanup`
- `critical`
- `high-priority`
- `quality-assurance`
- `testing`
- `real-time`

---

## Milestones to Create

1. **Pre-Migration Phase Complete** - Target: Week 5
2. **Phase 1: MVP Complete** - Target: Week 17
3. **Phase 2: Essential Features Complete** - Target: Week 23
4. **Phase 3: Integration Features Complete** - Target: Week 29
5. **Phase 4: Advanced Features Complete** - Target: Week 37
6. **Phase 5: Optimization & Polish Complete** - Target: Week 41
7. **Phase 6: Migration Complete** - Target: Week 47

---

## Project Board Setup

**Board Name:** Pathfinder Migration

**Columns:**
1. **Backlog** - Issues not yet started
2. **Ready** - Issues ready to start (dependencies met)
3. **In Progress** - Currently being worked on
4. **In Review** - Code review/testing in progress
5. **Done** - Completed and merged

**Automation:**
- Move to "In Progress" when issue is assigned
- Move to "In Review" when PR is created
- Move to "Done" when PR is merged and issue is closed

---

## Getting Started

1. **Create Epic Issue:**
   - Create issue with epic description above
   - Add `epic` and `migration` labels
   - Pin the issue

2. **Create All Issues:**
   - Create issues #1-30 using the templates above
   - Assign appropriate labels
   - Set milestones
   - Link to epic

3. **Create Project Board:**
   - Set up columns and automation
   - Add all issues to backlog

4. **Set Up Labels:**
   - Create all labels listed above
   - Use consistent color scheme

5. **Assign Initial Issues:**
   - Assign pre-migration issues to team
   - Schedule kickoff meeting

---

**Next Steps:**
1. Review this setup with team
2. Create epic and issues in GitHub
3. Set up project board
4. Schedule sprint planning
5. Begin Pre-Migration Phase

---

**Document Version:** 1.0  
**Last Updated:** November 2025  
**Created From:** [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md)
