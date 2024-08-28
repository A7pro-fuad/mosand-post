<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Post Details') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-900">{{ $post->title }}</h3>
            <p class="text-gray-700 mt-2">{{ $post->content }}</p>
        </div>

        <div class="mb-4">
            <span class="font-semibold text-gray-600">Category:</span>
            <span class="text-gray-900">{{ \App\Enums\CategoryEnum::from($post->category)->getLabel() }}</span>
        </div>

        <div class="mb-4">
            <span class="font-semibold text-gray-600">Created At:</span>
            <span class="text-gray-900">{{ $post->created_at->format('F j, Y, g:i a') }}</span>
        </div>

        <div class="mb-4">
            <span class="font-semibold text-gray-600">Updated At:</span>
            <span class="text-gray-900">{{ $post->updated_at->format('F j, Y, g:i a') }}</span>
        </div>

        @if ($post->media)
            <div class="mt-4">
                <img src="{{ asset('storage/' . $post->media) }}" alt="Post Media" class="max-w-full h-auto">
            </div>
        @endif

        <div class="flex items-center mt-6">
            <a href="{{ route('posts.edit', $post->id) }}"
                class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-4">
                {{ __('Edit') }}
            </a>

            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this post?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Delete') }}
                </button>
            </form>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('posts.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
            {{ __('Back to Posts List') }}
        </a>
    </div>
</x-app-layout>
