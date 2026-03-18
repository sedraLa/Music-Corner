<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Favorites') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Favorite Products Section -->
                    <div class="mb-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6 border-l-4 border-blue-500 pl-4">
                            Favorite Products
                        </h3>

                        @if($favorites->isNotEmpty())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                @foreach ($favorites as $favorite)
                                    <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden relative">

                                        <!-- Heart Button (Toggle Favorite) -->
                                        <button class="fav-btn fav-toggle"
                                                data-id="{{ $favorite->id }}"
                                                style="position:absolute; top:10px; right:10px; background:none; border:none; cursor:pointer;">
                                            <svg class="heart-icon h-8 w-8 text-red-500"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                            </svg>
                                        </button>

                                        <!-- Product Image -->
                                        <a href="">
                                            <img src="{{ asset('storage/' . $favorite->image) }}"
                                                 alt="{{ $favorite->name }}"
                                                 class="w-full h-48 object-cover">
                                        </a>

                                        <div class="p-4">
                                            <h4 class="text-lg font-semibold text-gray-900">{{ $favorite->name }}</h4>
                                            <p class="text-sm text-gray-600 mt-1">{{ $favorite->price }}$</p>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">You haven't added any favorite products yet.</p>
                        @endif

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- AJAX Script for toggle favorite -->
    <script>
        document.querySelectorAll('.fav-toggle').forEach(button => {
            button.addEventListener('click', function () {

                const productId = this.dataset.id;
                const icon = this.querySelector('.heart-icon');

                fetch(`/favorites/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === 'added') {
                        icon.classList.remove('text-gray-400');
                        icon.classList.add('text-red-500');
                    } else {
                        // إزالة الكارد من الصفحة إذا تم إزالة الفافوري
                        button.closest('div.relative').remove();
                    }

                })
                .catch(error => console.error(error));

            });
        });
    </script>

</x-app-layout>