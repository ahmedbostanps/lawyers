<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="clientPaymentreceivemodal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">إضافة الدفع</h4>
            </div>
            <form method="post" class="" id="form_payment" name="form_payment">
                <input type="hidden" id="invoice_id" name="invoice_id" value="{{$invoice_id}}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="alert alert-danger change-cort-d"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label class="discount_text">المبلغ
                                        <er class="rest">*</er>
                                    </label>
                                    <input type="text" id="amount" name="amount" class="form-control" value=""
                                           autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label class="discount_text">تاريخ الاستلام
                                        <er class="rest">*</er>
                                    </label>
                                    <input type="text" id="receive_date" name="receive_date" class="form-control date1"
                                           value="" autocomplete="off" readonly="">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label class="discount_text">طريقة الدفع
                                        <er class="rest">*</er>
                                    </label>
                                    <select class="form-control select2" id="method" name="method">
                                        <option value="">اختار طريقة الدفع</option>
                                        <option value="Cash">نقدي</option>
                                        <option value="Cheque">شيك</option>
                                        <option value="Net Banking">تحويل بنكي</option>
                                        <option value="Other">اخرى</option>
                                    </select>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label class="discount_text">رقم المرجع
                                        <er class="rest" class="hide" id="show_star">*</er>
                                    </label>
                                    <input type="text" id="referance_number" name="referance_number"
                                           class="form-control " value="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row hide" id="show_cheque_date">
                        <div class="col-md-12">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label class="discount_text">تاريخ الشيك
                                        <er class="rest" class="" id="">*</er>
                                    </label>
                                    <input type="text" id="cheque_date" name="cheque_date" class="form-control "
                                           value="" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contct-info">
                                <div class="form-group">
                                    <label class="discount_text">ملاحظة</label>
                                    <textarea id="note" name="note" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="ik ik-x"></i>{{ __('panel.close') }}
                    </button>
                    <button type="submit" name="judge_type_btn" class="btn btn-success"><i
                            class="fa fa-spinner fa-spin hide" id="btn_loader"></i>&nbsp;{{ __('panel.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<input type="hidden" name="date_format_datepiker"
       id="date_format_datepiker"
       value="{{ $date_format_datepiker }}">
<input type="hidden" name="method_"
       id="method_"
       value="{{ empty($judge->id)?'POST':'PATCH'}}">

<input type="hidden" name="url"
       id="url"
       value="{{ empty($judge->id)?route('invoice.store'):route('invoice.update',$judge->id)}}">

<script src="{{asset('assets/js/invoice/invoice-payment.js')}}"></script>
