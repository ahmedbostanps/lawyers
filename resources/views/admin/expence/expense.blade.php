@extends('admin.layout.app')
@section('title','النفقات')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>النفقات</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">

                @if($adminHasPermition->can(['expense_add']))
                    <a href="{{ url('admin/expense-create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> اضافة نفقات</a>
                @endif


            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">

                    <table id="ExpenseDatatable" class="table" >
                        <thead>
                        <tr>

                            <th width="3%;">#</th>
                            <th width="15%">رقم الفاتورة</th>
                            <th width="30%">البائع</th>
                            <th width="10%">المجموع</th>
                            <th width="10%">مدفوع</th>
                            <th width="15%">مستحق</th>
                            <th width="5%">الحالة</th>
                            <th width="5%;">عمليات</th>

                        </tr>
                        </thead>


                    </table>
                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>

    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">

    <input type="hidden" name="expense-list"
           id="expense-list"
           value="{{ url('admin/expense-list') }}">

@endsection

@push('js')
    <script src="{{asset('assets/js/expense/expense-datatable.js')}}"></script>
@endpush

