@extends('admin.layout.app')
@section('title','أضف موعد')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>أضف موعد</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ route('appointment.index') }}" class="btn btn-primary">رجوع</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <div class="x_content">
                    <form id="add_appointment" name="add_appointment" role="form" method="POST"
                          action="{{route('appointment.store')}}" enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="x_content">

                                <div class="row">
                                    <div class="form-group col-md-6">

                                        <input type="radio" id="test5" value="new" name="type" checked>

                                        <b> عميل جديد</b>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <input type="radio" id="test4" value="exists" name="type">

                                        <b> عميل موجود</b>

                                    </div>
                                </div>
                                <br>
                                <div class="row exists">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            @if(!empty($client_list) && count($client_list)>0)
                                                <label class="discount_text">حدد العميل
                                                    <er class="rest">*</er>
                                                </label>
                                                <select class="form-control selct2-width-100" name="exists_client"
                                                        id="exists_client"
                                                        onchange="getMobileno(this.value);">
                                                    <option value="">حدد العميل</option>
                                                    @foreach($client_list as $list)
                                                        <option value="{{ $list->id}}">{{  $list->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            @endif


                                        </div>

                                    </div>
                                </div>


                                <div class="row new">
                                    <div class="col-md-12 form-group">
                                        <label for="newclint_name">اسم العميل الجديد <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" placeholder="" class="form-control" id="new_client"
                                               name="new_client" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="mobile">رقم الهاتف <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="" class="form-control" id="mobile" name="mobile"
                                               autocomplete="off" maxlength="10">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="date">التاريخ <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="date" name="date">


                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="time">الوقت <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="time" name="time">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="note">ملاحظات</label>
                                        <textarea type="text" placeholder="" class="form-control" id="note"
                                                  name="note"></textarea>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a href="{{ route('appointment.index') }}" class="btn btn-danger">إلغاء</a>
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
    </div>
    <input type="hidden" name="date_format_datepiker"
           id="date_format_datepiker"
           value="{{$date_format_datepiker}}">

    <input type="hidden" name="getMobileno"
           id="getMobileno"
           value="{{ route('getMobileno') }}">
@endsection

@push('js')
    <script src="{{asset('assets/admin/appointment/appointment.js') }}"></script>
    <script src="{{asset('assets/js/appointment/appointment-validation.js')}}"></script>
@endpush
