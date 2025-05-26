@props(['user' => null])
@if($errors->any())
<div class="text-red-500">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('profile.update') }}" method="POST" class="space-y-4 max-w-lg flex flex-col">
    @csrf
    @method('PUT')

    <input type="text" name="name" placeholder="Name" value="{{ old('name', $user->name ?? '') }}" class="w-full border rounded px-3 py-2" required>

    <input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email ?? '') }}" class="w-full border rounded px-3 py-2" required>

    <input type="password" name="password" placeholder="New Password (leave blank to keep current)" class="w-full border rounded px-3 py-2">

    <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="w-full border rounded px-3 py-2">

    <button type="submit" class="btn-primary">Update Profile</button>
</form> 