@extends('admin.layout.app')
@section('title','Invoice')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>الفواتير</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                @if($adminHasPermition->can(['invoice_add']))
                    <a href="{{url('admin/create-Invoice-view')}}" class="btn btn-primary"><i class="fa fa-plus"></i>
                        إضافة فاتورة</a>
                @endif


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <table id="client_list" class="table" >
                        <thead>
                        <tr>
                            <th width="3%;">#</th>
                            <th width="15%">رقم الفاتورة</th>
                            <th width="30%">اسم العميل</th>
                            <th width="10%">الإجمالي</th>
                            <th width="10%">مدفوع؟</th>
                            <th width="15%">حتى تاريخ</th>
                            <th width="5%">الحالة</th>
                            <th width="5%;">العمليات</th>
                        </tr>
                        </thead>

                    </table>

                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>

    <!-- /page content end  -->
    <div class="modal fade" id="modal-common" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="show_modal">

            </div>
        </div>
    </div>


@endsection


@push('js')


    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">

    <input type="hidden" name="invoice-list"
           id="invoice-list"
           value="{{ url('admin/invoice-list') }}">

    <script src="{{asset('assets/js/invoice/invoice-datatable.js')}}"></script>

@endpush
