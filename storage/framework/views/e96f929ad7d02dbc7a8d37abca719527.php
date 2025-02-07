<div class="card pub_image">
    <div class="card-body">
        <div class="image-container">
            <a href="<?php echo e(route('image.detail', ['id' => $image->id])); ?>" >
                <img src="<?php echo e(route('image.file', ['filename' => $image->image_path])); ?>" />
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\wamp64\www\master-php\proyecto-laravel\resources\views/includes/image-grid.blade.php ENDPATH**/ ?>