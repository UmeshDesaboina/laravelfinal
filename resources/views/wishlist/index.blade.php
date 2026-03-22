@extends('layouts.app')

@section('content')
<div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black mb-12">My Wishlist</h1>

        @if($wishlistItems->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-20 text-center shadow-sm">
                <svg class="w-20 h-20 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <h2 class="text-2xl font-bold mb-4">Your wishlist is empty</h2>
                <p class="text-gray-500 mb-8">Save items you love to your wishlist and they'll appear here.</p>
                <a href="{{ route('shop') }}" class="inline-block bg-green-500 text-white px-8 py-4 rounded-full font-bold hover:bg-green-600 transition-all shadow-xl">Explore Products</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($wishlistItems as $item)
                    @include('components.product-card', ['product' => $item->product])
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
