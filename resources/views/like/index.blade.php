@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>Likes history</strong>
                </div>
            </div>
            <br>
            
            @foreach($likes as $like)
                @include('includes.image', ['image' => $like->image])
            @endforeach
            
            <!-- PAGINACIÓN -->
            <div class="clearfix">
                {{ $likes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection