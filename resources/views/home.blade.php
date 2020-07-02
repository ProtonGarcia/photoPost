@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.showMessage')

            @foreach($images as $imagen)
                @include('includes.image', [
                    'image' => $imagen
                    ])
            @endforeach

            <!--Pagination-->
            <div class="clearfix"></div>
            {{$images->links()}}
        </div>

    </div>
</div>
@endsection