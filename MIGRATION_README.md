# Pathfinder Migration Documentation

**Prepared for:** Migration to Convex self-hosted database + Vue 3  
**Current System:** PHP + JavaScript + MySQL  
**Documentation Date:** November 2025

---

## 📚 Documentation Index

This directory contains comprehensive documentation for the Pathfinder migration project. Choose the document that best fits your needs:

### For All Stakeholders
**[QUICK_REFERENCE.md](./QUICK_REFERENCE.md)**
- Quick overview of features and workflows
- Common use cases and API endpoints
- Map type comparison
- Known issues and workarounds
- **Start here** for a high-level understanding

### For Technical Teams
**[FEATURE_DOCUMENTATION.md](./FEATURE_DOCUMENTATION.md)**
- Complete feature inventory (1,044 lines)
- All database models and relationships
- All API endpoints (AJAX and REST)
- Integration points (ESI, Slack, Discord)
- Configuration and limits
- Known pain points and technical debt
- **Essential reading** for developers and architects

### For Project Managers
**[MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md)**
- 6-phase migration plan (42 weeks)
- Detailed task breakdown
- Success metrics
- Risk management
- Resource requirements
- Timeline and milestones
- **Primary planning document** for the migration

---

## 🎯 Purpose

These documents serve as the foundation for migrating the Pathfinder mapping tool to a new technology stack. They ensure:

1. **No features are lost** - Complete inventory of current functionality
2. **Clear priorities** - Features categorized by importance
3. **Informed decisions** - Known issues and improvement opportunities documented
4. **Smooth transition** - Detailed migration plan with phases and tasks
5. **Team alignment** - Common reference for all stakeholders

---

## 🚀 Quick Start Guide

### If you're a **Product Owner** or **Stakeholder**:
1. Read [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) for feature overview
2. Review [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md) Phase 1 (MVP) to understand initial scope
3. Prioritize features based on business value
4. Schedule stakeholder review meeting

### If you're a **Developer**:
1. Start with [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) for context
2. Deep dive into [FEATURE_DOCUMENTATION.md](./FEATURE_DOCUMENTATION.md)
3. Review the "Known Pain Points" section for improvement opportunities
4. Check [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md) for your phase assignments
5. Begin architecture design for your assigned areas

### If you're a **Project Manager**:
1. Review [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md) completely
2. Adjust timeline based on team availability
3. Create project in your PM tool (Jira/Asana/etc.)
4. Import tasks from the checklist
5. Schedule team kickoff and phase planning meetings

### If you're a **Designer**:
1. Review [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) for user workflows
2. Check [FEATURE_DOCUMENTATION.md](./FEATURE_DOCUMENTATION.md) UI sections
3. Note "Known Pain Points" > "User Experience Issues"
4. Plan UI/UX improvements for the new system
5. Create mockups for Phase 1 features

### If you're a **QA Engineer**:
1. Read [FEATURE_DOCUMENTATION.md](./FEATURE_DOCUMENTATION.md) thoroughly
2. Create test scenarios for each feature category
3. Note edge cases and known issues
4. Review [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md) testing phases
5. Plan test automation strategy

---

## 📊 Documentation Statistics

- **Total Documentation:** ~1,800 lines across 3 documents
- **Features Documented:** 100+ distinct features
- **Database Models:** 40+ models
- **API Endpoints:** 40+ endpoints
- **UI Modules:** 13 modules
- **Dialogs:** 13 dialog types
- **Cronjobs:** 13 scheduled jobs
- **Migration Phases:** 6 phases over 42 weeks

---

## 🔍 Key Findings

### Critical Features (Must Have)
1. Map CRUD operations
2. System management (add, move, delete)
3. Connection management
4. Signature management
5. Route finding
6. Real-time updates
7. CCP SSO authentication
8. Character switching
9. Access control (map sharing)
10. Map import/export

### Major Pain Points to Address
1. AJAX long polling → Replace with WebSocket
2. Large map performance → Optimize rendering
3. Desktop-only UI → Mobile-responsive design
4. Manual signature updates → Auto-sync where possible
5. Limited mobile support → Touch-optimized interface

### Quick Wins for New System
1. Faster real-time updates (WebSocket vs polling)
2. Better error messages and user feedback
3. Improved map performance for 100+ systems
4. Modern UI with Vue 3
5. Better mobile experience

---

## 📅 Timeline Overview

| Phase | Duration | Focus |
|-------|----------|-------|
| **Phase 1: MVP** | 12 weeks | Core mapping, authentication, real-time |
| **Phase 2: Essential** | 6 weeks | Signatures, routes, access control |
| **Phase 3: Integration** | 6 weeks | ESI, Slack, Discord, external APIs |
| **Phase 4: Advanced** | 8 weeks | Admin, visualization, structures |
| **Phase 5: Polish** | 4 weeks | Performance, UX, security |
| **Phase 6: Migration** | 6 weeks | Data migration, deployment, rollout |
| **Total** | **42 weeks** | **~10 months** |

*Timeline assumes full-time dedicated team. Adjust based on actual resources.*

---

## 🎓 Learning Resources

### Convex Resources
- [Convex Self-Hosted Documentation](https://github.com/get-convex/convex-backend/blob/main/self-hosted/README.md)
- [Convex React/Vue Guide](https://docs.convex.dev/)

### Vue 3 Resources
- [Vue 3 Official Documentation](https://vuejs.org/)
- [Vue Router](https://router.vuejs.org/)
- [Pinia State Management](https://pinia.vuejs.org/)

### EVE Online Development
- [ESI API Documentation](https://esi.evetech.net/ui/)
- [EVE SSO Guide](https://developers.eveonline.com/blog/article/sso-to-authenticated-calls)
- [EVE Third-Party Developer Resources](https://developers.eveonline.com/)

---

## 🤝 Contributing to Documentation

Found something missing? Want to add more detail?

1. Review existing documentation
2. Identify gaps or unclear sections
3. Make updates in your branch
4. Submit PR with clear description of changes
5. Tag appropriate reviewers

---

## ❓ FAQ

**Q: Why migrate to a new stack?**  
A: To modernize the technology, improve performance, enhance maintainability, and enable future features.

**Q: Will all current features be migrated?**  
A: Yes, all critical and high-priority features will be migrated. Some low-priority features may be reconsidered or improved.

**Q: What happens to existing data?**  
A: All map data, characters, and history will be migrated to the new system.

**Q: Will there be downtime during migration?**  
A: The plan includes gradual rollout to minimize downtime. See [MIGRATION_CHECKLIST.md](./MIGRATION_CHECKLIST.md) Phase 6 for details.

**Q: How long will the migration take?**  
A: Estimated 42 weeks (~10 months) for a dedicated team. Timeline may vary based on resources.

**Q: Can I help with the migration?**  
A: Yes! Check the [project repository](https://github.com/NoxideLive/pathfinder) for contribution guidelines.

---

## 📞 Contact

- **Project Repository:** https://github.com/NoxideLive/pathfinder
- **Slack Channel:** pathfinder-eve-online.slack.com
- **Branch:** modern-rebuild

---

## 📝 Version History

| Version | Date | Changes |
|---------|------|---------|
| 1.0 | Nov 2025 | Initial documentation release |

---

**Next Steps:** 
1. Review documentation with your team
2. Schedule stakeholder meeting to discuss priorities
3. Begin Phase 1 planning
4. Set up development environment

**Good luck with the migration! 🚀**
