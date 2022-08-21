@extends('admin.layout.app')
@section('title','نعديل زبون')
@section('content')
    @component('component.heading' , [
        'page_title' => 'نعديل زبون',
        'action' => route('vendor.index') ,
        'text' => 'Back'
         ])
    @endcomponent

    <div class="row">
        <form id="add_vendor" name="add_vendor" role="form" method="POST"
              action="{{route('vendor.update',$client->id)}}" enctype="multipart/form-data">
            <input type="hidden" id="id" value="{{ $client->id ?? ''}}" name="id">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PATCH">

            <div class="col-md-12 col-sm-12 col-xs-12">
                @include('component.error')
                <div class="x_panel">

                    <div class="x_content">

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="company_name">إسم الشركة <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" name="company_name"
                                       id="company_name" value="{{ $client->company_name ?? '' }}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="f_name">{{ __('panel.First Name') }} <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="f_name" name="f_name"
                                       value="{{ $client->first_name ?? ''}}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="l_name">{{ __('panel.Last Name') }} <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="l_name" name="l_name"
                                       value="{{ $client->last_name ?? ''}}">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="email">{{ __('panel.Email') }} <span class="text-danger"></span></label>
                                <input type="email" placeholder="" class="form-control" id="email" name="email"
                                       value="{{ $client->email ?? ''}}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="mobile">{{ __('panel.Mobile No') }}. <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="mobile" name="mobile"
                                       data-rule-required="true" data-rule-number="true"
                                       data-msg-required="رقم الجوال مطلوب" data-rule-maxlength="10"
                                       value="{{ $client->mobile ?? ''}}" maxlength="10">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="alternate_no">الرقم البديل<span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="alternate_no"
                                       name="alternate_no" value="{{ $client->alternate_no ?? ''}}">
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <label for="address">{{ __('panel.Address') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="address" name="address"
                                       data-rule-required="true" data-msg-required="العنوان مطلوب "
                                       value="{{ $client->address ?? ''}}">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="country">{{ __('panel.Country') }} <span class="text-danger">*</span></label>
                                <select class="form-control select-change country-select2" data-rule-required="true"
                                        data-msg-required=" الرجاء تحديد الدولة"  name="country"
                                        id="country"
                                        data-url="{{ route('get.country') }}"
                                        data-clear="#city_id,#state"
                                >
                                    <option value=""> {{ __('panel.Select Country') }}</option>
                                    @if($client->country)
                                        <option value="{{ $client->country->id }}"
                                                selected=""> {{ $client->country->name  }} </option>

                                    @endif

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
                                    @if($client->state)
                                        <option value="{{ $client->state->id }}"
                                                selected=""> {{ $client->state->name  }} </option>

                                    @endif


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
                                    @if($client->city)
                                        <option value="{{ $client->city->id }}"
                                                selected=""> {{ $client->city->name  }} </option>

                                    @endif

                                </select>
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="gst">GSTIN </label>
                                <input type="text" placeholder="" class="form-control" id="gst" name="gst"
                                       value="{{ $client->gst ?? ''}}">
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="pan">PAN</label>
                                <input type="text" placeholder="" class="form-control" id="pan" name="pan"
                                       value="{{ $client->pan ?? ''}}">
                            </div>


                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a href="{{ route('vendor.index') }}" class="btn btn-danger">{{ __('panel.Cancel') }}</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                                                                     id="show_loader"></i>&nbsp;{{ __('panel.save') }}
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
