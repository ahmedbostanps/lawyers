@extends('admin.layout.app')
@section('title',__('panel.Roles'))
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => 'الصلاحيات',
             'action'=>route("role.create"),
             'model_title'=>'إضافة صلاحية',
             'modal_id'=>'#addtag',
              'permission' => '1'
             ] )
        {{ __('panel.Role') }}
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="roleDataTable" class="table" data-url="{{ route('role.list') }}" >
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>الصلاحية</th>
                                <th width="2%" data-orderable="false">عمليات</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>
@endsection
@push('js')
    <script src="{{asset('assets/js/role/role-datatable.js')}}"></script>
@endpush
