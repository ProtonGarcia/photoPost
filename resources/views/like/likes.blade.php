@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Lo que te ha gustado</h1>

            @foreach($likes as $like)
            @include('includes.image',[
            'imagen' => $like->image
            ])
            @endforeach

             <!--Pagination-->
       <div class="clearfix"></div>
        {{$likes->links()}}

        </div>
     
    </div>
      
</div>
@endsection