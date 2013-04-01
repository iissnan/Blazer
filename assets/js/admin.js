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

    /**
     * 删除确认
     * @param link
     */
    window.confirmDelete = function (link) {
        if (window.confirm("确认删除？")) {
            var id = link.innerHTML;
            if (id) {
                location.href = "delete.php?id=" + id;
            }
        }
        return false;
    };

}());


