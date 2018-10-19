@if(Session::has('danger'))
    <div class="alert alert-danger alert-dismissible text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <b>{{ Session::get('danger') }}</b>
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <b>{{ Session::get('success') }}</b>
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert alert-warning alert-dismissible text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <b>{{ Session::get('warning') }}</b>
    </div>
@endif

@if(Session::has('info'))
    <div class="alert alert-info alert-dismissible text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <b>{{ Session::get('info') }}</b>
    </div>
@endif