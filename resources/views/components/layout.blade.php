<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'My App' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen flex flex-col md:flex-row">
    <!-- Mobile Nav -->
    <div class="flex md:hidden justify-between items-center p-4 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-[#0a0a0a]">
        <div class="text-lg font-bold">My App</div>
        <button id="mobileMenuBtn" class="text-2xl focus:outline-none">&#9776;</button>
    </div>
    <!-- Sidebar -->
    <div id="sidebar" class="w-full md:w-64 flex-col border-r p-4 border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-[#0a0a0a] z-20 fixed md:static top-0 left-0 h-full md:flex hidden md:flex flex-shrink-0">
        <div class="p-4">
            <h2 class="text-xl font-semibold mb-8 text-[#1b1b18] dark:text-[#EDEDEC]">Menu</h2>
            <nav class="space-y-4">
                <a href="{{ route('dashboard') }}" class="block text-[#1b1b18] dark:text-[#EDEDEC] hover:underline">Dashboard</a>
                <a href="{{ route('posts.index') }}" class="block text-[#1b1b18] dark:text-[#EDEDEC] hover:underline">Posts</a>
                <a href="{{ route('platforms.index') }}" class="block text-[#1b1b18] dark:text-[#EDEDEC] hover:underline">Platform</a>
                <a href="{{ route('profile') }}" class="block text-[#1b1b18] dark:text-[#EDEDEC] hover:underline">User Profile</a>
            </nav>
        </div>
        @auth
        <div class="flex mb-4 mt-8 p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-500 hover:underline cursor-pointer">Logout</button>
            </form>
        </div>
        @endauth
    </div>
    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-30 z-10 hidden md:hidden"></div>
    <!-- Main content -->
    <main class="flex-1 p-4 md:p-6 max-w-full mt-16 md:mt-0">
        {{ $slot }}
    </main>
    <script>
        // Sidebar toggle for mobile
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const btn = document.getElementById('mobileMenuBtn');
        if(btn) {
            btn.onclick = () => {
                sidebar.classList.toggle('hidden');
                overlay.classList.toggle('hidden');
            };
        }
        if(overlay) {
            overlay.onclick = () => {
                sidebar.classList.add('hidden');
                overlay.classList.add('hidden');
            };
        }
    </script>
</body>
</html>
