<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-3xl p-8 mb-8 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-black mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                        <p class="text-green-100">Manage your orders, profile, and preferences</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('shop') }}" class="px-6 py-3 bg-white text-green-600 rounded-full font-bold hover:bg-green-50 transition-all shadow-lg">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ auth()->user()->orders->count() }}</p>
                    <p class="text-sm text-gray-500 font-medium">Total Orders</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ auth()->user()->orders->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}</p>
                    <p class="text-sm text-gray-500 font-medium">Active Orders</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ auth()->user()->orders->where('status', 'delivered')->count() }}</p>
                    <p class="text-sm text-gray-500 font-medium">Completed</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-black text-gray-900 dark:text-white">{{ auth()->user()->wishlists->count() ?? 0 }}</p>
                    <p class="text-sm text-gray-500 font-medium">Wishlist Items</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-black text-gray-900 dark:text-white">Recent Orders</h3>
                            <a href="{{ route('orders.index') }}" class="text-green-500 font-bold hover:text-green-600 text-sm">View All →</a>
                        </div>
                        
                        @php
                            $recentOrders = auth()->user()->orders()->latest()->take(3)->get();
                        @endphp
                        
                        @if($recentOrders->isEmpty())
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <p class="text-gray-500 mb-4">No orders yet</p>
                                <a href="{{ route('shop') }}" class="inline-block bg-green-500 text-white px-6 py-3 rounded-full font-bold hover:bg-green-600 transition-all">Start Shopping</a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($recentOrders as $order)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-gray-200 dark:bg-gray-600 flex items-center justify-center font-black text-xs text-gray-500">
                                                #{{ substr($order->order_number, 0, 8) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</p>
                                                <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-black text-gray-900 dark:text-white">₹{{ number_format($order->total, 2) }}</p>
                                            <span class="inline-block px-2 py-1 text-[10px] font-bold uppercase rounded-full 
                                                @if($order->status === 'delivered') bg-green-100 text-green-600
                                                @elseif($order->status === 'cancelled') bg-red-100 text-red-600
                                                @elseif($order->status === 'pending') bg-yellow-100 text-yellow-600
                                                @else bg-blue-100 text-blue-600 @endif">
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                        <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-green-500 transition-colors">
                                            View →
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">Quick Links</h3>
                        <div class="space-y-3">
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-700 dark:text-gray-200 group-hover:text-green-500 transition-colors">My Orders</span>
                            </a>
                            <a href="{{ route('wishlist.index') }}" class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-700 dark:text-gray-200 group-hover:text-green-500 transition-colors">Wishlist</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-700 dark:text-gray-200 group-hover:text-green-500 transition-colors">Edit Profile</span>
                            </a>
                            <a href="{{ route('addresses.index') }}" class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group">
                                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="font-bold text-gray-700 dark:text-gray-200 group-hover:text-green-500 transition-colors">Addresses</span>
                            </a>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6">Account Info</h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=10b981&color=fff" class="w-12 h-12 rounded-full border-2 border-green-500" alt="">
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                                <p class="text-sm text-gray-500 mb-2">Member since</p>
                                <p class="font-bold text-gray-900 dark:text-white">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                            </div>
                            @if(auth()->user()->addresses->count() > 0)
                            <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                                <p class="text-sm text-gray-500 mb-2">Default Address</p>
                                <p class="font-bold text-gray-900 dark:text-white text-sm">{{ auth()->user()->addresses->where('is_default', true)->first()->full_name ?? 'Not set' }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->addresses->where('is_default', true)->first()->city ?? '' }}, {{ auth()->user()->addresses->where('is_default', true)->first()->state ?? '' }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
