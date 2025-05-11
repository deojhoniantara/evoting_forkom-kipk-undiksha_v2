<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - E-Voting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { 
                        primary: '#4576D3',
                        accent: '#4DCEC6'
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary flex flex-col justify-between">
            <div>
                <div class="p-6 pb-2">
                    <h1 class="text-2xl font-bold text-white tracking-wide">E-Voting System</h1>
                </div>
                <nav class="mt-6">
                    <div class="px-2 space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg transition mb-1 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-primary font-semibold shadow' : 'text-white hover:bg-primary/80' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.candidates.index') }}" class="flex items-center px-4 py-2 rounded-lg transition mb-1 {{ request()->routeIs('admin.candidates.*') ? 'bg-white text-primary font-semibold shadow' : 'text-white hover:bg-primary/80' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Candidate</span>
                        </a>
                        <a href="{{ route('admin.voter-management.index') }}" class="flex items-center px-4 py-2 rounded-lg transition mb-1 {{ request()->routeIs('admin.voter-management.*') ? 'bg-white text-primary font-semibold shadow' : 'text-white hover:bg-primary/80' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0a4 4 0 11-8 0 4 4 0 018 0zm0 0v4m0-4V8" /></svg>
                            <span>Voter</span>
                        </a>
                        <a href="{{ route('admin.votes') }}" class="flex items-center px-4 py-2 rounded-lg transition mb-1 {{ request()->routeIs('admin.votes') ? 'bg-white text-primary font-semibold shadow' : 'text-white hover:bg-primary/80' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Votes</span>
                        </a>
                        <a href="{{ route('admin.statistics') }}" class="flex items-center px-4 py-2 rounded-lg transition mb-1 {{ request()->routeIs('admin.statistics') ? 'bg-white text-primary font-semibold shadow' : 'text-white hover:bg-primary/80' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <span>Statistics</span>
                        </a>
                    </div>
                </nav>
            </div>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm shadow-sm sticky top-0 z-10">
                <div class="flex justify-between items-center px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('title')</h2>
                    <div class="flex items-center space-x-3">
                        <div class="flex flex-col items-end">
                            <span class="font-bold text-gray-700 text-base leading-tight">FORKOM KIP-K</span>
                            <span class="text-xs text-gray-400 -mt-1">Undiksha</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-4">
                            @csrf
                            <button type="submit" title="Logout" class="text-gray-400 hover:text-primary transition-colors duration-200 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            <!-- Page Content -->
            <main class="p-6 flex-grow">
                @yield('content')
            </main>
            <footer class="bg-blue-200 text-xs text-primary font-semibold px-6 py-3 w-full mt-auto">
                © 2025. Develop with ♡ by Deo & Diva
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html> 