@extends('admin.layout.app')
@section('title', __('panel.judge'))
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => __('panel.judge'),
             'action'=>route("judge.create"),
             'model_title'=>__('panel.create_judge'),
             'modal_id'=>'#addtag',
             'permission' => $adminHasPermition->can(['judge_add'])
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
        window.data_url = "{{route('judge.list')}}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "judge_name",
                'title': "{{ __('panel.judge') }}",
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
