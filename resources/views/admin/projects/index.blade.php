@extends('admin.layout.app')
@section('title','المشاريع')
@section('content')
    <div class="">

        <div class="page-title " style="margin-bottom: 50px">
            <div class="title_left">
                <h3>المشاريع</h3>
            </div>

            <div class="title_right">
                <div class="form-group pull-right top_search">
                    <a href="{{ route('projects.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
                        إضافة مشروع
                    </a>
                </div>
            </div>
        </div>

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
@endsection
@push('js')

{{--    <script src="{{asset('proj')}}"></script>--}}
    <script src="{{asset('js/datatable.js')}}"></script>
    <script>
        window.data_url = "{{ route('projects.datatable') }}";
        window.columns = [
            {
                "data": "id",
                "title" : "#",
            },{
                "data": "name",
                "title" : "اسم المشروع",
            },{
                "data": "client",
                "title" : "صاحب المشروع",
            },{
                "data": "options",
                "title" : "{{ __('constants.actions') }}",
            },

        ];
    </script>

@endpush
