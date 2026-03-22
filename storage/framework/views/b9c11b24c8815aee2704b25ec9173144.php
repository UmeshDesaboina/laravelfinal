<?php $__env->startSection('content'); ?>
<div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 sticky top-28 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h2 class="text-xl font-bold mb-8">Filters</h2>
                    
                    <!-- Categories -->
                    <div class="mb-10">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Category</h3>
                        <div class="space-y-3">
                            <label class="flex items-center group cursor-pointer">
                                <input type="radio" name="category" value="" checked class="hidden" onchange="filterProducts()">
                                <span class="text-sm font-medium group-hover:text-green-500 transition-colors">All Categories</span>
                            </label>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" name="category" value="<?php echo e($category->slug); ?>" <?php echo e(request('category') == $category->slug ? 'checked' : ''); ?> class="hidden" onchange="filterProducts()">
                                    <span class="text-sm font-medium group-hover:text-green-500 transition-colors <?php echo e(request('category') == $category->slug ? 'text-green-500' : ''); ?>"><?php echo e($category->name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-10">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Price Range</h3>
                        <div class="space-y-4">
                            <input type="range" min="0" max="10000" step="100" class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-green-500" id="priceRange" oninput="document.getElementById('priceVal').innerText = this.value" onchange="filterProducts()">
                            <div class="flex justify-between text-xs font-bold">
                                <span>₹0</span>
                                <span id="priceVal">₹5000</span>
                                <span>₹10000+</span>
                            </div>
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="mb-10">
                        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Size</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = ['S', 'M', 'L', 'XL', 'XXL']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button onclick="toggleSize('<?php echo e($size); ?>')" class="size-btn w-10 h-10 rounded-xl border border-gray-200 dark:border-gray-700 flex items-center justify-center text-xs font-bold hover:border-green-500 hover:text-green-500 transition-all" data-size="<?php echo e($size); ?>"><?php echo e($size); ?></button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Product Grid Area -->
            <div class="flex-1">
                <!-- Toolbar -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-white dark:bg-gray-800 p-4 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <p class="text-sm text-gray-500 font-medium ml-4">Showing <span id="product-count"><?php echo e($products->total()); ?></span> products</p>
                    <div class="flex items-center gap-4 mr-4">
                        <span class="text-xs font-black uppercase tracking-widest text-gray-400">Sort by:</span>
                        <select onchange="filterProducts()" id="sortSelect" class="bg-transparent border-none focus:ring-0 text-sm font-bold cursor-pointer">
                            <option value="newest">Newest First</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="best_seller">Best Seller</option>
                        </select>
                    </div>
                </div>

                <!-- Grid -->
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php echo $__env->make('shop.product-grid', ['products' => $products], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                <!-- Pagination -->
                <div id="pagination-links" class="mt-16">
                    <?php echo e($products->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let selectedSize = '';

    function toggleSize(size) {
        if (selectedSize === size) {
            selectedSize = '';
        } else {
            selectedSize = size;
        }
        
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('bg-green-500', 'text-white', 'border-green-500');
            if (btn.dataset.size === selectedSize) {
                btn.classList.add('bg-green-500', 'text-white', 'border-green-500');
            }
        });
        
        filterProducts();
    }

    function filterProducts(page = 1) {
        const category = document.querySelector('input[name="category"]:checked')?.value || '';
        const price = document.getElementById('priceRange').value;
        const sort = document.getElementById('sortSelect').value;
        
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        url.searchParams.set('category', category);
        url.searchParams.set('max_price', price);
        url.searchParams.set('size', selectedSize);
        url.searchParams.set('sort', sort);
        
        window.history.pushState({}, '', url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('product-grid').innerHTML = data.html;
            document.getElementById('pagination-links').innerHTML = data.pagination;
            // Scroll to top of grid
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Handle pagination click
    document.addEventListener('click', function(e) {
        if (e.target.closest('#pagination-links a')) {
            e.preventDefault();
            const url = new URL(e.target.closest('a').href);
            const page = url.searchParams.get('page');
            filterProducts(page);
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml234\resources\views/shop/index.blade.php ENDPATH**/ ?>