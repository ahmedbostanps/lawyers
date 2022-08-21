@extends('admin.layout.app')
@section('title','البمود')
@section('content')
    <div class="">
        @component('component.heading' , [
       'page_title' => __('panel.Terms'),
       'action' => route('contracts_terms.create') ,
       'text' => __('panel.Add Terms'),
       'permission' => $adminHasPermition->can(['client_add'])
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">
                        <table id="DataTable" class="table">

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
        window.data_url = "{{ route('contract.terms.list') }}";
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
            },
            {
                "data": "category",
                'title': "التصنيف",
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
