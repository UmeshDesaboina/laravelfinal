<?php $__env->startSection('content'); ?>
<div class="py-24 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black mb-12">My Orders</h1>

        <?php if($orders->isEmpty()): ?>
            <div class="bg-white dark:bg-gray-800 rounded-[3rem] p-20 text-center shadow-sm">
                <svg class="w-20 h-20 mx-auto text-gray-200 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <h2 class="text-2xl font-bold mb-4">No orders yet</h2>
                <p class="text-gray-500 mb-8">You haven't placed any orders yet.</p>
                <a href="<?php echo e(route('shop')); ?>" class="inline-block bg-green-500 text-white px-8 py-4 rounded-full font-bold hover:bg-green-600 transition-all shadow-xl">Start Shopping</a>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row justify-between items-center gap-8 group hover:shadow-xl transition-all">
                        <div class="flex items-center gap-8">
                            <div class="w-20 h-20 rounded-2xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 font-black text-sm">
                                <?php echo e($order->order_number); ?>

                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Placed on <?php echo e($order->created_at->format('M d, Y')); ?></p>
                                <h3 class="text-xl font-black text-gray-900 dark:text-white">₹<?php echo e(number_format($order->total, 2)); ?></h3>
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full 
                                        <?php if($order->status === 'delivered'): ?> bg-green-500
                                        <?php elseif($order->status === 'cancelled'): ?> bg-red-500
                                        <?php else: ?> bg-blue-500 <?php endif; ?>"></span>
                                    <span class="text-xs font-bold uppercase tracking-wider text-gray-500"><?php echo e(ucfirst($order->status)); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="<?php echo e(route('orders.show', $order)); ?>" class="px-8 py-4 rounded-2xl font-black border-2 border-gray-100 dark:border-gray-700 hover:border-green-500 hover:text-green-500 transition-all">View Details</a>
                            <?php if($order->status === 'pending'): ?>
                                <form action="<?php echo e(route('orders.cancel', $order)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-8 py-4 rounded-2xl font-black bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all" onclick="return confirm('Cancel this order?')">Cancel</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="mt-12">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml2\resources\views/orders/index.blade.php ENDPATH**/ ?>