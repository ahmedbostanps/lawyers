@extends('admin.layout.app')
@section('title',__('panel.database_backup'))
@section('content')
   <div class="">

      <div class="page-title">
              <div class="title_left">
                <h3>Database Backup</h3>
              </div>
              <div class="title_right">
                <div class="form-group pull-right top_search">

                      <a href="{{ url('admin/database-backups') }}" class="btn btn-primary "><i class="fa fa-database"></i>
                          {{ __('panel.database_backup') }}</a>


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
   <div id="load-modal"></div>
@endsection

@push('js')


    <script src="{{asset('js/datatable.js')}}"></script>
    <script>
        window.data_url = "{{route('database-backup.list')}}";
        window.columns = [
            {
                "data": "id",
                'title': "#",
                "width": "5%",
                "orderable": false
            },
            {
                "data": "date",
                'title': "{{ __('constants.date') }}",
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
