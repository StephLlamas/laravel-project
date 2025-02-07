

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-user">
                <?php if($user->image): ?>
                <div class="container-avatar">
                    <img src="<?php echo e(route('user.avatar', ['filename' => $user->image])); ?>" class="avatar"/>
                </div>
                <?php endif; ?>

                <div class="user-info">
                    <h1><?php echo e($user->name.' '.$user->surname); ?></h1>
                    <h2><?php echo e('@'.$user->nick); ?></h2>
                    <span class="nickname date"><?php echo e('Joined: '.\Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->locale('en')->diffForHumans()); ?></span>
                </div>
                <div class="clearfix"></div>
                <hr>
            </div>

            <div class="clearfix"></div>

            <div class="contenedor-cuadricula">
                <div class="cuadricula-fotos">
                    <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="fotos">
                            <?php echo $__env->make('includes.image-grid', ['image' => $image], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\master-php\proyecto-laravel\resources\views/user/profile.blade.php ENDPATH**/ ?>