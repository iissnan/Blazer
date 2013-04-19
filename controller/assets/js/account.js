/*global $:true*/
var account =  account || {};

account.validator = {
    isEmail : function(email) {
        return /[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/.test(email);
    },
    isPassword: function(password) {
        return /[\s\S]{6,}/.test(password);
    }
};

(function () {
    // 用户登录
    $(".J_LoginForm").on("submit", function() {
        var emailInput = $("#email"),
            passwordInput = $("#password");
        var alert = $("#alert");
        if (alert.size() < 1) {
            alert = $("<div id='alert' class='alert' />");
        }
        alert.html("");

        emailInput.on("blur", function(){
            if (account.validator.isEmail(this.value)){
                alert.hide();
                emailInput.parent().removeClass("error");
            }
        });
        passwordInput.on("blur", function(){
            if (account.validator.isPassword(this.value)){
                alert.hide();
                passwordInput.parent().removeClass("error");
            }
        });

        if (!account.validator.isEmail(emailInput.val())) {
            alert.addClass("alert-error");
            alert.html("登录邮箱地址不正确");
            alert.prependTo($("#J_LoginForm"));
            emailInput.parent().addClass("error");
            emailInput.focus();
            return false;
        }
        if (!account.validator.isPassword(passwordInput.val())) {
            alert.addClass("alert-error");
            alert.html("登录密码不正确");
            alert.prependTo($("#J_LoginForm"));
            passwordInput.focus();
            passwordInput.parent().addClass("error");
            return false;
        }
        return true;
    });

}());

(function(){

    // 用户注册
    var emailInput = $(".J_RegisterForm #email");
    var passwordInput = $(".J_RegisterForm #password");
    var rePasswordInput = $(".J_RegisterForm #re-password");
    var usernameInput = $("#username");
    var invitation = $("#invitation");

    /**
     * 自定义popover
     * input + popover(default of bootstrap存在着bug
     *
     * @param elem
     */
    function showCustomPopOver(elem) {
        var elementPosition = $(elem).position();
        var popover = $(elem).parent().find(".popover");
        var left = elementPosition.left + $(elem).outerWidth();
        var top = elementPosition.top + $(elem).outerHeight() / 2 - popover.outerHeight()/2;
        popover.css({left: left + 5, top: top}).show();
    }

    $(".J_RegisterForm")
        .on("focus", ".control", function () {
            showCustomPopOver(this);
        })
        .on("blur", ".control", function () {
            $(this).parent().find(".popover").hide();
        });

    emailInput.on("blur", function () {
        var parent = $(this).parent();
        if (account.validator.isEmail(emailInput.val())) {
            parent.removeClass("error").addClass("success");
        } else {
            parent.removeClass("success").addClass("error");
        }
    });
    passwordInput.on("blur", function () {
        var parent = $(this).parent();
        if (account.validator.isPassword(passwordInput.val())) {
            parent.removeClass("error").addClass("success");
        } else {
            parent.removeClass("success").addClass("error");
        }
    });
    rePasswordInput.on("blur", function () {
        var parent = $(this).parent();
        if (passwordInput.val() === rePasswordInput.val() && rePasswordInput.val() !== "") {
            parent.removeClass("error").addClass("success");
        } else {
            parent.removeClass("success").addClass("error");
        }
    });
    usernameInput.on("blur", function () {
        var parent = $(this).parent();
        if (usernameInput.val() !== "") {
            parent.removeClass("error").addClass("success");
        } else {
            parent.removeClass("success").addClass("error");
        }
    });
    invitation.on("blur", function () {
        var parent = $(this).parent();
        if (invitation.val() !== "") {
            parent.removeClass("error").addClass("success");
        } else {
            parent.removeClass("success").addClass("error");
        }
    });

    $(".J_RegisterForm").on("submit", function() {

         //  邮箱有效性性验证
        if (!account.validator.isEmail(emailInput.val())) {
            emailInput.focus();
            emailInput.parent().addClass("error");
            showCustomPopOver(emailInput[0]);
            return false;
        }

        // 密码有效性验证
        if (!account.validator.isPassword(passwordInput.val())) {
            passwordInput.focus();
            passwordInput.parent().addClass("error");
            showCustomPopOver(passwordInput[0]);
            return false;
        }

        if (rePasswordInput.val() === "") {
            rePasswordInput.focus();
            rePasswordInput.parent().addClass("error");
            showCustomPopOver(rePasswordInput[0]);
            return false;
        }

        // 验证密码匹配
        if (passwordInput.val() !== rePasswordInput.val()) {
            passwordInput.focus();
            passwordInput.parent().addClass("error");
            return false;
        }

        // 验证输入是否为空
        if (usernameInput.val() === "") {
            usernameInput.focus();
            usernameInput.parent().addClass("error");
            return false;
        }

        return true;
    });
}());
