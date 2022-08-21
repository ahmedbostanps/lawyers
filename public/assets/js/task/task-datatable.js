"use strict";
var t;

var token = $('#token-value').val();
var url_link = $('#clientDataTable').attr('data-url');

var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#clientDataTable').DataTable({
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
            "width": 200,
            // "iDisplayLength": 2,
            "ajax": {
                "url": url_link,
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
                {
                    "data": "id"
                },
                {
                    "data": "task_subject"

                },
                {
                    "data": "case",
                    "orderable": false,
                },
                {
                    "data": "start_date"
                },
                {
                    "data": "end_date"
                },
                {
                    "data": "members",
                    "orderable": false,
                },
                {
                    "data": "status",
                    "orderable": false,
                },
                {
                    "data": "priority",
                    "orderable": false,
                },
                {
                    "data": "action",
                    "orderable": false,
                }
            ]
        });

    }

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
