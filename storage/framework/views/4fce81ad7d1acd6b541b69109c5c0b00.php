<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="relative bg-gray-900 h-[600px] flex items-center overflow-hidden">
    <div class="absolute inset-0 opacity-40">
        <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="">
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-2xl text-white">
            <h1 class="text-5xl md:text-7xl font-extrabold mb-6 leading-tight">Elevate Your Lifestyle.</h1>
            <p class="text-lg md:text-xl mb-10 text-gray-300">Discover premium products curated just for you. Quality meets style in every collection.</p>
            <div class="flex gap-4">
                <a href="<?php echo e(route('shop')); ?>" class="bg-green-500 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-green-600 transition-all transform hover:scale-105 shadow-xl shadow-green-500/20">Shop Now</a>
                <a href="#" class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-8 py-4 rounded-full font-bold text-lg hover:bg-white/20 transition-all">New Arrivals</a>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-24 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold mb-2">Shop by Category</h2>
                <p class="text-gray-500 dark:text-gray-400">Explore our diverse collections</p>
            </div>
            <a href="<?php echo e(route('shop')); ?>" class="text-green-500 font-bold hover:text-green-600">View All Categories →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('shop', ['category' => $category->slug])); ?>" class="group text-center">
                    <div class="relative aspect-square rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-700 mb-4 shadow-sm group-hover:shadow-xl transition-all">
                        <?php if($category->image): ?>
                            <img src="<?php echo e(asset('storage/' . $category->image)); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500" alt="<?php echo e($category->name); ?>">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center">
                                <span class="text-4xl font-bold text-gray-300"><?php echo e(substr($category->name, 0, 1)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h3 class="font-bold group-hover:text-green-500 transition-colors"><?php echo e($category->name); ?></h3>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-24 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-bold mb-2">Featured Products</h2>
                <p class="text-gray-500 dark:text-gray-400">Handpicked items you'll love</p>
            </div>
            <div class="flex gap-2">
                <!-- Navigation buttons could go here -->
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('components.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Newsletter Banner -->
<section class="py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-900 rounded-[2rem] overflow-hidden relative">
            <div class="absolute inset-0 opacity-20">
                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="w-full h-full object-cover" alt="">
            </div>
            <div class="relative z-10 px-8 py-16 md:p-20 text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Join the Community</h2>
                <p class="text-gray-400 text-lg mb-10 max-w-xl mx-auto">Subscribe to our newsletter and get 10% off your first order plus early access to new drops.</p>
                <form class="max-w-md mx-auto flex gap-4">
                    <input type="email" placeholder="Enter your email" class="flex-1 rounded-full bg-white/10 border-white/20 text-white placeholder:text-gray-500 focus:ring-green-500 px-6 py-4 backdrop-blur-md">
                    <button class="bg-white text-gray-900 px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition-all shadow-xl">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/home.blade.php ENDPATH**/ ?>