# Mock Mode Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    Pathfinder UI Application                     │
└─────────────────────────────────────────────────────────────────┘
                              │
                              │ Initialization
                              ▼
        ┌─────────────────────────────────────────┐
        │      Check Mock Mode Enabled?           │
        │  (URL param / localStorage / global)    │
        └─────────────────────────────────────────┘
                     │                │
         YES ◄───────┘                └────────► NO
          │                                       │
          ▼                                       ▼
┌──────────────────────┐              ┌──────────────────────┐
│  MockInterceptor     │              │   Normal AJAX Flow   │
│  - Override $.ajax   │              │  - Direct to backend │
│  - Route to mock     │              │  - Real API calls    │
└──────────────────────┘              └──────────────────────┘
          │
          │ AJAX Request to /api/*
          ▼
┌──────────────────────────────────────────────────────┐
│            MockInterceptor.mockAjaxRequest           │
│  1. Simulate network delay (if configured)           │
│  2. Simulate failures (if configured)                │
│  3. Get mock data for endpoint                       │
│  4. Log request to console                           │
│  5. Return jQuery-compatible Promise                 │
└──────────────────────────────────────────────────────┘
          │
          ▼
┌──────────────────────────────────────────────────────┐
│            MockDataLoader.getMockData                │
│  - Map endpoint to mock data file                    │
│  - Load and parse JSON data                          │
│  - Return deep copy to prevent mutations             │
└──────────────────────────────────────────────────────┘
          │
          ▼
┌──────────────────────────────────────────────────────┐
│              Mock Data Files (JSON)                  │
│  ├── initData.json      (App initialization)         │
│  ├── serverStatus.json  (Server status)              │
│  ├── userData.json      (User/character data)        │
│  └── mapData.json       (Map systems & connections)  │
└──────────────────────────────────────────────────────┘
          │
          │ Return mock response
          ▼
┌──────────────────────────────────────────────────────┐
│        Application receives response                 │
│  - Same format as real API response                  │
│  - Triggers success/fail callbacks                   │
│  - Updates UI with mock data                         │
└──────────────────────────────────────────────────────┘


═══════════════════════════════════════════════════════════════

Activation Methods:

┌─────────────────────┐
│  Method 1: URL      │
│  ?mockMode=true     │
└─────────────────────┘
         │
         ▼
┌─────────────────────────────────┐
│  Method 2: localStorage         │
│  localStorage.setItem(...)      │
└─────────────────────────────────┘
         │
         ▼
┌─────────────────────────────────┐
│  Method 3: Global Config        │
│  window.PATHFINDER_MOCK_MODE    │
└─────────────────────────────────┘


═══════════════════════════════════════════════════════════════

Component Relationship:

    ┌─────────────────────────────────────┐
    │        Application Pages            │
    │  - login.js                         │
    │  - mappage.js                       │
    └─────────────────────────────────────┘
                  │
                  │ Initialize
                  ▼
    ┌─────────────────────────────────────┐
    │      MockInterceptor.init()         │
    │  - Detect mock mode                 │
    │  - Override $.ajax if enabled       │
    └─────────────────────────────────────┘
                  │
                  │ Uses
                  ▼
    ┌─────────────────────────────────────┐
    │         MockDataLoader              │
    │  - Load JSON files                  │
    │  - Map endpoints                    │
    │  - Provide utilities                │
    └─────────────────────────────────────┘
                  │
                  │ Loads
                  ▼
    ┌─────────────────────────────────────┐
    │      Mock Data Files (JSON)         │
    │  - Static sample data               │
    │  - Easy to extend                   │
    │  - Version controlled               │
    └─────────────────────────────────────┘


═══════════════════════════════════════════════════════════════

Request Flow Example:

    Application                MockInterceptor           MockDataLoader
        │                            │                         │
        │ $.ajax('/api/Map/initData')│                         │
        ├────────────────────────────►                         │
        │                            │                         │
        │                            │ getMockData(endpoint)   │
        │                            ├─────────────────────────►
        │                            │                         │
        │                            │ ◄───── JSON data ───────┤
        │                            │                         │
        │ ◄─── Promise w/ data ──────┤                         │
        │                            │                         │
        │ (UI updates with mock data)│                         │
        │                            │                         │


═══════════════════════════════════════════════════════════════

File Structure:

pathfinder/
├── MOCK_MODE.md                    📖 Full documentation
├── IMPLEMENTATION_SUMMARY.md       📋 Implementation details
├── mock-mode-example.html          🎨 Interactive guide
├── mock-mode-test.html             🧪 Test page
├── README.md                       📝 Updated with quick start
└── js/
    ├── app.js                      🔧 Added mock path config
    └── app/
        ├── login.js                ✨ Init MockInterceptor
        ├── mappage.js              ✨ Init MockInterceptor
        └── mock/
            ├── mockInterceptor.js  🎯 AJAX interceptor
            ├── mockDataLoader.js   📦 Data management
            └── data/
                ├── initData.json   📄 Init data
                ├── serverStatus.json 📄 Server status
                ├── userData.json   📄 User data
                └── mapData.json    📄 Map data


═══════════════════════════════════════════════════════════════

Configuration Options:

MockInterceptor.configure({
    enabled: true/false,          // Enable/disable
    simulateDelay: true/false,    // Simulate network delay
    delayMin: 100,               // Min delay (ms)
    delayMax: 500,               // Max delay (ms)
    failureRate: 0-1,            // Failure probability
    logRequests: true/false      // Console logging
});

```

## Key Benefits

1. **Zero Backend Required** - Develop UI without PHP/MySQL
2. **Fast Iteration** - No server restart, instant feedback
3. **Reproducible Tests** - Same data every time
4. **Easy to Enable** - Just add `?mockMode=true` to URL
5. **Extensible** - Add new endpoints in minutes
6. **Safe** - Production unaffected, easy to disable
7. **Well Documented** - Complete guides and examples

## Quick Start

```bash
# 1. Enable mock mode
http://localhost/pathfinder/?mockMode=true

# 2. Develop your feature
# 3. Check console for mock requests
# 4. Add custom mock data as needed
```
