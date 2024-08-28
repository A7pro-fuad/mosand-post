<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Posts List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Posts List</h3>
                        <div class="flex space-x-4">
                            <input type="text" id="search" placeholder="Search by title or category..."
                                class="border rounded-lg px-4 py-2">
                        </div>
                    </div>
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">Post List</h3>
                            <a href="{{ route('posts.create') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md shadow">
                                {{ __('Create Post') }}
                            </a>
                        </div>

                    </div>

                    <div class="overflow-x-auto">
                        <x-posts-table :posts="$posts" />
                    </div>

                    <div id="pagination" class="mt-4 flex justify-center">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const apiUrl = '{{ route('posts.fetch') }}';
        let currentPage = 1;

        document.addEventListener('DOMContentLoaded', () => {
            fetchPosts();
            document.getElementById('search').addEventListener('input', () => fetchPosts());
        });

        function fetchPosts(page = 1) {
            currentPage = page;
            const searchTerm = document.getElementById('search').value;

            fetch(`${apiUrl}?page=${page}&search=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    renderUsers(data.data);
                    renderPagination(data);
                })
                .catch(error => console.error('Error fetching users:', error));
        }

        function renderUsers(posts) {
            const tbody = document.getElementById('posts-tbody');

            tbody.innerHTML = posts.map(post => `
                <tr>
                    <td class="px-6 py-4 text-sm text-gray-900">${post.id}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${post.title}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${post.content}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">${post.category}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${new Date(post.created_at).toLocaleString()}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${new Date(post.updated_at).toLocaleString()}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <a href="posts/${post.id}/edit" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        <a href="posts/${post.id}" class="text-indigo-600 hover:text-indigo-900">View</a>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                <button onclick="deletePost(${post.id})" class="text-red-600 hover:text-red-900">Delete</button>
            </td>
                </tr>
            `).join('');
        }

        function deletePost(postId) {
            if (confirm('Are you sure you want to delete this post?')) {
                fetch(`/posts/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {

                            document.querySelector(`#posts-tbody tr[data-id="${postId}"]`).remove();
                            alert('Post deleted successfully!');
                        } else {
                            alert('Failed to delete the post.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the post.');
                    });
            }
        }

        function renderPagination(data) {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            const pageCount = data.last_page;

            for (let i = 1; i <= pageCount; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.className =
                    `mx-1 px-4 py-2 border rounded-lg ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-white text-blue-500'}`;
                button.onclick = () => fetchPosts(i);
                pagination.appendChild(button);
            }
        }
    </script>
</x-app-layout>
