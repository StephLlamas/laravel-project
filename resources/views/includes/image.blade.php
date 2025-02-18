<div class="card pub_image">
    <div class="card-header">

        @if($image->user->image)
        <div class="container-avatar">
            <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="avatar"/>
        </div>
        @endif

        <div class="data-user">
            <a href="{{ route('profile', ['id' => $image->user->id]) }}" >
            {{ $image->user->name.' '.$image->user->surname }}
            <span class="nickname">
                {{ ' | @'.$image->user->nick }}
            </span>
        </div>
    </div>

    <div class="card-body">
        <div class="image-container">
            <a href="{{ route('image.detail', ['id' => $image->id]) }}" >
                <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" />
            </a>
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

        <div class="comments">
            <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn btn-sm btn-comments">
                Comments ({{ count($image->comments) }})
            </a>
        </div>
    </div>
</div>