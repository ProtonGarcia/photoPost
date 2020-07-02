@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>En la plataforma</h1>
            <form method="GET" action="{{ route('user.search') }}" id="buscador">
          
                <div class="row">
                    <div class="form-group col">
                        <input type="text" id="search" class="form-control" />
                    </div>
                    <div class="form-group col btn-search">
                        <input type="submit" value="Buscar" class="btn btn-success" />
                    </div>
                </div>
            </form>
            <hr>

            @foreach($users as $user)
            <div class="profile-user">

                @if($user->image)
                <div class="container-avatar-profile">
                    <img src="{{ route('user.avatar',['fileName' => $user->image]) }}" class="avatar">
                </div>
                @endif

                <div class="user-info">
                    <a href="{{ route('user.profile',['id' => $user->id]) }}" class="noLinks">
                        <h2>{{ '@'.$user->nick }}</h2>
                        <h4>{{ $user->name.' '.$user->surname }}</h4>
                    </a>

                </div>

            </div>
            <hr>

            <div class="clearfix"></div>
            @endforeach

            <!--Pagination-->
            <div class="clearfix"></div>
            {{$users->links()}}
        </div>

    </div>
</div>
@endsection