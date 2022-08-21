@extends('admin.layout.app')
@section('title','Client')
@section('content')
    <div class="">
        @component('component.heading' , [
       'page_title' => 'إدارة العملاء',
       'action' => route('clients.create') ,
       'text' => 'إضافة عميل',
       'permission' => $adminHasPermition->can(['client_add'])
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">
                        <table id="DataTable" class="table" data-url="{{ route('clients.list') }}"></table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('js')

    <script src="{{asset('js/datatable.js')}}"></script>
    <script>
        window.data_url = "{{ route('clients.list') }}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "first_name",
                'title': "إسم العميل",
            },
            {
                "data": "mobile",
                'title': "رقم التواصل",
                "width": "5%",
            },
            {
                "data": "case",
                'title': "القضية",
                "width": "5%",
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
@endpush
