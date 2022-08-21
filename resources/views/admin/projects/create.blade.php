@extends('admin.layout.app')
@section('title','المشاريع')
@push('style')
    <link href="{{ asset('assets/admin/Image-preview/dist/css/bootstrap-imageupload.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/jcropper/css/cropper.min.css') }}" rel="stylesheet">

    <style>
        .d-none {
            display: none;
        }
    </style>
@endpush
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>@lang('panel.Add Member')</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ url('admin/client_user') }}" class="btn btn-primary">{{ __('constants.back') }}</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <div class="x_content">
                    <form id="add_user" name="add_user" role="form" method="POST"
                          action="{{ isset($item) ? route('projects.update' , $item->id ) : route('projects.store')}}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @if(isset($item))
                            @method('PUT')
                        @endif
                        <input type="hidden" id="imagebase64" name="imagebase64">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>عذرًا!</strong> كانت هناك بعض المشاكل في المدخلات الخاصة بك.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">

                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <label for="fullname">اسم المشروع <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                               value="{{ isset($item) ? @$item->name : '' }}"
                                               placeholder="اسم المشروع ">
                                    </div>


                                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                        <label for="fullname">صاحب المشروع<span class="text-danger">*</span></label>
                                        <select class="form-control" name="client_id" id="advocate_client_id">
                                            <option value="">إختر عميل</option>
                                            @foreach($client_list as $list)
                                                <option value="{{ $list->id}}"
                                                    {{ isset($item) && isset($item->client_id ) && $item->client_id == $list->id ? 'selected' :'' }} >{{  $list->name }}</option>
                                            @endforeach
                                            <option value="others"
                                                {{ isset($item) && is_null($item->client_id) ? 'selected':'' }}>
                                                المدعي خارجي
                                            </option>
                                        </select>

                                    </div>
                                    <div
                                        class="col-md-6 col-sm-12 col-xs-12 form-group {{ isset($item) && is_null($item->client_id) ? '':'d-none' }} "
                                        id="external_client">
                                        <label for="fullname">صاحب المشروع ( الخارجي )<span class="text-danger">*</span></label>
                                        <input type="text" name="client_other_name" class="form-control"
                                               value="{{ isset($item) ? @$item->owner_name : '' }}"
                                               placeholder="صاحب المشروع ( الخارجي )">
                                    </div>


                                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                        <label for="fullname">العقود<span class="text-danger">*</span></label>
                                        <select class="form-control" name="contracts[]" id="contracts" multiple>
                                            @foreach($contracts as $contract)
                                                <option value="{{ $contract->id}}"
                                                    {{ isset($item) && in_array($contract->id , $item->contract->pluck('id')->toArray())? 'selected' : '' }}>{{  '#'.$contract->id }}</option>
                                            @endforeach
                                        </select>

                                    </div>


                                </div>


                            </div>
                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">


                                    <a class="btn btn-danger" href="{{route('projects.index')}}">الغاء</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                                                                     id="show_loader"></i>حفظ
                                    </button>
                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">
    <input type="hidden" name="check_user_email_exits"
           id="check_user_email_exits"
           value="{{ url('admin/check_user_email_exits') }}">
@endsection
@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{ asset('assets/admin/jcropper/js/cropper.min.js') }}"></script>
    <script src="{{asset('assets/js/team_member/member-validation.js')}}"></script>

    <script>
        $("#contracts").select2({
            allowClear: true,
            placeholder: 'حدد المشاريع',
            multiple: true
        });

        $(document).on('change', 'select[name=client_id]', function (e) {
            e.preventDefault();
            if ($(this).val() == "others") {
                $('#external_client').removeClass('d-none');
            } else {
                $('#external_client').addClass('d-none');
            }
        })
    </script>
@endpush
