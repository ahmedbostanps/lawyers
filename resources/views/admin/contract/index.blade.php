@extends('admin.layout.app')
@section('title','Client')
@section('content')
    <div class="">
        @component('component.heading' , [
       'page_title' => __('panel.Contracts'),
       'action_extra1' => route('contracts_categories.index') ,
       'action_extra2' => route('contracts_terms.index') ,
       'action' => route('contracts.create') ,
       'text' => __('panel.Add Contract'),
       'action_extra1_text' => __('panel.Add Category'),
       'action_extra2_text' => __('panel.Terms'),
       'permission' => $adminHasPermition->can(['client_add'])
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">
                        <table id="DataTable" class="table">
                            {{--                            <thead>--}}
                            {{--                            <tr>--}}
                            {{--                                <th width="5%">#</th>--}}
                            {{--                                <th>الطرف الأول</th>--}}
                            {{--                                <th width="">الطرف الثاني</th>--}}
                            {{--                                <th width="5%">الحالة</th>--}}
                            {{--                                <th width="5%">التفعيل</th>--}}
                            {{--                                <th width="5%" data-orderable="false" class="text-center">العمليات</th>--}}
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


    <script src="{{asset('js/datatable.js')}}"></script>
    <script>
        window.data_url = "{{ route('contracts.list') }}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "first_side",
                'title': "الطرف الأول",
            },
            {
                "data": "second_side",
                'title': "الطرف الثاني",
            },
            {
                "data": "status",
                'title': "الحالة",
                "width": "5%",
                "orderable": false

            },
            {
                "data": "is_active",
                'title': "التفعيل",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "action",
                'title': "الإجراءات",
                "width": "5%",
                "orderable": false
            }
        ];
    </script>

@endpush
