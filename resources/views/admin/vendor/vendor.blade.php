@extends('admin.layout.app')
@section('title','الزبائن')
@section('content')
    <div class="">
        @component('component.heading' , [

  'page_title' => 'الزبائن',
  'action' => route('vendor.create') ,
  'text' => 'إضافة زبون',
   'permission' => $adminHasPermition->can(['vendor_add'])
   ])
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="Vendordatatable" class="table"
                               data-url="{{ route('vendor.list') }}">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th width="40%">الإسم</th>
                                <th width="40%">رقم الهاتف</th>
                                <th data-orderable="false">الحالة</th>
                                <th data-orderable="false">العمليات</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('assets/js/vendor/vendor-datatable.js')}}"></script>
@endpush
