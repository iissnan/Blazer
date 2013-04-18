$("#J_FormAdd").on("submit", function(){
    var title = $("#title");
    if (title.val() === "") {
        title.focus();
        title.parents(".control-group").addClass("error");
        return false;
    }
    return true;
});

$(".action-book-delete").on("click", function(){
    if (window.confirm("确认删除此书籍？")) {
        return true;
    }
    return false;
});