"use strict";

var token = $('#token-value').val();
var list = $('#invoice-list').val();
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#client_list').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [[0, "desc"]],
            "oLanguage": {
                "sProcessing": "<div class='loader-container'><div id='loader'></div></div>",
                "sEmptyTable": "لا يوجد بيانات",
                "sLengthMenu": "عرض _MENU_ سجل بالصفحة",
                "sZeroRecords": "لا يوجد بيانات",
                "sInfo": "عرض  _START_ الى _END_ من _TOTAL_ سجل",
                "sInfoEmpty": "عرض 0 الى 0 من 0 سجل",
                "sSearch": "بحث",
                "oPaginate": {
                    "sPrevious": "السابق",
                    "sNext": "التالي"
                }
            },
            "ajax": {
                "url": list,
                "dataType": "json",
                "type": "POST",
                "data": {_token: token}
            },
            "columns": [
                {"data": "id"},
                {"data": "invoice_no"},
                {"data": "name"},
                {"data": "total_amount"},
                {"data": "paid_amount"},
                {"data": "due_amount"},
                {"data": "status"},
                {"data": "options"},
            ],
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [-1], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-2], //last column
                    "orderable": false, //set not orderable
                },

            ]


        });

    }

    //== Public Functions
    return {
        // public functions
        init: function () {
            lsitDataInTable();
        }
    };
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()
});
