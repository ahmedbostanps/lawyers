 <div class="modal fade bs-example-modal-sm" id="addpayment" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-mg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel2">إضافة الدفع</h4>
            </div>
            <div class="modal-body">

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label for="amount">{{ __('constants.amount') }} <span class="text-danger">*</span></label>
                  <input type="text" placeholder="" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label for="receipt_date">تاريخ استلام <span class="text-danger">*</span></label>
                  <input type="text" placeholder="" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label for="payment_method">طريقة الدفع  <span class="text-danger">*</span></label>
                  <select class="form-control">
                    <option>اختار طريقة الدفع</option>
                    <option>نقدي</option>
                    <option>شيك</option>
                    <option>حوالة بنكية</option>
                    <option>اخرى</option>
                  </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label for="referance_number">رقم المرجع</label>
                  <input type="text" placeholder="" class="form-control">
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <label for="note">ملاحظة</label>
                  <textarea type="text" placeholder="" class="form-control"></textarea>
              </div>
            </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('panel.close') }}</button>
              <button type="button" class="btn btn-primary">{{ __('panel.save') }}</button>
            </div>

          </div>
        </div>
      </div>
