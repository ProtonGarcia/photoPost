<div class="card pub_image">
    <div class="card-header">
        @if($imagen->user->image)
        <div class="container-avatar">
            <img src="{{ route('user.avatar',['fileName' => $imagen->user->image]) }}" class="avatar">
        </div>
        @endif
        <div class="data-user">
            <a href="{{ route('user.profile',['id' => $imagen->user->id]) }}" class="noLinks">
                {{ '@'.$imagen->user->nick}}
            </a>
        </div>

    </div>

    <div class="card-body">
        <div class="image-container">
            <a href="{{ route('image.detail', ['id' => $imagen->id]) }}">
                <img src="{{ route('image.file',['filename' => $imagen->image_path]) }}" alt="">
            </a>
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
            <a href="{{ route('image.detail',['id' => $imagen->id]) }}">
                <img src="{{asset('images/comments.png')}}" />
            </a>
            <img src="{{asset('images/sharethis-64.png')}}" />
            <div class="countLikes">
                @if(count($imagen->likes) > 0)
                <strong>{{ count($imagen->likes).' likes'}}</strong>
                @endif

            </div>

        </div>

        <div class="description">
            <span class="nickname">{{$imagen->user->nick}}</span>
            <p> {{$imagen->description }}</p>
            <a href="{{ route('image.detail',['id' => $imagen->id]) }}">
                <span class="nickname noLinks">Comentarios {{ count($imagen->comments) }}</span>
            </a>
        </div>

    </div>
    <span class="nickname date">{{\FormatTime::LongTimeFilter($imagen->created_at) }}</span>
</div>