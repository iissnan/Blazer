(function () {
    "use strict";

    var form = document.getElementById("J_FormAdd");
    var inputTitle = document.getElementById("title");
    var inputAuthor = document.getElementById("author");
    var actionAdd = document.getElementById("J_ActionAdd");
    var error = document.getElementById("error");
    if (actionAdd) {
        actionAdd.onclick = function () {
            if (inputTitle.value !== "") {
                form.submit();
            } else {
                error.innerHTML = "请输入标题";
                error.style.display = "block";
            }
        };
    }
}());