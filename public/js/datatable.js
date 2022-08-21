"use strict";
var t;

var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {


        t = $('#DataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": false,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
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
            "width": 200,
            // "iDisplayLength": 2,
            "ajax": {
                "url": window.data_url,
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {});
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": window.columns,
        });

    };

    //== Public Functions
    return {
        // public functions
        init: function () {
            lsitDataInTable();
        },
        fail: function () {
            t.reload();
        }
    };
}();

jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init();
});
