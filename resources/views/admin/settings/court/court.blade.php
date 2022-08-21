@extends('admin.layout.app')
@section('title',__('panel.court'))
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => __('panel.court'),
             'action'=>route("court.create"),
             'model_title'=>__('panel.create_court'),
             'modal_id'=>'#addtag',
              'permission' => $adminHasPermition->can(['court_add'])
             ] )
            Status
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="DataTable" class="table" data-url="{{ route('court.list') }}" >
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th width="5%">No</th>--}}
{{--                                <th>Court</th>--}}
{{--                                <th>Court Type</th>--}}
{{--                                <th width="5%" data-orderable="false">Status</th>--}}
{{--                                <th width="2%" data-orderable="false" class="text-center">Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
                        </table>
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
        window.data_url = "{{route('court.list')}}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "court_name",
                'title': "{{ __('panel.court') }}",
            },
            {
                "data": "court_type",
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
