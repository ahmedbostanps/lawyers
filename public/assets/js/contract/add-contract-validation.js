"use strict";
var checkExistRoute = $('#route-exist-check').val();
var token = $('#token-value').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#add_client").validate({
            debug: false,
            rules: {
                category_id: "required",
                name: "required",


            },
            messages: {
                category_id: "هذا الحقل ملوب",
                name: "هذا الحقل ملوب"

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

    // $('.two').css('display', 'none');

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
        repeaters: [{
            // (Required)
            // Specify the jQuery selector for this nested repeater
            selector: '.inner-repeater'
        }],
        show: function () {
            $(this).slideDown();
            var id = $(this).find('[type="text"]').attr('id');
            var label = $(this).find('label');
            label.attr('for', id);
            $(this).addClass('fade-in-info').slideDown();
            // $(".category_term_id").each(function (index) {
            //     $(this).change();
            //     let parent = $(this).parent().parent().find('.inner-repeater');
            //     let term = parent.find('.term_id');
            //     // if(term.val())
            //
            //     // if($(this).val() !== '') {
            //     //     $(".category_term_id").change();
            //     // }
            // });

        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    })
});
