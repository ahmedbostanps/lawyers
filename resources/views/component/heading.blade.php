<div class="page-title">
    @if (isset($page_title))
        <div class="title_left">
            <h3>{{ $page_title  }}</h3>
        </div>
    @endif
    <div class="title_right">
        <div class="form-group pull-right top_search">

            @if (isset($action) )

                <a href="{{ $action }}"
                   class="btn btn-primary {{ isset($permission) &&  $permission=="1" ? '':'hidden' }}"><i
                        class="fa fa-plus"></i> {{ $text }}</a>
            @endif
            @if (isset($action_extra1) )

                <a href="{{ $action_extra1 }}"
                   class="btn btn-success {{ isset($permission) &&  $permission=="1" ? '':'hidden' }}"><i
                        class="fa fa-plus"></i> {{ $action_extra1_text }}</a>
            @endif
            @if (isset($action_extra2) )

                <a href="{{ $action_extra2 }}"
                   class="btn btn-danger {{ isset($permission) &&  $permission=="1" ? '':'hidden' }}"><i
                        class="fa fa-plus"></i> {{ $action_extra2_text }}</a>
            @endif


        </div>
    </div>
</div>
