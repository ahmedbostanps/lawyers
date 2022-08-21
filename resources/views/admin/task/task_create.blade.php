@extends('admin.layout.app')
@section('title','إضافة مهمة')
@section('content')
    @component('component.heading' , [

    'page_title' => 'إضافة مهمة',
    'action' => route('tasks.index') ,
    'text' => 'Back'
     ])
    @endcomponent
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope"
                      action="{{route('tasks.store')}}">
                    {{ csrf_field() }}
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">العنوان <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="task_subject"
                                       name="task_subject">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">تاريخ البدء <span class="text-danger">*</span></label>
                                <input type="date" placeholder="" class="form-control" id="start_date"
                                       name="start_date">
{{--                                readonly=""--}}
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">الموعد الأخير<span class="text-danger">*</span></label>
                                <input type="date" placeholder="" class="form-control" id="end_date"
                                       name="end_date">
{{--                                readonly=""--}}
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">حدد الحالة: <span class="text-danger">*</span></label>
                                <select class="form-control" id="project_status_id" name="project_status_id">
                                    <option value="">حدد الحالة</option>
                                    @foreach(LogActivity::getTaskStatusList()  as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">الأولوية <span class="text-danger">*</span></label>
                                <select class="form-control" id="priority" name="priority">
                                    <option value="">حدد الأولوية</option>
                                    @foreach(LogActivity::getTaskPriorityList() as $key=>$val)
                                        <option value="{{$key}}"
                                        >{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">يسند إلى<span class="text-danger">*</span></label>

                                <select multiple class="form-control" id="assigned_to" name="assigned_to[]">
                                    <option value="">حدد مستخدم</option>
                                    @foreach($users as $key=>$val)
                                        <option value="{{$val->id}}">{{$val->first_name.' '.$val->last_name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">متعلق ب</label>
                                <select class="form-control selct2-width-100" id="related" name="related">
                                    <option value="">لا شيء محدد</option>
                                    <option value="case">قضية</option>
                                    <option value="other">آخر</option>
                                </select>
                            </div>


                            <div class="col-md-4 col-sm-12 col-xs-12 form-group task_selection hide">
                                <label for="fullname">القضية</label>
                                <select class="form-control selct2-width-100" id="related_id" name="related_id">
                                    <option value="">حدد القضية</option>

                                </select>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">وصف:</label>
                                <textarea class="form-control" id="task_description"
                                          name="task_description"></textarea>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <a class="btn btn-danger" href="{{ route('tasks.index') }}">إلغاء</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                                                                 id="show_loader"></i>&nbsp;حفظ
                                </button>
                            </div>
                        </div>


                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <input type="hidden" name="select2Case"
           id="select2Case"
           value="{{route('select2Case') }}">

    <input type="hidden" name="date_format_datepiker"
           id="date_format_datepiker"
           value="{{$date_format_datepiker}}">
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{asset('assets/js/task/task-validation.js')}}"></script>
@endpush
