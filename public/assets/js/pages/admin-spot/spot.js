$(function() {
    HideCheckBox();
});

// $('#md_checkbox').click(function () {
//     debugger
//''     if ($(this).is(':checked')) {
//        $("#splace").hide();
//     } else {
// $("#splace").show();
//        // if checkbox is not checked.. dont show input field 
//     }
//   });

//Init Loading

function HideCheckBox() {

    $('#md_checkbox').on('click', function() {
        if ($(this).is(':checked')) {

            $("#splace").hide();
            $("#spot-name").show();
            // $("#sname").prop('disabled',false);
            // $("#sname").css("background-color", "white"); 


        } else {
            $("#splace").show();
            $("#spot-name").hide();
            // $("#sname").prop('disabled', true);
            // $("#sname").css("background-color", "hsl(0deg 0% 50% / 14%)");
        }
    });

}

$(document).ready(function() {
    $('#place').keyup(function() {
        if ($(this).val() != '') {
            $('#sname').removeAttr('disabled');
        } else {
            $('#sname').attr('disabled', true);
        }
    });
});