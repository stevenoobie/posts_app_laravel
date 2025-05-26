<x-layout title="Edit Profile">
    <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>
    @if(session('status'))
        <div class="text-green-600 mb-4">{{ session('status') }}</div>
    @endif
    <x-user-profile-form :user="auth()->user()" />
</x-layout> 