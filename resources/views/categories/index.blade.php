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
    <div class="hero-background destinations-page"></div>

    {{-- Cards Section --}}
    <div class="cards">

        @forelse ($category->products as $product)
            <div class="card">
                    <div class="card-img">
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
                 <p class="overview">{{ $product->price }}</p>
                </a>
            </div>
        @empty
            <p style="text-align:center;">No products found.</p>
        @endforelse

    </div>

</div>
</x-app-layout>




