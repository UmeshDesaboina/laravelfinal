@extends('layouts.app')

@section('content')
<div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black mb-12">Your Cart</h1>

        @if($cartItems->isEmpty())
            <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-20 text-center shadow-sm">
                <svg class="w-20 h-20 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <h2 class="text-2xl font-bold mb-4">Your cart is empty</h2>
                <p class="text-gray-500 mb-8">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('shop') }}" class="inline-block bg-green-500 text-white px-8 py-4 rounded-full font-bold hover:bg-green-600 transition-all shadow-xl shadow-green-500/20">Start Shopping</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Items List -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cartItems as $item)
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-6 relative group">
                            <div class="w-24 h-32 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-700 flex-shrink-0">
                                <img src="{{ $item->product->images->first() ? asset('storage/' . $item->product->images->first()->image) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">{{ $item->product->category->name }}</p>
                                <h3 class="font-bold text-lg mb-1">{{ $item->product->name }}</h3>
                                @if($item->variant)
                                    <p class="text-xs text-gray-500 mb-4 font-bold">Size: {{ $item->variant }}</p>
                                @endif
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl px-4 py-2">
                                        <button onclick="updateQty({{ $item->id }}, {{ $item->quantity - 1 }})" class="text-gray-400 hover:text-green-500 font-black text-lg">-</button>
                                        <span class="font-black text-sm w-8 text-center">{{ $item->quantity }}</span>
                                        <button onclick="updateQty({{ $item->id }}, {{ $item->quantity + 1 }})" class="text-gray-400 hover:text-green-500 font-black text-lg">+</button>
                                    </div>
                                    <div class="text-right">
                                        @php $price = $item->product->discount_price ?? $item->product->price; @endphp
                                        <p class="font-black text-lg text-green-500">₹{{ number_format($price * $item->quantity, 2) }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold">₹{{ number_format($price, 2) }} / unit</p>
                                    </div>
                                </div>
                            </div>
                            <button onclick="removeItem({{ $item->id }})" class="absolute top-6 right-6 text-gray-300 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-10 shadow-sm border border-gray-100 dark:border-gray-700 sticky top-28">
                        <h2 class="text-2xl font-black mb-8">Summary</h2>
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm font-bold text-gray-500">
                                <span>Subtotal</span>
                                <span class="text-gray-900 dark:text-white">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold text-gray-500">
                                <span>Delivery</span>
                                <span class="text-gray-900 dark:text-white">₹{{ number_format($deliveryCharge, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between">
                                <span class="text-lg font-black">Total</span>
                                <span class="text-2xl font-black text-green-500">₹{{ number_format($subtotal + $deliveryCharge, 2) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout') }}" class="block w-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 py-5 rounded-2xl font-black text-center text-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-2xl shadow-gray-200 dark:shadow-none">Checkout Now</a>
                        <p class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-6">Taxes and discounts calculated at checkout</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateQty(id, qty) {
        if (qty < 1) return;
        fetch(`{{ url('cart/update') }}/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: qty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }

    function removeItem(id) {
        if (!confirm('Remove this item?')) return;
        fetch(`{{ url('cart/remove') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        });
    }
</script>
@endpush
