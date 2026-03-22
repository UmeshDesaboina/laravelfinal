<div class="group bg-white dark:bg-gray-800 rounded-[2rem] overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-gray-700 relative">
    <!-- Badge -->
    <?php if($product->discount_price): ?>
        <span class="absolute top-4 left-4 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full z-10 shadow-lg shadow-red-500/30">
            <?php echo e(round((($product->price - $product->discount_price) / $product->price) * 100)); ?>% OFF
        </span>
    <?php endif; ?>

    <!-- Wishlist Toggle -->
    <button onclick="toggleWishlist(<?php echo e($product->id); ?>)" class="absolute top-4 right-4 p-3 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-full text-gray-400 hover:text-red-500 transition-all z-10 shadow-lg border border-white/20">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
    </button>

    <!-- Image -->
    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block relative aspect-[4/5] overflow-hidden bg-gray-100 dark:bg-gray-700">
        <?php if($product->images->count() > 0): ?>
            <img src="<?php echo e(asset('storage/' . $product->images->first()->image)); ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="<?php echo e($product->name); ?>">
        <?php else: ?>
            <div class="w-full h-full flex items-center justify-center">
                <span class="text-6xl font-bold text-gray-200 uppercase"><?php echo e(substr($product->name, 0, 1)); ?></span>
            </div>
        <?php endif; ?>
        <!-- Quick Add Overlay -->
        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6 backdrop-blur-[2px]">
            <button onclick="addToCart(<?php echo e($product->id); ?>)" class="w-full bg-white text-gray-900 py-4 rounded-2xl font-bold text-sm shadow-xl hover:bg-green-500 hover:text-white transition-all transform translate-y-4 group-hover:translate-y-0 duration-500">
                Quick Add to Cart
            </button>
        </div>
    </a>

    <!-- Info -->
    <div class="p-6">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2"><?php echo e($product->category->name); ?></p>
        <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="block text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-green-500 transition-colors"><?php echo e($product->name); ?></a>
        <div class="flex items-center justify-between mt-4">
            <div class="flex flex-col">
                <?php if($product->discount_price): ?>
                    <span class="text-xs text-gray-400 line-through">₹<?php echo e(number_format($product->price, 2)); ?></span>
                    <span class="text-xl font-black text-green-500 tracking-tight">₹<?php echo e(number_format($product->discount_price, 2)); ?></span>
                <?php else: ?>
                    <span class="text-xl font-black text-gray-900 dark:text-white tracking-tight">₹<?php echo e(number_format($product->price, 2)); ?></span>
                <?php endif; ?>
            </div>
            <!-- Ratings -->
            <div class="flex items-center gap-1 text-yellow-400">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                <span class="text-xs font-bold text-gray-600 dark:text-gray-400"><?php echo e($product->average_rating); ?></span>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/components/product-card.blade.php ENDPATH**/ ?>