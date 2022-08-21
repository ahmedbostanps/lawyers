@extends('admin.layout.app')
@section('title','إضافة زبون')
@section('content')
    @component('component.heading' , [

        'page_title' => 'إضافة زبون',
        'action' => route('vendor.index') ,
        'text' => 'Back'
         ])
    @endcomponent

    <div class="row">
        <form id="add_vendor" name="add_vendor" role="form" method="POST" action="{{route('vendor.store')}}"
              enctype="multipart/form-data">
            @csrf()

            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('component.error')
                <div class="x_panel">

                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="company_name">اسم الشركة <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" name="company_name"
                                       id="company_name">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="f_name">{{ __('panel.First Name') }} <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="f_name" name="f_name">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="l_name">{{ __('panel.Last Name') }} <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="l_name" name="l_name">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="email">{{ __('constants.email') }} <span class="text-danger"></span></label>
                                <input type="email" placeholder="" class="form-control" id="email" name="email">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="mobile">{{ __('constants.mobile') }}. <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="mobile" name="mobile"
                                       data-rule-required="true"
                                       data-rule-number="true"
                                       data-msg-required="رقم الجوال مطلوب"
                                       data-rule-minlength="10"
                                       data-rule-maxlength="10">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="alternate_no">الرقم البديل<span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="alternate_no"
                                       name="alternate_no"
                                       data-rule-required="false"
                                       data-rule-number="true"
                                       data-rule-minlength="10"
                                       data-rule-maxlength="10">
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="address">{{ __('panel.Address') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="address" name="address"
                                       data-rule-required="true" data-msg-required="العنوان مطلوب">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="country">{{ __('panel.Country') }} <span class="text-danger">*</span></label>
                                <select class="form-control select-change country-select2" data-rule-required="true"
                                        data-msg-required="الرجاء تحديد الدولة" name="country"
                                        id="country"
                                        data-url="{{ route('get.country') }}"
                                        data-clear="#city_id,#state"
                                >
                                    <option value=""> {{ __('panel.Select Country') }}</option>

                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="state">{{ __('panel.State') }} <span class="text-danger">*</span></label>
                                <select id="state" name="state"

                                        data-url="{{ route('get.state') }}"
                                        data-target="#country"
                                        data-clear="#city_id"
                                        class="form-control state-select2 select-change" data-rule-required="true"
                                        data-msg-required=" الرجاء تحديد الولاية">
                                    <option value=""> {{ __('panel.Select State') }}</option>


                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="city">{{ __('panel.City') }} <span class="text-danger">*</span></label>
                                <select id="city_id" name="city_id"
                                        data-url="{{ route('get.city') }}"
                                        data-target="#state"
                                        class="form-control city-select2" data-rule-required="true"
                                        data-msg-required=" الرجاء تحديد المدينة">
                                    <option value=""> {{ __('panel.Select City') }}</option>


                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="gst">GSTIN </label>
                                <input type="text" placeholder="" class="form-control" id="gst" name="gst">
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="pan">PAN</label>
                                <input type="text" placeholder="" class="form-control" id="pan" name="pan">
                            </div>


                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a href="{{ route('vendor.index') }}" class="btn btn-danger">{{ __('panel.Cancel') }}</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                                                                     id="show_loader"></i>&nbsp;{{ __('panel.Save') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection
@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{asset('assets/admin/vendor/vendor.js') }}"></script>
@endpush
