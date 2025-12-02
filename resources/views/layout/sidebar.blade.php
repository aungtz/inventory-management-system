 <div class="flex min-h-screen">
        <!-- Sidebar -->
       <!-- Sidebar -->
        
<aside class="sidebar fixed lg:relative top-0 left-0 z-40 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 backdrop-blur border-r border-slate-700/80 shadow-xl lg:shadow-none">
  <!-- Logo Section -->
  <div class="p-6 border-b border-slate-700/80">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-md">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
      </div>
      <div>
        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
          Inventory Pro
        </h1>
        <p class="text-xs text-slate-400">Management System</p>
      </div>
    </div>
  </div>

  <!-- Navigation Menu -->
  <div class="p-4 space-y-2">
    <a href="/dashboard" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
      </svg>
      <span>Dashboard</span>
    </a>

    <a href="/items" class="flex items-center space-x-3 p-3 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <span>Items</span>
    </a>

     <a href="/items/create" class="flex items-center space-x-3 p-3 rounded-lg bg-blue-500/20 text-blue-400 border border-blue-500/30">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
      <span>Crate Items</span>
    </a>


    <a href="/products" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <span>Products</span>
    </a>

    <a href="/category" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      <span>Category</span>
    </a>

    <a href="/stock" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <span>Stock Control</span>
    </a>

    <a href="/sales" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <span>Sales</span>
    </a>

    <!-- IMPORT SECTION - Highlighted -->
    <div class="pt-4 pb-2">
      <div class="px-3 py-1">
        <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">IMPORT TOOLS</h3>
      </div>
    </div>

    <!-- Excel Import Button - Highlighted -->
    <a id="openExcelModal" href="/import-log" class="w-full flex items-center space-x-3 p-3 rounded-lg bg-gradient-to-r from-emerald-500/20 to-green-500/20 text-emerald-400 border border-emerald-500/30 hover:from-emerald-500/30 hover:to-green-500/30 hover:text-emerald-300 hover:border-emerald-400/50 transition-all duration-300 group">
  <div class="relative">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <span class="absolute -top-1 -right-1 flex h-3 w-3">
      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
    </span>
  </div>
  <span class="font-medium">Import Session</span>
  <span class="ml-auto px-2 py-1 text-xs bg-emerald-500/30 text-emerald-300 rounded-md">NEW</span>
</a>
    <!-- Batch Operations -->
  

    <!-- <a href="/items/batch-edit" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
      </svg>
      <span>Batch Edit</span>
    </a> -->

    <!-- OTHER TOOLS SECTION -->
    <div class="pt-4 pb-2">
      <div class="px-3 py-1">
        <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">OTHER TOOLS</h3>
      </div>
    </div>

    <a href="/reports" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      <span>Reports</span>
    </a>

    <a href="/settings" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      <span>Settings</span>
    </a>

    <a href="/login" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-700/50 transition-colors text-slate-300 hover:text-white mt-4">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
      </svg>
      <span>Logout</span>
    </a>
  </div>

  <!-- User Profile Section -->
  <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700/80 bg-slate-900/50 backdrop-blur">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center shadow-sm">
        <span class="text-white font-semibold">A</span>
      </div>
      <div class="flex-1">
        <p class="font-medium text-sm text-white">..</p>
        <p class="text-xs text-slate-400">..</p>
      </div>
      <button class="p-2 rounded-lg hover:bg-slate-700/50 transition-colors">
        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
      </button>
    </div>
  </div>
</aside>