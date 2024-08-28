<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div x-data="mediaPreview('{{ $post->media ? asset('storage/' . $post->media) : '' }}')" class="container mx-auto px-4 py-6">
        <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Title') }}:</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                />
                @error('title')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Content') }}:</label>
                <textarea
                    id="content"
                    name="content"
                    required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Select Category') }}:</label>
                <select
                    id="category"
                    name="category"
                    required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                    @foreach (\App\Enums\CategoryEnum::cases() as $category)
                        <option value="{{ $category->value }}"
                            {{ old('category', $post->category) == $category->value ? 'selected' : '' }}>
                            {{ $category->getLabel() }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="media" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Media') }}:</label>
                <input
                    type="file"
                    id="media"
                    name="media"
                    accept="image/*,video/*,audio/*"
                    @change="previewMedia($event)"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                />
                @error('media')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror

                <div id="media-preview" class="mt-4">
                </div>

                @if ($post->media)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $post->media) }}" alt="Post Media" class="max-w-full h-auto">
                    </div>
                @endif
            </div>

            <div class="flex items-center justify-between mt-4">
                <a
                    href="{{ route('posts.index') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    {{ __('Back') }}
                </a>

                <button
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                >
                    {{ __('Update Post') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function mediaPreview(initialMediaUrl) {
            return {
                media: initialMediaUrl,
                previewMedia(event) {
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
            };
        }
    </script>
</x-app-layout>
