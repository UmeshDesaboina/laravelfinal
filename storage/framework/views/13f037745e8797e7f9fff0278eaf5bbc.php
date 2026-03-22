<?php $__env->startSection('content'); ?>
<div class="bg-white dark:bg-gray-800 rounded-[2rem] p-8 shadow-xl border border-gray-100 dark:border-gray-700">
    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white text-center mb-2">Sign in to your account</h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 text-center mb-8">
        Or <a href="<?php echo e(route('register')); ?>" class="font-medium text-green-500 hover:text-green-600">create a new account</a>
    </p>

    <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-4','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

    <?php if(session('error')): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-xl text-sm">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div>
            <label for="email" class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Email Address</label>
            <input id="email" name="email" type="email" required autofocus autocomplete="username"
                value="<?php echo e(old('email')); ?>"
                class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4 focus:ring-2 focus:ring-green-500">
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-2 text-red-500 text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-2 text-red-500 text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>

        <div>
            <label for="password" class="block text-xs font-black uppercase tracking-widest text-gray-400 mb-2">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                class="w-full rounded-xl bg-gray-50 dark:bg-gray-700 border-none text-sm font-bold px-6 py-4 focus:ring-2 focus:ring-green-500">
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-2 text-red-500 text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-2 text-red-500 text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded text-green-500 focus:ring-green-500">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
            </label>

            <?php if(Route::has('password.request')): ?>
                <a href="<?php echo e(route('password.request')); ?>" class="text-sm font-medium text-green-500 hover:text-green-600">
                    Forgot password?
                </a>
            <?php endif; ?>
        </div>

        <button type="submit" class="w-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 py-4 rounded-xl font-black text-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-xl">
            Sign In
        </button>
    </form>

    <div class="mt-8">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-100 dark:border-gray-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white dark:bg-gray-800 text-gray-400">Or continue with</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-3">
            <a href="<?php echo e(route('auth.google')); ?>" class="w-full inline-flex justify-center items-center gap-2 bg-white dark:bg-gray-700 border border-gray-100 dark:border-gray-600 rounded-xl px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                <span class="text-sm font-bold">Google</span>
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\umesh\fightwisdoml234\resources\views/auth/login.blade.php ENDPATH**/ ?>