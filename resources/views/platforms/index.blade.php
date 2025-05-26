<x-layout>
    <h2 class="text-xl font-bold mb-4 ">Manage Platforms</h2>
    @if(auth()->user()->is_admin)
    <form method="GET" action="{{ route('platforms.index') }}">
        <select name="user_id" onchange="this.form.submit()" class="py-4 mb-6">
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ $u->id === $user->id ? 'selected' : '' }}>
                    {{ $u->name }} ({{ $u->email }})
                </option>
            @endforeach
        </select>
    </form>
@endif

    @if(session('status'))
        <div class="text-green-600 mb-3">{{ session('status') }}</div>
    @endif

    @if(auth()->user()->is_admin)
    <form action="{{ route('platforms.toggle') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
    
        @foreach ($platforms as $platform)
            <div class="flex items-center mb-2">
                <input type="checkbox"
                       name="platforms[]"
                       value="{{ $platform->id }}"
                       {{ in_array($platform->id, $userPlatforms) ? 'checked' : '' }}>
                <label class="ml-2">{{ $platform->name }}</label>
            </div>
        @endforeach
    
        <button type="submit" class="btn-primary" style="width:fit-content; margin-top: 30px; padding: 16px 32px;">
            Save Changes
        </button>
    </form>
    
@else
    @foreach ($platforms as $platform)
        <div class="flex items-center mb-2">
            <input type="checkbox" disabled
                   {{ in_array($platform->id, $userPlatforms) ? 'checked' : '' }}>
            <label class="ml-2">{{ $platform->name }}</label>
        </div>
    @endforeach
@endif

</x-layout>
