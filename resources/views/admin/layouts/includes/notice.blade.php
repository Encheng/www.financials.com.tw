@if (Session::has('message'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="icon fa fa-info"></i>
        {{ Session::get('message') }}</div>
@endif

@if(isset($errors))
    @if ( $errors->count() > 0 )
        <div class="alert alert-danger">
            <p>發生以下錯誤:</p>
            <ul>
                @foreach( $errors->all() as $message )
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endif