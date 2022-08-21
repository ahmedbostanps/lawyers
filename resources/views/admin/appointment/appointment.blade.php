@extends('admin.layout.app')
@section('title','المواعيد')
@push('style')
    <link rel="stylesheet" type="text/css"
          href="{{asset('assets/admin/jquery-confirm-master/css/jquery-confirm.css')}}">

@endpush
@section('content')
    <div class="">

        @component('component.heading' , [

       'page_title' => 'المواعيد',
       'action' => route('appointment.create') ,
       'text' => 'إضافة موعد',
       'permission' => $adminHasPermition->can(['appointment_add'])
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                    <div class="x_title">
                        <div class="row">
                            {{--                            <div class="col-md-3 form-group">--}}
                            {{--                                <label for="date_from">From Date :</label>--}}

                            {{--                                <input type="text" class="form-control dateFrom" id="date_from" autocomplete="off"--}}
                            {{--                                       readonly="">--}}

                            {{--                            </div>--}}

                            {{--                            <div class="col-md-3 form-group">--}}
                            {{--                                <label for="date_to">To Date :</label>--}}

                            {{--                                <input type="text" class="form-control dateTo" id="date_to" autocomplete="off"--}}
                            {{--                                       readonly="">--}}


                            {{--                            </div>--}}

                            {{--                            <ul class="nav navbar-left panel_toolbox">--}}

                            {{--                                <br>--}}
                            {{--                                &nbsp;&nbsp;&nbsp;--}}
                            {{--                                <button class="btn btn-danger appointment-margin" type="button" id="btn_clear"--}}
                            {{--                                        name="btn_clear"--}}
                            {{--                                >Clear--}}
                            {{--                                </button>--}}
                            {{--                                <button type="submit" id="search" class="btn btn-success appointment-margin"><i--}}
                            {{--                                        class="fa fa-search"></i>&nbsp;Search--}}
                            {{--                                </button>--}}
                            {{--                            </ul>--}}

                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table id="DataTable" class="table appointment_table">
                            {{--                            <thead>--}}
                            {{--                            <tr>--}}
                            {{--                                <th>No</th>--}}
                            {{--                                <th width="40%">Client Name</th>--}}
                            {{--                                <th width="10%">Mobile</th>--}}
                            {{--                                <th width="10%;">Date</th>--}}
                            {{--                                <th>Time</th>--}}
                            {{--                                <th data-orderable="false">Status</th>--}}
                            {{--                                <th data-orderable="false">Action</th>--}}
                            {{--                            </tr>--}}
                            {{--                            </thead>--}}


                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">
    <input type="hidden" name="date_format_datepiker"
           id="date_format_datepiker"
           value="{{$date_format_datepiker}}">
    <input type="hidden" name="common_change_state"
           id="common_change_state"
           value="{{url('common_change_state')}}">

@endsection

@push('js')
    <script type="text/javascript" src="{{asset('assets/admin/jquery-confirm-master/js/jquery-confirm.js')}}"></script>
    {{--    <script src="{{asset('assets/js/appointment/appointment-datatable.js')}}"></script>--}}

    <script src="{{asset('js/datatable.js')}}"></script>
    <script>
        window.data_url = "{{route('appointment.list')}}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "name",
                'title': "اسم العميل",
            },
            {
                "data": "mobile",
                'title': "رقم التواصل",
            },
            {
                "data": "date",
                'title': "التاريخ",
                "orderable": false
            },
            {
                "data": "time",
                'title': "الوقت",
                "orderable": false
            },
            {
                "data": "is_active",
                'title': "الحالة",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "action",
                'title': "الإجراءات",
                width: "5%",
                "orderable": false
            }
        ];
    </script>

    <script>
        var common_change_state = $('#common_change_state').val();

        function change_status(id, status, table) {

            $.confirm({
                title: 'تأكيد الحالة',
                content: 'من السهل القيام بتأكيدات متعددة في وقت واحد. <br> انقر فوق تأكيد أو إلغاء لشروط آخر',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'تاكيد',
                        btnClass: 'btn-blue',
                        action: function () {
                            $.confirm({
                                title: 'هل أنت متأكد أنك تريد تغيير الحالة؟',
                                content: 'يمكن أن يكون للإجراءات الحاسمة تأكيدات متعددة مثل هذه.',
                                icon: 'fa fa-warning',
                                animation: 'scale',
                                closeAnimation: 'zoom',
                                buttons: {
                                    confirm: {
                                        text: 'نعم بالتأكيد!',
                                        btnClass: 'btn-orange',
                                        action: function () {
                                            // ajax adding data to database
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                                }
                                            });
                                            $.ajax({
                                                url: common_change_state,
                                                type: "POST",
                                                dataType: "JSON",
                                                data: {id: id, status: status, table: table},
                                                async: false,
                                                success: function (data) {
                                                    if (data.errors) {
                                                        message.fire({
                                                            type: 'error',
                                                            title: 'خطأ',
                                                            text: "مشكلة في الحذف !!! حاول مرة اخرى."
                                                        });


                                                    }
                                                    //error_massage('Problem in delete!!! Please try again.');                                             }
                                                    else {
                                                        message.fire({
                                                            type: 'success',
                                                            title: 'Scueess',
                                                            text: "Status changed successfully."
                                                        });
                                                        var t = $('#DataTable').DataTable();
                                                        d.destroy();
                                                        // tab_appoint_list();
                                                        DatatableRemoteAjaxDemo.init()
                                                    }
                                                },
                                                error: function (jqXHR, textStatus, errorThrown) {
                                                    alert('خطأ في إضافة / تحديث البيانات');
                                                }
                                            });
                                        }
                                    },
                                    cancel: {
                                        text: 'إلغاء',
                                        action: function () {
                                            var d = $('#DataTable').DataTable();
                                            d.destroy();
                                            // tab_appoint_list();
                                            DatatableRemoteAjaxDemo.init()
                                            $.alert('لقد نقرت على <strong>إلغاء</strong>');
                                        }
                                    }


                                }
                            });
                        }
                    },
                    cancel: {
                        text: 'إلغاء',
                        action: function () {
                            var d = $('#DataTable').DataTable();
                            d.destroy();
                            DatatableRemoteAjaxDemo.init()
                            $.alert('لقد نقرت على <strong>إلغاء</strong>');
                        }
                    },
                }
            });
        }

        function getval(sel) {
            return sel.value;
        }
    </script>

@endpush
