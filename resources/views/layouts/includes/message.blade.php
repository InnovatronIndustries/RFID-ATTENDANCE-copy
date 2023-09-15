@if( Session::has("success") )
    <div class="alert alert-success fade in">
        <i class="icon-remove close" data-dismiss="alert"></i>
        <strong>{!! Session::get("success") !!}</strong>
    </div>
@endif

@if( Session::has("error") )
    <div class="alert alert-danger fade in">
        <i class="icon-remove close" data-dismiss="alert"></i>
        <strong>{!! Session::get("error") !!}</strong>
    </div>
@endif

@if( Session::has("info") )
    <div class="alert alert-info fade in">
        <i class="icon-remove close" data-dismiss="alert"></i>
        <strong>{!! Session::get("info") !!}</strong>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-sm alert-danger fade in">
        <i class="icon-remove close" data-dismiss="alert"></i>
        @foreach($errors->all() as $error)
            <li style="display: inline;">{{ $error }}</li><br>
        @endforeach
    </div>
@endif