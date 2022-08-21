"use strict";
var checkExistRoute = $('#route-exist-check').val();
var token = $('#token-value').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#add_client").validate({
            debug: false,
            rules: {
                f_name: "required",
                m_name: "required",
                l_name: "required",
                address: "required",
                country: "required",
                state: "required",
                city_id: "required",
                email: {
                    email: true,
                },
                mobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                alternate_no: {
                    required: false,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                reference_mobile: {
                    required: false,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                }
            },
            messages: {
                f_name: "الرجاء إدخال الاسم الأول.",
                m_name: "الرجاء إدخال الاسم الأوسط.",
                l_name: "الرجاء إدخال الاسم الأخير.",
                address: "الرجاء إدخال العنوان.",
                country: "الرجاء تحديد الدولة.",
                state: "الرجاء تحديد الولاية.",
                city_id: "الرجاء تحديد المدينة.",

                email: {
                    email: "الرجاء إدخال بريد إلكتروني صحيح.",
                },
                mobile: {
                    required: "الرجاء إدخال المحمول.",
                    minlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    maxlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    number: "الرجاء إدخال رقم 0-9.",
                },
                alternate_no: {
                    required: "الرجاء إدخال رقم بديل.",
                    minlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    maxlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    number: "الرجاء إدخال رقم 0-9.",
                },
                reference_mobile: {
                    required: "الرجاء إدخال رقم الهاتف المرجعي.",
                    minlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    maxlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    number: "الرجاء إدخال رقم 0-9.",
                }

            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function () {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_user']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();

    //set initial state.
    $("#change_court_chk").on("click", function () {
        if ($(this).is(":checked")) {

            var returnVal = this.value;
            if (returnVal == 'Yes') {
                $('#change_court_div').removeClass('hidden');
            }
        } else {
            $('#change_court_div').addClass('hidden');
        }
    });

    $('.two').css('display', 'none');

    $('input[type=radio][name=type]').on("change", function () {

        if (this.value == 'single') {
            $('.one').css('display', 'block');
            $('.two').css('display', 'none');
        } else if (this.value == 'multiple') {
            $('.two').css('display', 'block');
            $('.one').css('display', 'none');
        }

    });

    $('.repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo'
        },
        show: function () {
            $(this).slideDown();
            var id = $(this).find('[type="text"]').attr('id');
            var label = $(this).find('label');
            label.attr('for', id);
            $(this).addClass('fade-in-info').slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('هل أنت متأكد أنك تريد حذف هذا العنصر؟')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    })
});
