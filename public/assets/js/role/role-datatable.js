"use strict";

var token = $('#token-value').val();
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#roleDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
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
            "ajax": {
                "url": $('#roleDataTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {});
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [
                {"data": "id"},
                {"data": "slug"},
                {"data": "action"}
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
