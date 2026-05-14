{{-- resources/views/admin/layouts/sidebar.blade.php --}}
<aside class="w-64 bg-gray-800 border-r border-gray-700">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-indigo-400">OTRS A</h2>
    </div>
    <nav class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Users
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Bookings
        </a>
        <a href="{{ route('admin.trips.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>
            Trips
        </a>
        <a href="{{ route('admin.payments.index') }}" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white transition">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            Payments
        </a>
    </nav>
</aside>