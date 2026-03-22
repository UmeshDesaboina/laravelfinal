<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav x-data="{ open: false, searchOpen: false, cartCount: 0 }" x-init="fetch('<?php echo e(route('cart.count')); ?>').then(r => r.json()).then(d => cartCount = d.count)" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20 items-center">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-green-500 tracking-tight">
                            FIGHT<span class="text-gray-900 dark:text-white">WISDOM</span>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('home') ? 'border-green-500' : 'border-transparent'); ?> text-sm font-medium leading-5 transition duration-150 ease-in-out">Home</a>
                        <a href="<?php echo e(route('shop')); ?>" class="inline-flex items-center px-1 pt-1 border-b-2 <?php echo e(request()->routeIs('shop') ? 'border-green-500' : 'border-transparent'); ?> text-sm font-medium leading-5 transition duration-150 ease-in-out">Shop</a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 transition duration-150 ease-in-out">New Arrivals</a>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-6">
                        <!-- Search -->
                        <div class="relative hidden md:block" x-data="{ query: '', results: [] }">
                            <input type="text" x-model="query" @input.debounce.300ms="fetch(`<?php echo e(url('api/search-suggestions')); ?>?q=${query}`).then(r => r.json()).then(d => results = d)" placeholder="Search products..." class="w-64 rounded-full bg-gray-100 dark:bg-gray-700 border-none focus:ring-2 focus:ring-green-500 text-sm py-2 px-4">
                            <div x-show="query.length > 2 && results.length > 0" class="absolute top-full mt-2 w-full bg-white dark:bg-gray-800 rounded-xl shadow-xl border dark:border-gray-700 p-2 z-50" x-cloak>
                                <template x-for="item in results" :key="item.id">
                                    <a :href="`<?php echo e(url('products')); ?>/${item.slug}`" class="flex items-center gap-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <img :src="item.image" class="w-10 h-10 rounded-lg object-cover">
                                        <div>
                                            <p class="text-sm font-medium" x-text="item.name"></p>
                                            <p class="text-xs text-gray-500" x-text="`₹${item.price}`"></p>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <?php if(auth()->guard()->check()): ?>
                            <div class="flex items-center gap-4">
                                <a href="<?php echo e(route('wishlist.index')); ?>" class="relative text-gray-600 dark:text-gray-300 hover:text-green-500 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </a>
                                <a href="<?php echo e(route('cart.index')); ?>" class="relative text-gray-600 dark:text-gray-300 hover:text-green-500 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span x-show="cartCount > 0" class="absolute -top-1 -right-1 bg-green-500 text-white text-[10px] font-bold px-1.5 rounded-full" x-text="cartCount"></span>
                                </a>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center gap-2">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo e(auth()->user()->name); ?>" class="w-8 h-8 rounded-full border-2 border-green-500" alt="">
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border dark:border-gray-700 py-2 z-50" x-cloak>
                                        <?php if(auth()->user()->isAdmin()): ?>
                                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Admin Panel</a>
                                        <?php endif; ?>
                                        <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Dashboard</a>
                                        <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">Profile</a>
                                        <a href="<?php echo e(route('orders.index')); ?>" class="block px-4 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-700">My Orders</a>
                                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-50 dark:hover:bg-gray-700">Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex items-center gap-4">
                                <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium hover:text-green-500 transition-colors">Login</a>
                                <a href="<?php echo e(route('register')); ?>" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg shadow-gray-200 dark:shadow-none">Join Now</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 pt-16 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                    <div class="col-span-1 md:col-span-1">
                        <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-green-500 tracking-tight mb-6 block">
                            FIGHT<span class="text-gray-900 dark:text-white">WISDOM</span>
                        </a>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            Experience the best premium e-commerce design with smooth animations and transitions. Built for performance and user experience.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6">Shop</h4>
                        <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                            <li><a href="<?php echo e(route('shop')); ?>" class="hover:text-green-500 transition-colors">All Products</a></li>
                            <li><a href="#" class="hover:text-green-500 transition-colors">Featured</a></li>
                            <li><a href="#" class="hover:text-green-500 transition-colors">New Arrivals</a></li>
                            <li><a href="#" class="hover:text-green-500 transition-colors">Best Sellers</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6">Support</h4>
                        <ul class="space-y-4 text-sm text-gray-500 dark:text-gray-400">
                            <li><a href="#" class="hover:text-green-500 transition-colors">Order Tracking</a></li>
                            <li><a href="#" class="hover:text-green-500 transition-colors">Returns & Refunds</a></li>
                            <li><a href="#" class="hover:text-green-500 transition-colors">Shipping Policy</a></li>
                            <li><a href="#" class="hover:text-green-500 transition-colors">Contact Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-bold mb-6">Newsletter</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Subscribe to get latest updates and offers.</p>
                        <div class="flex">
                            <input type="email" placeholder="Email address" class="w-full rounded-l-lg border-gray-200 dark:border-gray-700 dark:bg-gray-700 focus:ring-green-500 text-sm">
                            <button class="bg-green-500 text-white px-4 rounded-r-lg hover:bg-green-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 dark:border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                    <p>© 2026 FIGHTWISDOM. All rights reserved.</p>
                    <div class="flex gap-6">
                        <a href="#" class="hover:text-green-500 transition-colors">Privacy Policy</a>
                        <a href="#" class="hover:text-green-500 transition-colors">Terms of Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\umesh\fightwisdoml234\resources\views/layouts/app.blade.php ENDPATH**/ ?>