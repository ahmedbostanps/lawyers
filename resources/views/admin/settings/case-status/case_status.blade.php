@extends('admin.layout.app')
@section('title',__('panel.case_status'))
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => __('panel.case_status'),
             'action'=>route("case-status.create"),
             'model_title'=>__('panel.create_case_status'),
             'modal_id'=>'#addtag',
             'permission' => $adminHasPermition->can(['case_status_add'])
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
        window.data_url = "{{route('case.status.list')}}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "case_status_name",
                'title': "{{ __('panel.case_status') }}",
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
