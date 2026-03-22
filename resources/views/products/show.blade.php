@extends('layouts.app')

@section('content')
<div class="py-24 bg-white dark:bg-gray-800" x-data="{ activeImage: '{{ $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://via.placeholder.com/600' }}', selectedSize: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Image Gallery -->
            <div class="space-y-6">
                <div class="aspect-square rounded-[3rem] overflow-hidden bg-gray-100 dark:bg-gray-700 shadow-2xl border-8 border-white dark:border-gray-800 relative group">
                    <img :src="activeImage" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110" id="mainImage">
                </div>
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <button @click="activeImage = '{{ asset('storage/' . $image->image) }}'" 
                            class="aspect-square rounded-2xl overflow-hidden border-2 transition-all"
                            :class="activeImage === '{{ asset('storage/' . $image->image) }}' ? 'border-green-500 scale-95 shadow-lg' : 'border-transparent opacity-60 hover:opacity-100'">
                            <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col">
                <div class="mb-8">
                    <p class="text-sm font-black uppercase tracking-[0.2em] text-green-500 mb-4">{{ $product->category->name }}</p>
                    <h1 class="text-4xl md:text-5xl font-black text-gray-900 dark:text-white mb-6 leading-tight">{{ $product->name }}</h1>
                    <div class="flex items-center gap-6 mb-8">
                        <div class="flex flex-col">
                            @if($product->discount_price)
                                <span class="text-lg text-gray-400 line-through">₹{{ number_format($product->price, 2) }}</span>
                                <span class="text-4xl font-black text-green-500">₹{{ number_format($product->discount_price, 2) }}</span>
                            @else
                                <span class="text-4xl font-black text-gray-900 dark:text-white">₹{{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <div class="h-12 w-px bg-gray-100 dark:bg-gray-700"></div>
                        <div class="flex items-center gap-2">
                            <div class="flex text-yellow-400">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $product->average_rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-gray-500">({{ $product->reviews->count() }} Reviews)</span>
                        </div>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed mb-10 text-lg">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Variants -->
                @if($product->variants && count($product->variants) > 0)
                    <div class="mb-10">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Select Size</h3>
                        <div class="flex flex-wrap gap-4">
                            @foreach($product->variants as $size)
                                <button @click="selectedSize = '{{ $size }}'" 
                                    class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center text-sm font-bold transition-all"
                                    :class="selectedSize === '{{ $size }}' ? 'border-green-500 bg-green-500 text-white shadow-xl shadow-green-500/30' : 'border-gray-100 dark:border-gray-700 hover:border-green-500'">
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex gap-4 mt-auto">
                    <button onclick="addToCart({{ $product->id }})" class="flex-1 bg-gray-900 dark:bg-white text-white dark:text-gray-900 h-16 rounded-2xl font-black text-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-2xl shadow-gray-200 dark:shadow-none transform active:scale-95">
                        Add to Cart
                    </button>
                    <button onclick="toggleWishlist({{ $product->id }})" class="w-16 h-16 rounded-2xl border-2 border-gray-100 dark:border-gray-700 flex items-center justify-center text-gray-400 hover:text-red-500 transition-all transform active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                </div>

                <div class="mt-8 flex items-center gap-8 text-sm font-bold text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Free Delivery
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Easy Returns
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-32 border-t dark:border-gray-700 pt-24">
            <div class="flex flex-col md:flex-row justify-between items-start gap-12">
                <div class="w-full md:w-1/3">
                    <h2 class="text-4xl font-black mb-6">Reviews</h2>
                    <div class="flex items-center gap-4 mb-8">
                        <span class="text-6xl font-black text-gray-900 dark:text-white">{{ number_format($product->average_rating, 1) }}</span>
                        <div>
                            <div class="flex text-yellow-400">
                                @for($i=1; $i<=5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $product->average_rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Based on {{ $product->reviews->count() }} ratings</p>
                        </div>
                    </div>
                    @auth
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-8 rounded-[2rem]">
                            <h4 class="font-bold mb-6">Write a Review</h4>
                            <form action="{{ route('reviews.store', $product) }}" method="POST">
                                @csrf
                                <div class="mb-6" x-data="{ rating: 0 }">
                                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Your Rating</label>
                                    <div class="flex gap-2">
                                        <template x-for="i in 5">
                                            <button type="button" @click="rating = i" class="text-3xl focus:outline-none transition-transform active:scale-90" :class="i <= rating ? 'text-yellow-400' : 'text-gray-300'">
                                                ★
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="rating" x-model="rating" required>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-3">Your Comment</label>
                                    <textarea name="comment" rows="4" class="w-full rounded-2xl border-gray-100 dark:border-gray-700 dark:bg-gray-800 focus:ring-green-500 text-sm" placeholder="What did you think of this product?"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-green-500 text-white py-4 rounded-2xl font-bold hover:bg-green-600 transition-all shadow-xl shadow-green-500/20">Submit Review</button>
                            </form>
                        </div>
                    @endauth
                </div>

                <div class="flex-1 space-y-8">
                    @foreach($product->reviews->where('is_approved', true) as $review)
                        <div class="flex gap-6 p-8 rounded-[2rem] border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all">
                            <img src="https://ui-avatars.com/api/?name={{ $review->user->name }}" class="w-12 h-12 rounded-2xl" alt="">
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <h5 class="font-bold">{{ $review->user->name }}</h5>
                                    <span class="text-xs font-bold text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex text-yellow-400 mb-4">
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <p class="text-gray-500 dark:text-gray-400 leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addToCart(productId) {
        const size = document.querySelector('[x-data]').__x.$data.selectedSize;
        if (!size && document.querySelector('.size-btn')) {
            Swal.fire('Error', 'Please select a size first', 'error');
            return;
        }

        fetch(`{{ url('cart/add') }}/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ variant: size, quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Added to cart!',
                    showConfirmButton: false,
                    timer: 1500
                });
                // Update cart count
                window.location.reload(); // Simple way to update count for now
            }
        });
    }

    function toggleWishlist(productId) {
        fetch(`{{ url('wishlist/toggle') }}/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>
@endpush
