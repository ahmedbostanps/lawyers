@extends('admin.layout.app')
@section('title','انواع النفقات')
@section('content')
    <div class="">
        @component('component.modal_heading',
             [
             'page_title' => 'انواع النفقات',
             'action'=>route("expense-type.create"),
             'model_title'=>'إضافة نوع نفقات',
             'modal_id'=>'#addtag',
             'permission' => $adminHasPermition->can(['expense_type_add'])
             ] )
            Status
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="DataTable" class="table"></table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="load-modal"></div>
@endsection

@push('js')

    <script src="{{asset('js/datatable.js')}}"></script>
    <script>
        window.data_url = "{{ route('expense.type.list') }}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "name",
                'title': "الإسم",
                "orderable": false,
                'class' : 'text-center'
            },
            {
                "data": "is_active",
                'title': "حالة",
                "orderable": false,
                'class' : 'text-center'

            },
            {
                "data": "action",
                'title': "العمليات",
                "orderable": false,
                'class': 'text-center',
            }
        ];
    </script>

@endpush
