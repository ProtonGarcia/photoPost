@if(Auth::user()->image)
<div class="container-avatar">
    <img src="{{ route('user.avatar',['fileName' => Auth::user()->image]) }}" class="avatar">
</div>

@endif