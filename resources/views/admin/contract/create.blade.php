@extends('admin.layout.app')
@section('title','Add Term')
@section('content')
    @component('component.heading' , [
    'page_title' => 'إضافة عقد',
    'action' => route('contracts.index') ,
    'text' => __('panel.Bank')
     ])
    @endcomponent
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope"
                      action="{{ isset($item) ? route('contracts.update' , $item->id) : route('contracts.store') }}">
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
                            <div class="col-12 mb-4" style="margin-bottom: 80px">
                                <h5>بيانات الطرف الأول</h5>
                                <div class="repeater one">
                                    <div data-repeater-list="group-a">
                                        @if(isset($item) && count($contract_client_first_side))
                                            @foreach($contract_client_first_side as $row_client)
                                                <div data-repeater-item>
                                                    <div class="row border-addmore"
                                                    >
                                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                            <label for="fullname">العميل <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="client_id" data-rule-required="true"
                                                                    class="form-control">
                                                                <option value="">إختر</option>
                                                                @foreach($clients as $key => $row)
                                                                    <option
                                                                        value="{{ $row->id }}" {{ $row_client->client_id  == $row->id ? 'selected' : '' }}>{{ $row->first_name . ' ' . $row->last_name }}</option>

                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="type" value="first_side">
                                                        </div>


                                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                            <br>
                                                            <button type="button" data-repeater-delete type="button"
                                                                    class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                              aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endforeach
                                        @else
                                            <div data-repeater-item>
                                                <div class="row border-addmore"
                                                >
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">العميل <span
                                                                class="text-danger">*</span></label>
                                                        <select name="client_id" data-rule-required="true"
                                                                class="form-control">
                                                            <option value="">إختر</option>
                                                            @foreach($clients as $key => $row)
                                                                <option
                                                                    value="{{ $row->id }}">{{ $row->first_name . ' ' . $row->last_name }}</option>

                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="type" value="first_side">
                                                    </div>


                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <br>
                                                        <button type="button" data-repeater-delete type="button"
                                                                class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                          aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <br>
                                        <button data-repeater-create type="button" value="Add New"
                                                class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                                type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4" style="margin-bottom: 80px">
                                <h5>بيانات الطرف الثاني</h5>
                                <div class="repeater two">
                                    <div data-repeater-list="group-b">
                                        @if(isset($item) && count($contract_client_second_side))
                                            @foreach($contract_client_second_side as $row_client)
                                                <div data-repeater-item>
                                                    <div class="row border-addmore"
                                                    >
                                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                            <label for="fullname">العميل <span
                                                                    class="text-danger">*</span></label>
                                                              <select name="client_id" data-rule-required="true"
                                                                    class="form-control">
                                                                <option value="">إختر</option>
                                                                @foreach($clients as $key => $row)
                                                                    <option
                                                                        value="{{ $row->id }}" {{ $row_client->client_id  == $row->id ? 'selected' : '' }}>{{ $row->first_name . ' ' . $row->last_name }}</option>

                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="type" value="second_side">
                                                        </div>


                                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                            <br>
                                                            <button type="button" data-repeater-delete type="button"
                                                                    class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                              aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div data-repeater-item>
                                                <div class="row border-addmore"
                                                >
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">العميل <span
                                                                class="text-danger">*</span></label>
                                                         <select name="client_id" data-rule-required="true"
                                                                class="form-control">
                                                            <option value="">إختر</option>
                                                            @foreach($clients as $key => $row)
                                                                <option
                                                                    value="{{ $row->id }}">{{ $row->first_name . ' ' . $row->last_name }}</option>

                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="type" value="second_side">
                                                    </div>


                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <br>
                                                        <button type="button" data-repeater-delete type="button"
                                                                class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                          aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <br>
                                        <button data-repeater-create type="button" value="Add New"
                                                class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                                type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4" style="margin-bottom: 80px">
                                <h5>بنود العقد</h5>
                                <div class="repeater three">
                                    <div data-repeater-list="group-c">
                                        @if(isset($item) && count($contract_client_terms))
                                            @foreach($contract_client_terms as $row_category)
                                                <div data-repeater-item>
                                                    <div class="row border-addmore"
                                                    >
                                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                            <label for="fullname">التصنيف <span
                                                                    class="text-danger">*</span></label>

                                                            <select name="category_term_id" data-rule-required="true"
                                                                    class="form-control category_term_id"
                                                                    data-action="{{ route('contracts.get.terms.by.category') }}">
                                                                <option value="">إختر</option>
                                                                @foreach($contract_categories as $key => $row)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($item) && $row_category->term_category_id == $key ? 'selected' : '' }}>{{ $row }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                            <br>
                                                            <button type="button" data-repeater-delete type="button"
                                                                    class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                              aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                        <div class="inner-repeater col-md-12">
                                                            <div class="row" data-repeater-list="inner-list">
                                                               @if(count($row_category->get_terms()))
                                                                    @foreach($row_category->get_terms() as $row_term)
                                                                        {{--                                                                        {{ $row_term[id] }}--}}
                                                                        <div class="col-md-4" data-repeater-item>
                                                                            <label for="fullname">البند <span
                                                                                    class="text-danger">*</span></label>

                                                                            <select name="term_id"
                                                                                    data-rule-required="true"
                                                                                    class="form-control term_id">

                                                                                <option value="">إختر</option>
                                                                                @foreach($row_category->get_category_terms() as $row_category_term)
                                                                                    <option
                                                                                        value="{{ $row_category_term->id }}" {{ $row_category_term->id == $row_term->contract_term_id ? 'selected' : '' }}>{{ $row_category_term->name }}</option>
                                                                                @endforeach

                                                                            </select>

                                                                            <br>
                                                                            <button type="button" data-repeater-delete
                                                                                    type="button"
                                                                                    class="btn btn-danger"><i
                                                                                    class="fa fa-trash-o"
                                                                                    aria-hidden="true"></i>
                                                                            </button>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="col-md-4" data-repeater-item>
                                                                        <label for="fullname">البند <span
                                                                                class="text-danger">*</span></label>

                                                                        <select name="term_id" data-rule-required="true"
                                                                                class="form-control term_id">
                                                                            <option value="">إختر</option>

                                                                        </select>

                                                                        <br>
                                                                        <button type="button" data-repeater-delete
                                                                                type="button"
                                                                                class="btn btn-danger"><i
                                                                                class="fa fa-trash-o"
                                                                                aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                                {{--                                                            <input type="text" name="inner-text-input" value="B"/>--}}

                                                            </div>
                                                            <button data-repeater-create type="button" value="Add New"
                                                                    class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                                                    type="button"><i class="fa fa-plus"
                                                                                     aria-hidden="true"></i>
                                                            </button>
                                                        </div>


                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div data-repeater-item>
                                                <div class="row border-addmore"
                                                >
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">التصنيف <span
                                                                class="text-danger">*</span></label>

                                                        <select name="category_term_id" data-rule-required="true"
                                                                class="form-control category_term_id"
                                                                data-action="{{ route('contracts.get.terms.by.category') }}">
                                                            <option value="">إختر</option>
                                                            @foreach($contract_categories as $key => $row)
                                                                <option
                                                                    value="{{ $key }}" {{ isset($item) && $item->category_id == $key ? 'selected' : '' }}>{{ $row }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <br>
                                                        <button type="button" data-repeater-delete type="button"
                                                                class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                          aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    <div class="inner-repeater col-md-12">
                                                        <div class="row" data-repeater-list="inner-list">
                                                            <div class="col-md-4" data-repeater-item>
                                                                <label for="fullname">البند <span
                                                                        class="text-danger">*</span></label>

                                                                <select name="term_id" data-rule-required="true"
                                                                        class="form-control term_id">
                                                                    <option value="">إختر</option>

                                                                </select>

                                                                <br>
                                                                <button type="button" data-repeater-delete type="button"
                                                                        class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                                  aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                            {{--                                                            <input type="text" name="inner-text-input" value="B"/>--}}

                                                        </div>
                                                        <button data-repeater-create type="button" value="Add New"
                                                                class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                                                type="button"><i class="fa fa-plus"
                                                                                 aria-hidden="true"></i>
                                                        </button>
                                                    </div>


                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <br>
                                        <button data-repeater-create type="button" value="Add New"
                                                class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                                type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <a href="{{ route('contracts.index')  }}"
                                   class="btn btn-danger">@lang('panel.Cancel')</a>
                                <input type="hidden" name="route-exist-check"
                                       id="route-exist-check"
                                       value="{{ url('admin/check_client_email_exits') }}">
                                <input type="hidden" name="token-value"
                                       id="token-value"
                                       value="{{csrf_token()}}">

                                <button type="submit" class="btn btn-success form_submit"><i class="fa fa-save"
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
    <script src="{{asset('assets/js/contract/add-contract-validation.js')}}"></script>

    <script>
        $(document).ready(() => {
            $(document).on('click', '#add_client .form_submit', function (e) {
                e.preventDefault();
                let $this = $(this);
                let form = $("#add_client");
                let target_url = form.attr('action');
                let formData = new FormData(form[0]);
                console.log('hi threr')
                axios.post(`${target_url}`, formData).then(response => {
                    console.log(response.data)
                    if (response.data.status) {

                        message.fire({
                            type: 'success',
                            title: response.data.message,
                            text: '',

                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('contracts.index')  }}";

                        }, 1000);


                    } else {
                        message.fire({
                            type: 'error',
                            title: response.data.message,
                            text: ''
                        });
                     }
                }).catch(err => console.log(err));
            });
            $(document).on('change', '.category_term_id', function () {
                let $this = $(this);
                let value = $this.val();
                let target_url = $this.data('action');
                axios.get(`${target_url}/${value}`).then(response => {
                    console.log(response.data);
                    let row = '';
                    if (response.data.status == true) {
                        row += '<option value="">إختر</option>';
                        let sub_cate_data = response.data.items;
                        for (let i in sub_cate_data) {
                            row += `<option value="${sub_cate_data[i].id}">${sub_cate_data[i].name}</option>`;
                        }
                        let selectCategory = $this.parent().parent().find('.inner-repeater .term_id');
                        let selectTermValue = selectCategory.val();
                        if ($this.parent().parent().find('.inner-repeater .term_id'))
                            if (selectTermValue === '')
                                $this.parent().parent().find('.inner-repeater .term_id').empty().append(row);


                    } else {
                        message.fire({
                            type: 'error',
                            title: 'خطأ عام !',
                            text: response.data.message
                        });
                    }
                 }).catch(err => {
                    message.fire({
                        type: 'error',
                        title: 'خطأ عام !',
                        text: err.data.message
                    });

                });

            });
        });
    </script>
@endpush
