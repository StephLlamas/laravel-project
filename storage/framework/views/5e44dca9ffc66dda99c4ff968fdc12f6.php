

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <?php echo $__env->make('includes.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    <?php if($image->user->image): ?>
                    <div class="container-avatar">
                        <img src="<?php echo e(route('user.avatar', ['filename' => $image->user->image])); ?>" class="avatar"/>
                    </div>
                    <?php endif; ?>

                    <div class="data-user-detail">
                        <a href="<?php echo e(route('profile', ['id' => $image->user->id])); ?>" >
                            <?php echo e($image->user->name.' '.$image->user->surname); ?>

                            <span class="nickname">
                                <?php echo e(' | @'.$image->user->nick); ?>

                            </span>
                        </a>
                    </div>
                    
                    <?php if(Auth::user() && Auth::user()->id == $image->user->id): ?>
                    <div class="dropdown-detail">
                        <a class="nav-link dropdown-toggle-detail" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            ...  
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo e(route('image.edit', ['id' => $image->id])); ?>">
                                Update
                            </a>
                            
                            <!-- Link to Open the Modal -->
                            <a class="dropdown-item" href="#myModal" data-bs-toggle="modal" data-bs-target="#myModal">
                                Delete
                            </a>
                        </div>
                    </div>
                    
                    <!-- The Modal -->
                    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Delete Image</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Are you sure yo want to erase this image?
                                    This action can't be reversed.
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <a href="<?php echo e(route('image.delete', ['id' => $image->id])); ?>" class="btn btn-danger">Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <div class="image-container">
                        <img src="<?php echo e(route('image.file', ['filename' => $image->image_path])); ?>" />
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
                    
<!--                    <?php if(Auth::user() && Auth::user()->id == $image->user->id): ?>
                    <div class="actions">
                        <a href="<?php echo e(route('image.edit', ['id' => $image->id])); ?>" class="btn btn-sm btn-actions" >
                            Actualizar
                        </a>
                         Button to Open the Modal 
                        <button type="button" class="btn btn-sm btn-actions" data-bs-toggle="modal" data-bs-target="#myModal">
                          Borrar
                        </button>

                         The Modal 
                        <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                     Modal Header 
                                    <div class="modal-header">
                                        <h4 class="modal-title">Borrar Imagen</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                     Modal body 
                                    <div class="modal-body">
                                        ¿Estás seguro de querer borrar tu imagen?
                                        Esta acción no puede revertirse.
                                    </div>

                                     Modal footer 
                                    <div class="modal-footer">
                                        <a href="<?php echo e(route('image.delete', ['id' => $image->id])); ?>" class="btn btn-danger">Borrar</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>-->
                    
                    <div class="clearfix"></div>
                    <div class="comments">
                        <span class="cmmnts">Comments (<?php echo e(count($image->comments)); ?>)</span>
                        <hr>

                        <form method="POST" action="<?php echo e(route('comment.save')); ?>">
                            <?php echo csrf_field(); ?>

                            <input type="hidden" name="image_id" value="<?php echo e($image->id); ?>" />
                            <p>
                                <textarea class="form-control" name="content" required></textarea>
                            </p>
                            <button type="submit" class="btn btn-sm btn-comments">
                                Comment
                            </button>
                        </form>

                        <?php $__currentLoopData = $image->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="comment">
                            <span class="nickname"><?php echo e('@'.$comment->user->nick); ?></span>
                            <span class="nickname date"><?php echo e(' | '.\Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->locale('en')->diffForHumans()); ?></span>
                            <p>
                                <?php echo e($comment->content); ?>

                                <br>
                                <?php if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id)): ?>
                                <a href="<?php echo e(route('comment.delete', ['id' => $comment->id])); ?>" class="btn btn-sm btn-comments">
                                    Delete
                                </a>
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\master-php\proyecto-laravel\resources\views/image/detail.blade.php ENDPATH**/ ?>