<ul class="nav navbar-right panel_toolbox">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true"><i
                class="fa fa-ellipsis-h" style="font-size: 19px;"></i></a>
        <ul class="dropdown-menu" role="menu">


            <li><a
                    href="{{ route('projects.edit' , $instance->id) }}"><i class="fa fa-edit"></i>تعديل</a></li>

            <li><a class="delete-confrim "
                   data-id={{ $instance->id }}  href="{{ route('projects.destroy' , $instance->id) }}"><i
                        class="fa fa-trash"></i>&nbsp;&nbsp;{{ __('constants.delete') }}</a>
            </li>


        </ul>
    </li>

</ul>



