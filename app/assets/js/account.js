var account =  account || {};

account.validator = {
    isEmail : function(email) {
        return /[-\w\.]+@(?:[a-zA-Z0-9]+\.)*[a-zA-Z0-9]+/.test(email);
    }
};


(function () {
    var registerForm = document.getElementById("registerForm");
    registerForm.onsubmit = function() {
        var emailInput = document.getElementById("email");
        var passwordInput = document.getElementById("password");
        var rePasswordInput = document.getElementById("re-password");
        var nickname = document.getElementById("nickname");

        // 验证输入是否为空
        if (emailInput.value === "") {emailInput.focus(); return false;}
        if (passwordInput.value === "") {passwordInput.focus(); return false;}
        if (rePasswordInput.value === "") {rePasswordInput.focus(); return false;}
        if (nickname.value === "") {nickname.focus(); return false;}

        //  邮箱邮箱性验证
        if (!account.validator.isEmail(emailInput.value)) {
            emailInput.focus();
            return false;
        }

        // 验证密码匹配
        if (passwordInput.value !== rePasswordInput.value) {passwordInput.focus(); return false;}
    };

}());
