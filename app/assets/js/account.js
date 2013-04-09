/*global $:true*/
var account =  account || {};

account.validator = {
    isEmail : function(email) {
        return /[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/.test(email);
    }
};

(function () {
    // 用户登录
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
        return true;
    });


    // 用户注册
    var registerForm = $("#registerForm");
    registerForm.on("submit", function() {
        var emailInput = $("#email");
        var passwordInput = $("#password");
        var rePasswordInput = $("#re-password");
        var nickname = $("#nickname");
        var invitation = $("#invitation");

        // 验证输入是否为空
        if (nickname.val() === "") {
            nickname.focus();
            nickname.parent().addClass("error");
            return false;
        }

         //  邮箱有效性性验证
        if (emailInput.val() === "" || !account.validator.isEmail(emailInput.val())) {
            emailInput.focus();
            emailInput.parent().addClass("error");
            return false;
        }
        if (passwordInput.val() === "") {
            passwordInput.focus();
            passwordInput.parent().addClass("error");
            return false;
        }
        if (rePasswordInput.val() === "") {
            rePasswordInput.focus();
            rePasswordInput.parent().addClass("error");
            return false;
        }

        // 验证密码匹配
        if (passwordInput.val() !== rePasswordInput.val()) {
            passwordInput.focus();
            passwordInput.parent().addClass("error");
            return false;
        }

        return true;
    });
}());
