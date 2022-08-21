@extends('admin.layout.app')
@section('title',__('panel.case_type'))
@section('content')
    <div class="">
        @component('component.modal_heading',
             [
             'page_title' => __('panel.case_type'),
             'action'=>route("case-type.create"),
             'model_title'=> __('panel.create_case_type'),
             'modal_id'=>'#addtag',
             'permission' => $adminHasPermition->can(['case_type_add'])
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
        window.data_url = "{{route('cash.type.list')}}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "parent",
                'title': "{{ __('panel.case_type') }}",
            },
            {
                "data": "chield",
                'title': "{{ __('panel.case_sub_type') }}",
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
