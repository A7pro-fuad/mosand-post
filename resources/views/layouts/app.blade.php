<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

 <style>
      
        .media-preview img, .media-preview video, .media-preview audio {
            max-width: 100%;
            max-height: 300px;
            display: block;
            margin-top: 10px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>

         <script>
        function previewMedia(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('media-preview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const mime = file.type;
                    if (mime.startsWith('image/')) {
                        preview.innerHTML = `<img src="${e.target.result}" alt="Media Preview" style="max-width: 100%; max-height: 200px;">`;
                    } else if (mime.startsWith('video/')) {
                        preview.innerHTML = `<video controls src="${e.target.result}" style="max-width: 100%;"></video>`;
                    } else if (mime.startsWith('audio/')) {
                        preview.innerHTML = `<audio controls src="${e.target.result}"></audio>`;
                    } else {
                        preview.innerHTML = `<p>Unsupported file type.</p>`;
                    }
                };

                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        }
    </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
