var pwMatch = false;
function checkPasswordMatch() {
    var password = $("#password").val();
    if (password.length > 0) {
        var confirmPassword = $("#ConfirmPassword").val();
        if (password != confirmPassword) {
            pwMatch = false;
            $("#divCheckPasswordMatch").html("Passwords do not match!");
            $("#divCheckPasswordMatch").removeClass('isa_success');
            $("#divCheckPasswordMatch").addClass('isa_error');
        } else {
            pwMatch = true;
            $("#divCheckPasswordMatch").html("Passwords match.");
            $("#divCheckPasswordMatch").removeClass('isa_error');
            $("#divCheckPasswordMatch").addClass('isa_success');
        }
    } else {
        pwMatch = false;
        $("#divCheckPasswordMatch").html("Password Can Not Be Empty!");
        $("#divCheckPasswordMatch").removeClass('isa_success');
        $("#divCheckPasswordMatch").addClass('isa_error');
    }
}
$(document).ready(function () {
    $("#password, #ConfirmPassword").keyup(checkPasswordMatch);
});
function checkPass() {
    return pwMatch;
}