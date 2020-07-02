@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="profile-user">
               
                    @if($user->image)
                    <div class="container-avatar-profile">
                        <img src="{{ route('user.avatar',['fileName' => $user->image]) }}" class="avatar">
                    </div>
                    @endif
                
                <div class="user-info">

                    <h2>{{ '@'.$user->nick }}</h2>
                    <h4>{{ $user->name.' '.$user->surname }}</h4>
                    
                </div>

            </div>

            <div class="clearfix"></div>


            @foreach($user->images as $imagen)
            @include('includes.image', [
            'image' => $imagen
            ])
            @endforeach

        </div>

    </div>
</div>
@endsection