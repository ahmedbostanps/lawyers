@extends('admin.layout.app')
@section('title','المهام')
@section('content')

    <div class="">
        @component('component.heading' , [
       'page_title' => 'المهام',
       'action' => route('tasks.create') ,
       'text' => 'إضافة مهمة',
       'permission' => $adminHasPermition->can(['task_add'])
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">تاريخ البدء <span class="text-danger">*</span></label>
                                <input type="date" placeholder="" class="form-control" id="start_date"
                                       name="start_date">
                                {{--                                readonly=""--}}
                            </div>
                        </div>
                        <table id="DataTable" class="table"
                        >
                            {{--                            <thead>--}}
                            {{--                            <tr>--}}
                            {{--                                <th>#</th>--}}
                            {{--                                <th>اسم المهمة</th>--}}
                            {{--                                <th>متعلق ب</th>--}}
                            {{--                                <th>تاريخ البدء</th>--}}
                            {{--                                <th>حد اقصى</th>--}}
                            {{--                                <th>أعضاء</th>--}}
                            {{--                                <th>حالة</th>--}}
                            {{--                                <th>أولوية</th>--}}
                            {{--                                <th data-orderable="false" class="text-center">العمليات</th>--}}
                            {{--                            </tr>--}}
                            {{--                            </thead>--}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{--    <script src="{{asset('assets/js/task/task-datatable.js')}}"></script>--}}

    <script src="{{asset('js/datatable.js')}}"></script>
    <script>
        window.data_url = "{{ route('task.list') }}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "task_subject",
                'title': "اسم المهمة",
                "orderable": false
            },
            {
                "data": "case",
                'title': "متعلق ب",
                "orderable": false,
            },
            {
                "data": "start_date",
                'title': "تاريخ البدء",
                "orderable": false
            },
            {
                "data": "end_date",
                'title': "حد اقصى",
                "orderable": false,
            },
            {
                "data": "members",
                'title': "أعضاء",
                "orderable": false,
            },
            {
                "data": "status",
                'title': "حالة",
                "orderable": false

            },
            {
                "data": "priority",
                'title': "أولوية",
                "orderable": false
            },
            {
                "data": "action",
                'title': "العمليات",
                "orderable": false,
                'class': 'text-center',
            }
        ];

        $('#start_date').on('change', function () {
            t.column(3).search($('#start_date').val() ).draw();
            // t.search( 'start_date' , $('#start_date').val()).draw();

        });

    </script>

@endpush
