<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">

        <ul class="nav side-menu">
            @if($adminHasPermition->can(['dashboard_list'])=="1")
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-tachometer"></i> الرئيسية</a></li>
            @endif

            @if($adminHasPermition->can(['client_list']) =="1")
                <li><a><i class="fa fa-users"></i> @lang('panel.Clients Managements') <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ route('clients.index') }}"> @lang('panel.Clients')</a></li>
                        <li><a href="{{ route('contracts.index') }}">@lang('panel.Contracts')</a></li>

                    </ul>
                </li>
            @endif

            @if($adminHasPermition->can(['case_list']) =="1")
                <li><a href="{{ route('case-running.index') }}"><i class="fa fa-gavel"></i> القضايا</a></li>

            @endif
            @if($adminHasPermition->can(['case_list']) =="1")
                <li><a href="{{ route('projects.index') }}"><i class="fa fa-briefcase"></i>المشاريع</a></li>

            @endif
            @if($adminHasPermition->can(['task_list']) =="1")
                <li><a href="{{ route('tasks.index') }}"><i class="fa fa-tasks"></i> المهام</a></li>
            @endif


            @if($adminHasPermition->can(['appointment_list']) =="1")
                <li><a href="{{ route('appointment.index') }}"><i class="fa fa-calendar-plus-o"></i> المواعيد</a>
                </li>

            @endif
            @if(\Auth::guard('admin')->user()->user_type=="Admin")
                <li><a><i class="fa fa-users"></i> @lang('panel.Team Members') <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{ url('admin/client_user') }}"> @lang('panel.Lawyers')</a></li>
                        <li><a href="{{ route('role.index') }}">@lang('panel.Roles')</a></li>

                    </ul>
                </li>
            @endif
            @if($adminHasPermition->can(['service_list']) == "1" || $adminHasPermition->can(['invoice_list'])=="1")
                <li><a><i class="fa fa-money"></i> المالية <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        @if($adminHasPermition->can(['service_list']) == "1")
                            <li><a href="{{ url('admin/service') }}">خدمات</a></li>
                        @endif

                        @if($adminHasPermition->can(['invoice_list']) == "1")
                            <li><a href="{{ url('admin/invoice') }}">فواتير</a>
                        @endif


                    </ul>
                </li>
            @endif
            @if($adminHasPermition->can(['vendor_list']) =="1")
                <li><a href="{{ route('vendor.index') }}"><i class="fa fa-user-plus"></i> الزبائن</a></li>
            @endif

            @if($adminHasPermition->can(['expense_type_list'])=="1" || $adminHasPermition->can(['expense_list'])=="1")
                <li><a><i class="fa fa-money"></i> نفقات <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                        @if($adminHasPermition->can(['expense_type_list']) =="1")
                            <li><a href="{{ url('admin/expense-type') }}">انواع نفقات</a></li>
                        @endif


                        @if($adminHasPermition->can(['expense_list']) =="1")
                            <li><a href="{{ url('admin/expense') }}">نفقات</a></li>
                        @endif

                    </ul>
                </li>

            @endif


            @if($adminHasPermition->can(['case_type_list'])=="1"
            || $adminHasPermition->can(['court_type_list'])=="1"
            || $adminHasPermition->can(['court_list'])=="1"
            || $adminHasPermition->can(['case_status_list'])=="1"
            || $adminHasPermition->can(['judge_list'])=="1"
            || $adminHasPermition->can(['tax_list'])=="1"
            || $adminHasPermition->can(['general_setting_edit'])=="1")
                <li><a><i class="fa fa-gear"></i> {{ __('panel.settings') }} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">

                        @if($adminHasPermition->can(['case_type_list']) == "1")
                            <li><a href="{{ url('admin/case-type') }}">{{ __('panel.case_type') }}</a></li>
                        @endif

                        @if($adminHasPermition->can(['court_type_list']) == "1")
                            <li><a href="{{ url('admin/court-type') }}">{{ __('panel.court_type') }}</a></li>
                        @endif

                        @if($adminHasPermition->can(['court_list']) == "1")
                            <li><a href="{{ url('admin/court') }}">{{ __('panel.court') }}</a></li>
                        @endif

                        @if($adminHasPermition->can(['case_status_list']) == "1")
                            <li><a href="{{ url('admin/case-status') }}">{{ __('panel.case_status') }}</a></li>
                        @endif

                        @if($adminHasPermition->can(['judge_list']) == "1")
                            <li><a href="{{ url('admin/judge') }}">{{ __('panel.judge') }}</a></li>
                        @endif

                        @if($adminHasPermition->can(['tax_list']) == "1")
                            <li><a href="{{ url('admin/tax') }}">{{ __('panel.tax') }}</a></li>
                        @endif

                        @if($adminHasPermition->can(['general_setting_edit']) == "1")
                            <li><a href="{{ url('admin/general-setting') }}">{{ __('panel.general_setting') }}</a></li>
                        @endif
                        @if(\Auth::guard('admin')->user()->user_type=="Admin")
                            <li><a href="{{ url('admin/database-backup') }}">{{ __('panel.database_backup') }}</a></li>
                        @endif

                    </ul>
                </li>
            @endif

        </ul>
    </div>
</div>
