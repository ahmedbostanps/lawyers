@extends('admin.layout.app')
@section('title','نظرة عامة')
@section('content')

    @if($adminHasPermition->can(['dashboard_list']))

        <link href="{{ asset('assets/admin/vendors/fullcalendar/dist/fullcalendar.min.css') }} " rel="stylesheet">
        <form method="POST" action="{{url('admin/dashboard')}}" id="case_board_form">
        {{ csrf_field() }}
        <!-- top tiles -->
            <div class="page-title">
                <div class="title_left">
                    <h3>نظرة عامة</h3>
                </div>


            </div>

            <div class="clearfix"></div>

            <div class="row">
                <a href="{{ route('clients.index') }}">
                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6  ">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-users"></i>
                            </div>
                            <div class="count">{{ $client ?? '' }}</div>
                            <h3>العملاء</h3>
                            <p>عدد العملاء</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('case-running.index') }}">
                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6  ">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-gavel"></i>
                            </div>
                            <div class="count">{{ $case_total ?? '' }}</div>
                            <h3>القضايا</h3>
                            <p>عدد القضايا</p>
                        </div>
                    </div>
                </a>
                <a href="{{ url('admin/case-important') }}">
                    <div class="animated flipInY col-lg-4 col-md-4 col-sm-6  ">
                        <div class="tile-stats">
                            <div class="icon"><i class="fa fa-star"></i>
                            </div>
                            <div class="count">{{ $important_case ?? '' }}</div>
                            <h3>المشاريع</h3>
                            <p>عدد المشاريع</p>
                        </div>
                    </div>
                </a>
{{--                <a href="{{ url('admin/case-archived') }}">--}}
{{--                    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">--}}
{{--                        <div class="tile-stats">--}}
{{--                            <div class="icon"><i class="fa fa-file-archive-o"></i>--}}
{{--                            </div>--}}
{{--                            <div class="count">{{$archived_total}}</div>--}}
{{--                            <h3>Archived Cases</h3>--}}
{{--                            <p>Total completed cases.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </a>--}}
            </div>
            <br/>

            <div id="load-modal"></div>
            <!-- /top tiles -->
        </form>



        <div class="modal fade" id="modal-case-priority" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="show_modal">

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-change-court" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="show_modal_transfer">

                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-next-date" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="show_modal_next_date">

                </div>
            </div>
        </div>

        <input type="hidden" name="token-value"
               id="token-value"
               value="{{csrf_token()}}">

        <input type="hidden" name="case-running"
               id="case-running"
               value="{{url('admin/case-running')}}">

        <input type="hidden" name="appointment"
               id="appointment"
               value="{{url('admin/appointment')}}">
        <input type="hidden" name="ajaxCalander"
               id="ajaxCalander"
               value="{{ url('admin/ajaxCalander') }}">

        <input type="hidden" name="date_format_datepiker"
               id="date_format_datepiker"
               value="{{$date_format_datepiker}}">
        <input type="hidden" name="dashboard_appointment_list"
               id="dashboard_appointment_list"
               value="{{ url('admin/dashboard-appointment-list') }}">

        <input type="hidden" name="getNextDateModal"
               id="getNextDateModal"
               value="{{url('admin/getNextDateModal')}}">

        <input type="hidden" name="getChangeCourtModal"
               id="getChangeCourtModal"
               value="{{url('admin/getChangeCourtModal')}}">

        <input type="hidden" name="getCaseImportantModal"
               id="getCaseImportantModal"
               value="{{url('admin/getCaseImportantModal')}}">
        <input type="hidden" name="getCourt"
               id="getCourt"
               value="{{url('getCourt')}}">
        <input type="hidden" name="downloadCaseBoard"
               id="downloadCaseBoard"
               value="{{url('admin/downloadCaseBoard')}}">
        <input type="hidden" name="printCaseBoard"
               id="printCaseBoard"
               value="{{url('admin/printCaseBoard')}}">

    @endif
@endsection
@push('js')
    <script src='https://fullcalendar.io/js/fullcalendar-3.1.0/lib/moment.min.js'></script>
    <script src="{{ asset('assets/admin/vendors/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{asset('assets/js/dashbord/dashbord-datatable.js')}}"></script>
@endpush
