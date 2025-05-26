@props([
    'post' => null,
    'platforms' => [],
])
@if($errors->any())
<div class="text-red-500">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ $post ? route('posts.update', $post) : route('posts.store') }}" 
      method="POST" 
      class="space-y-4 max-w-lg flex flex-col">

    @csrf
    @if($post)
        @method('PUT')
    @endif

    <input type="text" name="title" placeholder="Title" 
           value="{{ old('title', $post->title ?? '') }}" 
           class="w-full border rounded px-3 py-2" required>

    <textarea name="content" placeholder="Content" rows="4" 
              class="w-full border rounded px-3 py-2" required>{{ old('content', $post->content ?? '') }}</textarea>

    <input type="url" name="image_url" placeholder="Image URL (optional)" 
           value="{{ old('image_url', $post->image_url ?? '') }}" 
           class="w-full border rounded px-3 py-2">

    <label>
        Scheduled Time:
        <input type="datetime-local" name="scheduled_time" 
        value="{{ old('scheduled_time', isset($post) ? $post->scheduled_time?->format('Y-m-d\TH:i') : '') }}"

               class="border rounded px-3 py-2" >
    </label>

    <label>
        Status:
        <select name="status" required class="border rounded px-3 py-2">
            @foreach(['draft', 'scheduled', 'published'] as $status)
                <option value="{{ $status }}" 
                    {{ old('status', $post->status ?? '') === $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </label>

    <fieldset>
        <legend class="font-semibold mb-2">Platforms</legend>
        @foreach($platforms as $platform)
            <label class="inline-flex items-center mr-4 mb-2">
                <input type="checkbox" name="platforms[]" value="{{ $platform->id }}"
                    {{ (is_array(old('platforms')) && in_array($platform->id, old('platforms')))
                        || (isset($post) && $post->platforms->contains($platform->id)) ? 'checked' : '' }}>
                <span class="ml-2">{{ $platform->name }}</span>
            </label>
        @endforeach
    </fieldset>
    
    

    <button type="submit" 
            class="btn-primary">
        {{ $post ? 'Update Post' : 'Create Post' }}
    </button>
</form>
