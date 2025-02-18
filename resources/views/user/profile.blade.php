@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-user">
                @if($user->image)
                <div class="container-avatar">
                    <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" class="avatar"/>
                </div>
                @endif

                <div class="user-info">
                    <h1>{{ $user->name.' '.$user->surname }}</h1>
                    <h2>{{ '@'.$user->nick }}</h2>
                    <span class="nickname date">{{ 'Joined: '.\Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->locale('en')->diffForHumans() }}</span>
                </div>
                <div class="clearfix"></div>
                <hr>
            </div>

            <div class="clearfix"></div>

            <div class="contenedor-cuadricula">
                <div class="cuadricula-fotos">
                    @foreach($images as $image)
                        <div class="fotos">
                            @include('includes.image-grid', ['image' => $image])
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
