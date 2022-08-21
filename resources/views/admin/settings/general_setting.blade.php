@extends('admin.layout.app')
@section('title',__('panel.general_setting'))
@push('style')

@endpush
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>{{ __('panel.general_setting') }}</h3>
        </div>


        <div class="title_right">
            <div class="form-group pull-right top_search">
            </div>
        </div>
    </div>

        <div class="clearfix"></div>
    <form id="mail_setup" name="mail_setup" role="form" method="POST"
          action="{{ route('general-setting.update',$GeneralSettings->id) }}" enctype="multipart/form-data"
          autocomplete="off">
        @csrf()
        <input type="hidden" name="_method" value="PATCH">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        @include('admin.settings.setting-header')


                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">

                            </div>


                        </div>


                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="invoice_prefex">{{ __('panel.company_name') }} <span class="text-danger">*</span></label>
                                <input type="text" required data-msg-required="Please enter company name" placeholder=""
                                       class="form-control" id="cmp_name" name="cmp_name"
                                       value="{{ $GeneralSettings->company_name }}">
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="invoice_number">{{ __('panel.Address') }} <span class="text-danger">*</span></label>
                                <input type="text" data-msg-required="الرجاء إدخال العنوان" placeholder=""
                                       class="form-control" id="address" name="address" required
                                       value="{{ $GeneralSettings->address }}">
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="invoice_number">{{ __('panel.Country') }} <span class="text-danger">*</span></label>
                                <select data-msg-required="الرجاء تحديد الدولة" required=""
                                        class="form-control select-change country-select2 selct2-width-100"
                                        name="country" id="country"
                                        data-url="{{ route('get.country') }}"
                                        data-clear="#city_id,#state"
                                >
                                    <option value=""> {{ __('panel.Select Country') }}</option>
                                    @foreach ($countrys as $country)
                                        <option
                                            value="{{ $country->id }}" {{$GeneralSettings->country== $country->id ? 'selected' : '' }}
                                        >{{ $country->name }}</option>

                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="invoice_number">{{ __('panel.State') }} <span class="text-danger">*</span></label>
                                <select data-msg-required="الرجاء تحديد الولاية" required="" id="state" name="state"

                                        data-url="{{ route('get.state') }}"
                                        data-target="#country"
                                        data-clear="#city_id"
                                        class="form-control state-select2 select-change">
                                    <option value=""> {{ __('panel.Select State') }}</option>
                                    @foreach ($states as $state)
                                        <option
                                            value="{{ $state->id }}" {{$GeneralSettings->state== $state->id ? 'selected' : '' }}
                                        >{{ $state->name }}</option>

                                    @endforeach


                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="invoice_number">{{ __('panel.City') }} <span class="text-danger">*</span></label>
                                <select data-msg-required="الرجاء تحديد المدينة" required="" id="city_id" name="city_id"
                                        data-url="{{ route('get.city') }}"
                                        data-target="#state"

                                        class="form-control city-select2">
                                    <option value=""> {{ __('panel.Select City') }}</option>
                                    @foreach ($citys as $city)
                                        <option
                                            value="{{ $city->id }}" {{$GeneralSettings->city== $city->id ? 'selected' : '' }}
                                        >{{ $city->name }}</option>

                                    @endforeach


                                </select>
                            </div>


                        </div>
                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="invoice_number">الرمز السري <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" data-msg-required="الرجاء إدخال الرمز السري"
                                       class="form-control" id="pincode" name="pincode" required
                                       value="{{ $GeneralSettings->pincode }}">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <div class="valfavicon">
                                    <label for="invoice_number">الأيقونة  </label>

                                    <input type="file" name="favicon" id="favicon" class="form-control"
                                           data-min-width="16" data-min-height="16" data-max-width="16"
                                           data-max-height="16">
                                    <span class="text-danger">(ملاحظة: يجب أن يكون حجم الصورة 16 عرضًا و 16 ارتفاعًا)</span>
                                    @if($image_logo->favicon_img!='')
                                        <br>
                                        <br>

                                        <img height="26" width="30"
                                             src="{{asset('public/'.config('constants.FAVICON_FOLDER_PATH') .'/'. $GeneralSettings->favicon_img)}}">
                                    @endif
                                </div>


                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <div class="vallogo">

                                    <label for="invoice_number">شعار </label>
                                    <input type="file" placeholder="" class="form-control" id="logo" name="logo"
                                           data-min-width="230" data-min-height="46" data-max-width="230"
                                           data-max-height="46">
                                    <span class="text-danger"> (ملاحظة: يجب أن يكون حجم الصورة 230 عرضًا و 46 ارتفاعًا)</span>
                                    @if($GeneralSettings->logo_img!='')
                                        <br>
                                        <br>
                                        <img height="46" width="230"
                                             src="{{asset('public/'.config('constants.LOGO_FOLDER_PATH') .'/'. $GeneralSettings->logo_img)}}">
                                    @endif
                                </div>
                            </div>


                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <button type="submit" class="btn btn-success" name="btn_add_smtp"><i
                                            class="fa fa-save"
                                            id="show_loader"></i>&nbsp;{{ __('panel.save') }}
                                    </button>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{asset('assets/admin/js/jquery.checkImageSize.js')}}"></script>
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>
    <script src="{{asset('assets/js/settings/general-setting-validation.js')}}"></script>
@endpush
