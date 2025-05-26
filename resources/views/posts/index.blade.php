<x-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Your Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn-primary" style="width: fit-content; padding: 8px 16px;">
            +
        </a>
    </div>

    @if($posts->isEmpty())
        <p>No posts found.</p>
    @else
        <div class="grid gap-4">
            @foreach($posts as $post)
    <div class="border p-4 rounded shadow-sm bg-white mb-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold">{{ $post->title }}</h2>

            <div class="flex items-center space-x-3">
                <span class="text-sm px-2 py-1 rounded bg-gray-200">{{ ucfirst($post->status) }}</span>
                <a href="{{ route('posts.edit', $post) }}"
                class="text-sm text-blue-500 hover:underline cursor-pointer">
                    Edit
                </a>
                
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-500 hover:underline cursor-pointer">delete</button>
                    </form>
            </div>
        </div>

        @if($post->scheduled_time)
            <p class="text-gray-600 text-sm mt-1">
                Scheduled: {{ $post->scheduled_time->format('Y-m-d H:i') }}
            </p>
        @endif

        <div class="mt-2 text-sm text-gray-700">
            Platforms:
            @foreach($post->platforms as $platform)
                <span class="inline-block bg-gray-100 border rounded px-2 py-1 mr-2">{{ $platform->name }}</span>
            @endforeach
        </div>
    </div>
@endforeach

        </div>
    @endif
</x-layout>
