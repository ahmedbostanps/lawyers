@extends('admin.layout.app')
@section('title',__('panel.court_type'))
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => __('panel.court_type'),
             'action'=>route("court-type.create"),
             'model_title'=>__('panel.create_court_type'),
             'modal_id'=>'#addtag',
              'permission' => $adminHasPermition->can(['court_type_add'])
             ] )
            Status
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="DataTable" class="table" ></table>
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
        window.data_url = "{{route('court.type.list')}}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "type",
                'title': "{{ __('panel.court_type') }}",
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
