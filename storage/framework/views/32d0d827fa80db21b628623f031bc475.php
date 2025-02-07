<div class="card pub_image">
    <div class="card-header">

        <?php if($image->user->image): ?>
        <div class="container-avatar">
            <img src="<?php echo e(route('user.avatar', ['filename' => $image->user->image])); ?>" class="avatar"/>
        </div>
        <?php endif; ?>

        <div class="data-user">
            <a href="<?php echo e(route('profile', ['id' => $image->user->id])); ?>" >
            <?php echo e($image->user->name.' '.$image->user->surname); ?>

            <span class="nickname">
                <?php echo e(' | @'.$image->user->nick); ?>

            </span>
        </div>
    </div>

    <div class="card-body">
        <div class="image-container">
            <a href="<?php echo e(route('image.detail', ['id' => $image->id])); ?>" >
                <img src="<?php echo e(route('image.file', ['filename' => $image->image_path])); ?>" />
            </a>
        </div>

        <div class="description">
            <span class="nickname"><?php echo e('@'.$image->user->nick); ?></span>
            <span class="nickname date"><?php echo e(' | '.\Carbon\Carbon::createFromTimeStamp(strtotime($image->created_at))->locale('en')->diffForHumans()); ?></span>
            <p><?php echo e($image->description); ?></p>
        </div>

        <div class="likes">
            <!--Comprobar si usuario ya dió like-->
            <?php $user_like = false; ?>
            <?php $__currentLoopData = $image->likes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $like): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($like->user->id == Auth::user()->id): ?>
            <?php $user_like = true; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($user_like): ?>
            <img src="<?php echo e(asset('img/heart-red.png')); ?>" data-id="<?php echo e($image->id); ?>" class="btn-dislike" />
            <?php else: ?>
            <img src="<?php echo e(asset('img/heart.png')); ?>" data-id="<?php echo e($image->id); ?>" class="btn-like" />
            <?php endif; ?>
            <span class="number_likes"> <?php echo e(count($image->likes)); ?> </span>
        </div>

        <div class="comments">
            <a href="<?php echo e(route('image.detail', ['id' => $image->id])); ?>" class="btn btn-sm btn-comments">
                Comments (<?php echo e(count($image->comments)); ?>)
            </a>
        </div>
    </div>
</div><?php /**PATH C:\wamp64\www\master-php\proyecto-laravel\resources\views/includes/image.blade.php ENDPATH**/ ?>