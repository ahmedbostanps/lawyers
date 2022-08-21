<div class="modal fade bs-example-modal-lg" id="payment_made_history" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">تاريخ الدفع</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 table">
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>رقم الفاتورة</th>
                    <th>المبلغ</th>
                    <th>تاريخ الاستلام</th>
                    <th>طريقة الدفع </th>
                    <th>رقم المرجع</th>
                    <th>ملاحظة</th>
                  </tr>
                </thead>

                <tbody>

                </tbody>

            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('panel.Cancel') }}</button>
        <button type="button" class="btn btn-primary">{{ __('panel.save') }}</button>
      </div>

    </div>
  </div>
</div>
