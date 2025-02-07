<div class="card pub_image">
    <div class="card-body">
        <div class="image-container">
            <a href="{{ route('image.detail', ['id' => $image->id]) }}" >
                <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" />
            </a>
        </div>
    </div>
</div>
