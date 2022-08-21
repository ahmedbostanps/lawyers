@extends('admin.layout.app')
@section('title','إضافة قضية')


@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>إضافة قضية</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{route('case-running.index')}}" class="btn btn-primary">رجوع</a>

            </div>
        </div>
    </div>
    <!------------------------------------------------ ROW 1-------------------------------------------- -->


    <form method="post" name="add_case" id="add_case" action="{{route('case-running.store')}}" class="">
        @csrf()
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تفاصيل المدعي</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
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
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">المدعي <span class="text-danger">*</span></label>
                                <select class="form-control" name="client_name" id="client_name">
                                    <option value="">إختر عميل</option>
                                    @foreach($client_list as $list)
                                        <option value="{{ $list->id}}">{{  $list->name }}</option>
                                    @endforeach
                                    <option value="others">المدعي خارجي</option>
                                </select>

                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">المدعي ( الخارجي )<span class="text-danger">*</span></label>
                                <input type="text" name="client_other_name" class="form-control" placeholder="المدعي ( الخارجي )">
                            </div>
{{--                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">--}}
{{--                                <br><br>--}}
{{--                                <input type="radio" id="test1" name="position" value="Petitioner" checked>&nbsp;&nbsp;Petitioner--}}
{{--                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
{{--                                <input type="radio" id="test2" name="position" value="Respondent">&nbsp;&nbsp;Respondent--}}
{{--                            </div>--}}
                        </div>


                        <div class="repeater">
                            <div data-repeater-list="parties_detail">
                                <div data-repeater-item>
                                    <div class="row">

                                        <div class="col-md-6">


                                            <div class="form-group">
                                                <label class="discount_text "> <b class="position_name">المستجيب</b><span class="text-danger">*</span></label>
                                                <input type="text" id="party_name" name="party_name"
                                                       data-rule-required="true" data-msg-required="Please enter name."
                                                       class="form-control">
                                            </div>


                                        </div>

                                        <div class="col-md-5">

                                            <div class="form-group">
                                                <label class="discount_text "><b class="position_advo">محامي المستجيب</b><span class="text-danger">*</span></label>
                                                <input type="text" id="party_advocate" name="party_advocate"
                                                       data-rule-required="true"
                                                       data-msg-required="Please enter advocate name."
                                                       class="form-control">
                                            </div>


                                        </div>

                                        <div class="col-md-1">

                                            <div class="form-group">

                                                <div class="case-margin-top-23"></div>
                                                <button type="button" data-repeater-delete type="button"
                                                        class="btn btn-danger waves-effect waves-light"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </div>


                                        </div>


                                    </div>

                                    <br>
                                </div>
                            </div>
                            <button data-repeater-create type="button" value="Add New"
                                    class="btn btn-success waves-effect waves-light btn btn-success-edit" type="button">
                                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;إضافة
                            </button>
                        </div>


                    </div>
                </div>

            </div>

        </div>
        <!------------------------------------------------------- End ROw --------------------------------------------->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تفاصيل القضية</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">رقم القضية <span class="text-danger">*</span></label>
                                <input type="text" id="case_no" name="case_no" class="form-control">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">نوع القضية <span class="text-danger">*</span></label>
                                <select class="form-control" id="case_type" name="case_type"
                                        onchange="getCaseSubType(this.value);">
                                    <option value="">Select case type</option>
                                    @foreach($caseTypes as $caseType)
                                        <option value="{{$caseType->id}}">{{$caseType->case_type_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">النوع الفرعي للقضية <span class="text-danger"></span></label>
                                <select class="form-control" id="case_sub_type" name="case_sub_type"></select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">مرحلة القضية <span class="text-danger">*</span></label>
                                <select class="form-control" id="case_status" name="case_status">
                                    <option value="">اختر مرحلة القضية</option>
                                    @foreach($caseStatuses as $caseStatus)
                                        <option value="{{$caseStatus->id}}">{{$caseStatus->case_status_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <br><br>
                                <input type="radio" id="test3" style="margin: 0 5px;" name="priority" value="High">عالٍ
                                <input type="radio" id="test4" style="margin: 0 5px;" name="priority" value="Medium" checked>متوسط
                                <input type="radio" id="test5"style="margin: 0 5px;"  name="priority" value="Low">قليل
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">يمثل <span class="text-danger">*</span></label>
                                <input type="text" id="act" name="act" class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">رقم الايداع <span class="text-danger">*</span></label>
                                <input type="text" id="filing_number" name="filing_number" class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">تاريخ الايداع <span class="text-danger">*</span></label>
                                <input type="date" id="filing_date" name="filing_date"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">رقم التسجيل <span class="text-danger">*</span></label>
                                <input type="text" id="registration_number" name="registration_number"
                                       class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">تاريخ التسجيل <span class="text-danger">*</span></label>
                                <input type="date" name="registration_date"
                                       class="form-control">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">تاريخ الجلسة الأولى <span class="text-danger">*</span></label>
                                <input type="date"   name="next_date"
                                       class="form-control" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">رقم CNR <span class="text-danger"></span></label>
                                <input type="text" id="cnr_number" name="cnr_number" class="form-control">
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">وصف <span class="text-danger"></span></label>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2> تفاصيل المحضر</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">قسم الامن <span class="text-danger"></span></label>
                                <input type="text" id="police_station" name="police_station" class="form-control">
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">رقم المحضر <span class="text-danger"></span></label>
                                <input type="text" id="fir_number" name="fir_number" class="form-control">
                            </div>


                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname"> تاريخ المحضر <span class="text-danger"></span></label>
                                <input type="text" id="fir_date" name="fir_date"
                                       class="form-control datetimepickerregdate" readonly="">
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تفاصيل المحكمة</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">رقم المحكمة <span class="text-danger">*</span></label>
                                <input type="text" id="court_no" name="court_no" class="form-control">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">نوع المحكمة<span class="text-danger">*</span></label>
                                <select class="form-control" id="court_type" name="court_type"
                                        onchange="getCourt(this.value);">
                                    <option value="">حدد نوع المحكمة</option>
                                    @foreach($courtTypes as $courtType)
                                        <option value="{{$courtType->id}}">{{$courtType->court_type_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">محكمة <span class="text-danger">*</span></label>
                                <select class="form-control" id="court_name" name="court_name"></select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">نوع القاضي <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="judge_type" name="judge_type">
                                    <option value="">حدد نوع القاضي</option>
                                    @foreach($judges as $judge)
                                        <option value="{{$judge->id}}">{{$judge->judge_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">اسم القاضي <span class="text-danger"></span></label>
                                <input type="text" id="judge_name" name="judge_name" class="form-control">
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">ملاحظات <span class="text-danger"></span></label>
                                <textarea id="remarks" name="remarks" class="form-control"></textarea>

                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>تعيين مهمة</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div class="repeater">
                            <div data-repeater-list="tasks">
                                <div data-repeater-item>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="discount_text "> <b class="position_name">المستخدمون</b><span class="text-danger">*</span></label>
                                                <select multiple class="form-control" name="assigned_to">
                                                    @foreach($users as $key=>$val)
                                                        <option value="{{$val->id}}">{{$val->first_name.' '.$val->last_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="fullname">العنوان <span class="text-danger">*</span></label>
                                                <input type="text" placeholder="" class="form-control" id="task_subject"
                                                       name="task_subject">
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <label for="fullname">تاريخ البدء <span class="text-danger">*</span></label>
                                            <input type="date" placeholder="" class="form-control" id="start_date"
                                                   name="start_date">
                                            {{--                                readonly=""--}}
                                        </div>

                                        <div class="col-md-3 col-xs-12 form-group">
                                            <label for="fullname">الموعد الأخير<span class="text-danger">*</span></label>
                                            <input type="date" placeholder="" class="form-control" id="end_date"
                                                   name="end_date">
                                            {{--                                readonly=""--}}
                                        </div>


                                        <div class="col-md-1">

                                            <div class="form-group">

                                                <div class="case-margin-top-23"></div>
                                                <button type="button" data-repeater-delete type="button"
                                                        class="btn btn-danger waves-effect waves-light"><i
                                                        class="fa fa-trash-o" aria-hidden="true"></i></button>
                                            </div>


                                        </div>


                                    </div>

                                    <br>
                                </div>
                            </div>
                            <button data-repeater-create type="button" value="Add New"
                                    class="btn btn-success waves-effect waves-light btn btn-success-edit" type="button">
                                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;إضافة
                            </button>
                        </div>



                    </div>
                </div>

            </div>


            <div class="form-group pull-right">
                <div class="col-md-12 col-sm-6 col-xs-12">


                    <a class="btn btn-danger" href="{{route('case-running.index')}}">الغاء</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save" id="show_loader"></i>حفظ
                    </button>
                </div>

            </div>
            <br>

        </div>
    </form>
    <input type="hidden" name="date_format_datepiker"
           id="date_format_datepiker"
           value="{{$date_format_datepiker}}">

    <input type="hidden" name="getCaseSubType"
           id="getCaseSubType"
           value="{{ url('getCaseSubType')}}">

    <input type="hidden" name="getCourt"
           id="getCourt"
           value="{{ url('getCourt')}}">
@endsection

@push('js')

    <script src="{{asset('assets/js/case/case-add-validation.js')}}"></script>
    <script src="{{asset('assets/admin/js/repeter/repeater.js') }}"></script>

@endpush
