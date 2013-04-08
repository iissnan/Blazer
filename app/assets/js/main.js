(function(){
    "use strict";
    $("#J_LoginForm").on("submit", function() {
        var emailInput = $("#email"),
            passwordInput = $("#password");
        var alert = $("#alert");
        if (alert.size() < 1) {
            alert = $("<div id='alert' class='alert' />");
        }
        alert.html("");
        if (emailInput.val() === "") {
            alert.addClass("alert-error");
            alert.html("请输入登录邮箱");
            alert.prependTo($(".login-wrap"));
            emailInput.parent().addClass("error");
            emailInput.focus();
            return false;
        }
        if (passwordInput.val() === "") {
            alert.addClass("alert-error");
            alert.html("请输入密码");
            alert.prependTo($(".login-wrap"));
            passwordInput.focus();
            passwordInput.parent().addClass("error");
            return false;
        }
    });
}());