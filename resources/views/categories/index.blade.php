<x-app-layout>
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/destinations.css') }}">
@endpush

<div class="main-wrapper">
         @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif


    <!-- Hero Background -->
    <div class="hero-background"></div>
    {{-- Search Form --}}
    <form class="search-form" method="GET" action="">
        <h1>Search Your Favorite Instrument</h1>

        <div class="search-container">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                 viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>

            <input type="search" id="default-search" name="search"
                   class="search-input" placeholder="Search destinations..." required>

            <button type="submit" class="search-button">Search</button>
        </div>
    </form>

    {{-- Cards Section --}}
    <div class="cards">

        @forelse ($category->products as $product)
        @php
    $isFav = auth()->check() && auth()->user()->favorites->contains($product->id);
@endphp
            <div class="card">
                    <div class="card-img">
                        {{-- Add heart button to add to favourites--}}
                        <button
                        class="fav-btn fav-toggle"
                        data-id="{{ $product->id }}"
                        style="position:absolute; top:10px; right:10px; z-index:10; background:none; border:none; cursor:pointer;"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="heart-icon h-8 w-8 {{ $isFav ? 'text-red-500' : 'text-gray-400' }}"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd"/>
                        </svg>
                    </button>
                    {{-- image --}}
                    <a href="">
                        <img src="{{asset('storage/' . $product->image)}}"
                             alt="Product Image">
                    </a>
                </div>
                <a href="">
                    <h5 class="destination-title">
                        {{ $product->name }}
                    </h5>
                <p class="overview">{{ Str::limit($product->description),80 }}</p>
                 <p class="overview">{{ $product->price }}$</p>

                </a>
                <div class="manage-btn flex items-center gap-3 mt-3 mb-3 px-4">
                    <a href="">
                        <button
                            class="px-4 py-2 rounded-xl text-white bg-blue-600 hover:bg-blue-700 transition duration-200 text-sm shadow-sm">
                            Buy Product
                        </button>
                    </a>
                </div>
            </div>
        @empty
            <p style="text-align:center;">No products found.</p>
        @endforelse

    </div>

</div>
</x-app-layout>

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
                    icon.classList.remove('text-red-500');
                    icon.classList.add('text-gray-400');
                }

            })
            .catch(error => console.error(error));
        });

    });
    </script>
