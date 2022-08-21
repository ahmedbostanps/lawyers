// "use strict";

var check_user_email_exits = $('#check_user_email_exits').val();
var token = $('#token-value').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });
        $("#add_user").validate({
            rules: {
                f_name: "required",
                l_name: "required",
                email: {
                    required: true,
                    email: true,
                    remote: {
                        async: false,
                        url: check_user_email_exits,
                        type: "post",
                        data: {
                            _token: function () {
                                return token;
                            },
                            email: function () {
                                return $("#email").val();
                            }
                        }
                    }
                },
                mobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                address: "required",
                zip_code: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    number: true
                },
                password: {
                    required: true,
                    // pwcheck: true,
                    minlength: 8,
                },
                cnm_password: {
                    required: true,
                    equalTo: "#password",

                },
                country: "required",
                state: "required",
                city_id: "required",
            },
            messages: {
                username: {
                    required: "الرجاء إدخال اسم المستخدم.",
                    remote: "اسم المستخدم موجود بالفعل .."
                },
                f_name: "الرجاء إدخال الاسم الأول.",
                l_name: "الرجاء إدخال الاسم الأخير.",
                email: {
                    required: "الرجاء إدخال البريد الإلكتروني.",
                    email: "الرجاء إدخال بريد إلكتروني صحيح.",
                    remote: "البريد الإلكتروني موجود بالفعل."
                },
                mobile: {
                    required: "الرجاء إدخال المحمول.",
                    minlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    maxlength: "يجب أن يتكون الهاتف المحمول من 10 أرقام.",
                    number: "الرجاء إدخال رقم 0-9.",
                },
                address: "الرجاء إدخال العنوان.",
                zip_code: {
                    required: "الرجاء إدخال الرمز البريدي.",
                    minlength: "يجب أن يتكون الرمز البريدي من 6 أرقام.",
                    maxlength: "يجب أن يتكون الرمز البريدي من 6 أرقام.",
                    number: "الرجاء إدخال رقم 0-9.",
                },
                password: {
                    required: "الرجاء إدخال كلمة المرور.",
                    // pwcheck: 'يجب ألا تقل كلمة المرور عن 8 أحرف ، ويجب أن تحتوي كلمة المرور على الأقل على حرف صغير واحد وحرف كبير واحد ورقم واحد وحرف خاص واحد.',
                    minlength: "الرجاء إدخال 8 أرقام على الأقل."

                },
                cnm_password: {
                    required: "الرجاء إدخال تأكيد كلمة المرور.",
                },
                country: "الرجاء تحديد الدولة.",
                state: "الرجاء تحديد الولاية.",
                city_id: "الرجاء تحديد المدينة.",
                role: "الرجاء تحديد الدور.",
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
        });
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();

    $("#role").select2({
        allowClear: true,
        placeholder: 'حدد الدور',
        // multiple:true
    });

    $("#user_source").select2({
        allowClear: true,
        placeholder: 'اختر مصدر',
        // multiple:true
    });

    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $("#upload-demo").hide();
    var fileTypes = ['jpg', 'jpeg', 'png'];
    $('#upload').on('change', function () {

        var reader = new FileReader();
        if (this.files[0].size > 5242880) { // 2 mb for bytes.
            //alert('File size should not be more than 2MB');
            message.fire({
                type: 'error',
                title: 'Error',
                text: 'File size should not be more than 5MB',
            });
            return false;
        }

        reader.onload = function (e) {
            result = e.target.result;
            arrTarget = result.split(';');
            tipo = arrTarget[0];

            if (tipo == 'data:image/jpeg' || tipo == 'data:image/png') {
                $("#upload-demo").show();
                $("#upload_img").show();
                $('#upload-demo-i').hide();
                $('#crop_image').hide();
                $('#demo_profile').hide();
                //$('#cancel_img').show();
                $uploadCrop.croppie('bind', {
                    url: e.target.result

                }).then(function () {
                    console.log('jQuery bind complete');
                });
            } else {
                message.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'Accept only .jpg .png image',
                });

                // alert('Accept only .jpg .png image types');

            }
        }
        reader.readAsDataURL(this.files[0]);

    });


    $('#upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {

            $('#imagebase64').val(resp);

        });
    });


    var $imageupload = $('.imageupload');
    $imageupload.imageupload();

    $('#imageupload-disable').on('click', function () {
        $imageupload.imageupload('disable');
        $(this).blur();
    })

    $('#imageupload-enable').on('click', function () {
        $imageupload.imageupload('enable');
        $(this).blur();
    })

    $('#imageupload-reset').on('click', function () {
        $imageupload.imageupload('reset');
        $(this).blur();
    });

    $('#cancel_img').on('click', function () {

        $("#upload-demo").hide();
        $("#upload_img").hide();
        $('#upload-demo-i').show();
        $('#crop_image').show();
        $('#demo_profile').show();
        $('#remove_crop').show();
        // $('#cancel_img').hide();

    });




});

$(document).ready(function () {
    $("#role").select2({
        allowClear: true,
        placeholder: 'حدد الدور',
        // multiple:true
    });


});


