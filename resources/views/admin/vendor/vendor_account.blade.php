@extends('admin.layout.app')
@section('title','حساب البائع')
@section('content')
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h3>اسم البائع : <span>{{$name}}</span></h3>
            </div>


        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="{{ request()->is('admin/vendor/*') ? 'active' : '' }}"><a
                                            href="{{route('vendor.show',$client->id)}}">تفاصيل البائع</a>
                                </li>

                                @if($adminHasPermition->can(['expense_list']))
                                    <li role="presentation"
                                        class="{{ request()->is('admin/expense-account-list/*') ? 'active' : '' }}"><a
                                                href="{{url('admin/expense-account-list/'.$client->id)}}">حسابات</a>
                                    </li>
                                @endif
                            </ul>
                            <br><br>
                            <div id="myTabContent" class="tab-content">
                                <table id="Datatable" class="table"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="load-modal"></div>


@endsection
@push('js')
{{--    <script src="{{asset('assets/js/vendor/vendor-account-datatable.js') }}"></script>--}}
    <script src="{{asset('js/datatable.js') }}"></script>
    <script>
        window.data_url = "{{ url('admin/expense-filter-list' , ['advocate_client_id' => $client->id]) }}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "invoice_no",
                'title': "رقم الفاتورة",
            },
            {
                "data": "vandor",
                'title': "البائع",
            },
            {
                "data": "amount",
                'title': "المبلغ",
            },{
                "data": "paidAmount",
                'title': "المبلغ المدفوع",
            },
            {
                "data": "dueAmount",
                'title': "مبلغ مستحق",
            },
            {
                "data": "status",
                'title': "الحالة",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "options",
                'title': "عمليات",
                width: "5%",
                "orderable": false
            }
        ];
    </script>


@endpush
