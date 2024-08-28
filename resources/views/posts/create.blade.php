<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 rounded-md p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input
                id="title"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                type="text"
                name="title"
                :value="old('title')"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="content" :value="__('Content')" />
            <textarea
                id="content"
                name="content"
                rows="4"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                required
            >{{ old('content') }}</textarea>
            <x-input-error :messages="$errors->get('content')" class="mt-2" />
        </div>


        <div>
            <x-input-label for="category" :value="__('Select Category')" />
            <select
                id="category"
                name="category"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                required
            >
                <option value="" selected disabled hidden>{{ __('Select a category') }}</option>
                @foreach (\App\Enums\CategoryEnum::cases() as $category)

                    <option value="{{ $category->value }}">{{ $category->getLabel() }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>


        <div>
            <x-input-label for="media" :value="__('Media')" />
            <input
                type="file"
                id="media"
                name="media"
                accept="image/*,video/*,audio/*"
                onchange="previewMedia(event)"
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <x-input-error :messages="$errors->get('media')" class="mt-2" />
        </div>

        <div id="media-preview" class="mt-4"></div>

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

        <div class="flex items-center justify-between mt-4">
            <a
                class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('posts.index') }}"
            >
                {{ __('Back') }}
            </a>

            <x-primary-button>
                {{ __('Create') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>

<script>
    function previewMedia(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('media-preview');
        preview.innerHTML = '';

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                let mediaElement;
                if (file.type.startsWith('image/')) {
                    mediaElement = document.createElement('img');
                    mediaElement.src = e.target.result;
                    mediaElement.className = 'max-w-full mt-2';
                } else if (file.type.startsWith('video/')) {
                    mediaElement = document.createElement('video');
                    mediaElement.src = e.target.result;
                    mediaElement.controls = true;
                    mediaElement.className = 'max-w-full mt-2';
                } else if (file.type.startsWith('audio/')) {
                    mediaElement = document.createElement('audio');
                    mediaElement.src = e.target.result;
                    mediaElement.controls = true;
                    mediaElement.className = 'mt-2';
                } else {
                    mediaElement = document.createElement('p');
                    mediaElement.textContent = 'Unsupported file type.';
                }
                preview.appendChild(mediaElement);
            };
            reader.readAsDataURL(file);
        }
    }
</script>
