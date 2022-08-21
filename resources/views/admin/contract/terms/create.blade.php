@extends('admin.layout.app')
@section('title','Add Term')
@section('content')
    @component('component.heading' , [
    'page_title' => __('panel.Add Terms'),
    'action' => route('contracts_terms.index') ,
    'text' => __('panel.Bank')
     ])
    @endcomponent
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
{{--            @include('component.error')--}}
            <div class="x_panel">
                <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope"
                      action="{{ isset($item) ? route('contracts_terms.update' , $item->id) : route('contracts_terms.store') }}">
                    @isset($item)
                    @method('PATCH')
                    @endisset
                    {{ csrf_field() }}
                    <div class="x_content">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>خطأ !</strong> خطأ في المدخلات<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">@lang('panel.Category') <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control">
                                    <option value="">إختر</option>
                                    @foreach($contract_categories as $key => $row)
                                    <option value="{{ $key }}" {{ isset($item) && $item->category_id == $key ? 'selected' : '' }}>{{ $row }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">@lang('panel.Name') <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" value="{{ isset($item) ? $item->name : '' }}" class="form-control" id="name" name="name">
                            </div>
                        </div>



                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <a href="{{ route('contracts_terms.index')  }}" class="btn btn-danger">@lang('panel.Cancel')</a>
                                <input type="hidden" name="route-exist-check"
                                       id="route-exist-check"
                                       value="{{ url('admin/check_client_email_exits') }}">
                                <input type="hidden" name="token-value"
                                       id="token-value"
                                       value="{{csrf_token()}}">

                                <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                                                                 id="show_loader"></i>&nbsp;@lang('panel.Save')
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
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{asset('assets/admin/vendors/repeter/repeater.js')}}"></script>
    <script src="{{asset('assets/admin/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{asset('assets/js/contract_term/add-contract-term-validation.js')}}"></script>
@endpush
