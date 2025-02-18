@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.message')

            <div class="card pub_image pub_image_detail">
                <div class="card-header">

                    @if($image->user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar"/>
                    </div>
                    @endif

                    <div class="data-user-detail">
                        <a href="{{ route('profile', ['id' => $image->user->id]) }}" >
                            {{ $image->user->name.' '.$image->user->surname }}
                            <span class="nickname">
                                {{ ' | @'.$image->user->nick }}
                            </span>
                        </a>
                    </div>
                    
                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="dropdown-detail">
                        <a class="nav-link dropdown-toggle-detail" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            ...  
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('image.edit', ['id' => $image->id]) }}">
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
                                    <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-danger">Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" />
                    </div>

                    <div class="description">
                        <span class="nickname">{{ '@'.$image->user->nick }}</span>
                        <span class="nickname date">{{ ' | '.\Carbon\Carbon::createFromTimeStamp(strtotime($image->created_at))->locale('en')->diffForHumans() }}</span>
                        <p>{{ $image->description }}</p>
                    </div>

                    <div class="likes">
                        <!--Comprobar si usuario ya dió like-->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <img src="{{ asset('img/heart-red.png') }}" data-id="{{ $image->id }}" class="btn-dislike" />
                        @else
                        <img src="{{ asset('img/heart.png') }}" data-id="{{ $image->id }}" class="btn-like" />
                        @endif
                        <span class="number_likes"> {{ count($image->likes) }} </span>
                    </div>
                    
<!--                    @if(Auth::user() && Auth::user()->id == $image->user->id)
                    <div class="actions">
                        <a href="{{ route('image.edit', ['id' => $image->id]) }}" class="btn btn-sm btn-actions" >
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
                                        <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-danger">Borrar</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endif-->
                    
                    <div class="clearfix"></div>
                    <div class="comments">
                        <span class="cmmnts">Comments ({{ count($image->comments) }})</span>
                        <hr>

                        <form method="POST" action="{{ route('comment.save') }}">
                            @csrf

                            <input type="hidden" name="image_id" value="{{ $image->id }}" />
                            <p>
                                <textarea class="form-control" name="content" required></textarea>
                            </p>
                            <button type="submit" class="btn btn-sm btn-comments">
                                Comment
                            </button>
                        </form>

                        @foreach($image->comments as $comment)
                        <div class="comment">
                            <span class="nickname">{{ '@'.$comment->user->nick }}</span>
                            <span class="nickname date">{{ ' | '.\Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->locale('en')->diffForHumans() }}</span>
                            <p>
                                {{ $comment->content }}
                                <br>
                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-comments">
                                    Delete
                                </a>
                                @endif
                            </p>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
