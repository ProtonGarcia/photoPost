@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.showMessage')


            <div class="card pub_image image_detail_all">
                <div class="card-header">
                    @if($imagen->user->image)
                    <div class="container-avatar">
                        <img src="{{ route('user.avatar',['fileName' => $imagen->user->image]) }}" class="avatar">
                    </div>
                    @endif
                    <div class="nickContain">
                        <div class="data-user">
                            <a href="{{ route('user.profile',['id' => $imagen->user->id]) }}">
                                {{ '@'.$imagen->user->nick}}
                            </a>
                        </div>
                       
                        <div class="actions">
                            @if(Auth::user() && Auth::user()->id == $imagen->user->id)
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">
                                Eliminar 
                            </button>

                            <!-- The Modal -->
                            <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">¿Seguro que eliminaras esto?</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            Si procedes con la eliminacion no se podra recuperar, Seguro que deseas eliminarla?
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancelar</button>
                                            <a href="{{ route('image.delete', ['id' => $imagen->id]) }}" class="btn btn-sm btn-danger">Borrar definitivamente</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('image.edit',['id' => $imagen->id]) }}" class="btn btn-sm btn-primary">Editar</a>
                            @endif
                        </div>
                    </div>


                </div>

                <div class="card-body">
                    <div class="image-container image-detail">
                        <img src="{{ route('image.file',['filename' => $imagen->image_path]) }}" alt="">
                    </div>
                    <div class="likes">
                        <!--comprobando si el usuario le dio like-->

                        <?php $user_like = false; ?>
                        @foreach($imagen->likes as $like)
                        @if($like->user->id == Auth::user()->id)
                        <?php $user_like = true; ?>
                        @endif
                        @endforeach

                        @if($user_like)
                        <img src="{{asset('images/favorite-2-red.png')}}" data-id="{{ $imagen->id }}" class="btn-dislike" />
                        @else
                        <img src="{{asset('images/favorite-2-gray.png')}}" data-id="{{ $imagen->id }}" class="btn-like" />
                        @endif
                        <!--fin de la comprobacion-->
                        <img src="{{asset('images/comments.png')}}" />
                        <img src="{{asset('images/sharethis-64.png')}}" />
                        <div class="countLikes">
                            @if(count($imagen->likes) > 0)
                            <strong>{{ count($imagen->likes).' likes'}}</strong>
                            @endif

                        </div>

                    </div>
                    <div class="description">
                        <span class="nickname">{{'@'.$imagen->user->nick}}</span>
                        <p> {{$imagen->description }}</p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="comments">
                        <h4>Comentarios ({{count($imagen->comments)}})</h4>
                        <hr>
                        <form action="{{ route('comment.save') }}" method="POST" class="form-comments">
                            @csrf
                            <input type="hidden" name="image-id" value="{{$imagen->id}}">
                            <p><textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content" required></textarea>
                                @if($errors->has('content'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </span>
                                @endif
                            </p>

                            <input type="submit" value="Comentar" class="btn btn-success">
                        </form>
                        <hr>
                        @foreach($imagen->comments as $comment)
                        <div class="comment">
                            <span class="nickname"><strong>{{ '@'.$comment->user->nick }}: </strong>{{ $comment->content }}
                                @if(Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                <a href="{{ route('comment.delete', ['id' => $comment->id]) }}" class="btn btn-sm btn-danger">Eliminar</a>
                                @endif
                            </span>
                            <p class="parrafo">{{\FormatTime::LongTimeFilter($comment->created_at)}} </p>


                        </div>
                        @endforeach

                    </div>

                </div>
                <span class="nickname date">{{\FormatTime::LongTimeFilter($imagen->created_at) }}</span>
            </div>



        </div>
    </div>
    @endsection