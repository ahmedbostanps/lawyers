"use strict";
var select2Case = $('#select2Case').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var getCaseSubTypes = $('#getCaseSubType').val();
var getCourts = $('#getCourt').val();


var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#add_case").validate({
            rules: {
                client_name: "required",
                party_name: "required",
                party_advocate: "required",
                case_no: "required",
                case_type: "required",
                case_status: "required",
                act: "required",
                court_type: "required",
                next_date: "required",
                court_no: "required",
                court_name: "required",
                judge_type: "required",
                filing_number: "required",
                filing_date: "required",
                registration_number: "required",
                registration_date: "required",

            },
            messages: {
                client_name: "الرجاء إدخال اسم العميل.",
                party_name: "الرجاء إدخال الاسم.",
                party_advocate: "الرجاء إدخال اسم المحامي.",
                case_no: "الرجاء إدخال رقم الحالة.",
                case_type: "الرجاء تحديد نوع الحالة.",
                case_status: "الرجاء تحديد مرحلة القضية.",
                act: "الرجاء إدخال قانون.",
                court_type: "الرجاء تحديد نوع المحكمة.",
                next_date: "يرجى تحديد تاريخ الجلسة الأولى.",
                court_no: "الرجاء إدخال رقم المحكمة.",
                court_name: "الرجاء إدخال اسم المحكمة.",
                judge_type: "الرجاء تحديد نوع القاضي.",
                filing_number: "الرجاء إدخال رقم التسجيل.",
                filing_date: "الرجاء تحديد تاريخ التسجيل.",
                registration_number: "الرجاء إدخال رقم التسجيل.",
                registration_date: "الرجاء تحديد تاريخ التسجيل.",

            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },

            submitHandler: function () {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_case']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();


    $('.datetimepickerfilingdate').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
        clearBtn: true,
    });

    $('.datetimepickerregdate').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
        clearBtn: true,
    });

    $('.datetimepickernextdate').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
        clearBtn: true,
    });

    $('input[type=radio][name=position]').on('change', function () {
        if (this.value === 'Respondent') {
            $('.position_name').html('اسم الملتمس');
            $('.position_advo').html('المحامي الملتمس');
        } else if (this.value === 'Petitioner') {
            $('.position_name').html('اسم المستجيب');
            $('.position_advo').html('المحامي المستجيب');
        }
    });

    //
    // $("#assigned_to").select2({
    //     allowClear: true,
    //     placeholder: "حدد المستخدمون",
    //     multiple: true
    // });

    $("#case_type").select2({
        allowClear: true,
        placeholder: "حدد نوع الحالة"
    });

    $("#case_sub_type").select2({
        allowClear: true,
        placeholder: "حدد النوع الفرعي للحالة"
    });

    $("#case_status").select2({
        allowClear: true,
        placeholder: "حدد مرحلة الحالة"
    });
    $("#court_type").select2({
        allowClear: true,
        placeholder: "حدد نوع المحكمة"
    });
    $("#court_name").select2({
        allowClear: true,
        placeholder: "حدد محكمة"
    });
    $("#judge_type").select2({
        allowClear: true,
        placeholder: "حدد نوع القاضي",
    });
    $("#client_name").select2({
        allowClear: true,
        placeholder: "المدعي",
    });

    $('.position_name').html("اسم المستجيب");
    $('.position_advo').html("المحامي المستجيب");
    $('.repeater').repeater({
        // (Optional)
        // start with an empty list of repeaters. Set your first (and only)
        // "data-repeater-item" with style="display:none;" and pass the
        // following configuration flag
        initEmpty: false,
        // (Optional)
        // "defaultValues" sets the values of added items.  The keys of
        // defaultValues refer to the value of the input's name attribute.
        // If a default value is not specified for an input, then it will
        // have its value cleared.
        defaultValues: {
            'text-input': 'foo'
        },
        // (Optional)
        // "show" is called just after an item is added.  The item is hidden
        // at this point.  If a show callback is not given the item will
        // have $(this).show() called on it.
        show: function () {
            $(this).slideDown();
            var test = $('input[name=position]:checked').val();

            if (test === "Respondent") {
                $(".position_name").html("اسم الملتمس");
                $(".position_advo").html("المحامي الملتمس");
            } else if (test === "Petitioner") {
                $(".position_name").html("اسم المستجيب");
                $(".position_advo").html("المحامي المستجيب");
            }
        },
        // (Optional)
        // "hide" is called when a user clicks on a data-repeater-delete
        // element.  The item is still visible.  "hide" is passed a function
        // as its first argument which will properly remove the item.
        // "hide" allows for a confirmation step, to send a delete request
        // to the server, etc.  If a hide callback is not given the item
        // will be deleted.
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        // (Optional)
        // You can use this if you need to manually re-index the list
        // for example if you are using a drag and drop library to reorder
        // list items.
        ready: function (setIndexes) {
            //$dragAndDrop.on('drop', setIndexes);
        },
        // (Optional)
        // Removes the delete button from the first list item,
        // defaults to false.
        isFirstItemUndeletable: true
    })


});

function getCaseSubType(id) {

    if (id === "") {
        $("#case_sub_type").html("");
    } else {
        $("#case_sub_type").html("");
        $("#case_sub_type").prepend($("<option></option>").html("جار التحميل..."));
    }
    if (id !== "") {

        $.ajax({
            url: getCaseSubTypes,
            method: "POST",
            data: {id: id},
            success: function (result) {
                if (result.errors) {
                    $(".alert-danger").html("");
                } else {
                    $("#case_sub_type").html(result);
                }
            }
        });
    }
}

function getCourt(id) {

    if (id === "") {
        $("#court_name").html("#court_name");
    } else {
        $("#court_name").html("");
        $("#court_name").prepend($("<option></option>").html("جار التحميل..."));
    }


    if (id != "") {

        $.ajax({
            url: getCourts,
            method: "POST",
            data: {id: id},
            success: function (result) {
                if (result.errors) {
                    $('.alert-danger').html('');
                } else {
                    $('#court_name').html(result);
                }
            }
        });
    }
}
