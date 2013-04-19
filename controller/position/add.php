<?php
    session_start();
    require_once("../../include/auth.php");
    redirect_unless_login("/login.php");
    require_once("../../include/smarty.php");
    require_once("../../model/book.class.php");

    $alert_mode = "alert-error";
    $alert_message = "";
    $error = false;

    $user = $_SESSION["user"];

    if (isset($_POST["submitted"]) && $_POST["submitted"] == "yes") {
        $book_id = isset($_POST["book_id"]) ? intval($_POST["book_id"]) : 0;
        $position = !empty($_POST["position"]) ? $_POST["position"] : 0;
        $note = isset($_SESSION["position_note"]) ? $_SESSION["position_note"] : "";

        if (empty($book_id)) {
            $error = true;
            $alert_message = "书籍ID无效";
        } else {
            if (empty($position)) {
                $error = true;
                $alert_message = "进度不能为空或者0";
            } else {
                $model = new DatabaseManipulate("positions");

                $new_position = array(
                    "user_id" => $user->id,
                    "book_id" => $book_id,
                    "position" => $position,
                    "note" => $note,
                    "create_at" => date("Y-m-d H:i:s")
                );
                $insert_result = $model->insert($new_position)->execute();
                if ($insert_result) {
                    $show_alert = true;
                    $alert_mode = "alert-success";
                    $alert_message = "添加成功";
                } else {
                    $error = true;
                    $alert_message = "执行数据插入失败";
                }
            }
        }
    } else {

        // 获取书籍ID
        $book_id = isset($_GET["book_id"]) ? intval($_GET["book_id"]) : "";
        if (empty($book_id)) {
            $error = true;
            $alert_message = "参数无效";
        } else {
            $smarty->assign("book_id", $book_id);
            $model = new DatabaseManipulate("positions");
            $join_query = $model->select("*", "books, positions")
                                ->where("`positions`.`user_id`='$user->id'")
                                ->where("`positions`.`book_id`='$book_id'")
                                ->where("books.id=positions.book_id")
                                ->execute();

            if ($join_query && $join_query->num_rows > 0) {
                $smarty->assign("book_info", $join_query->fetch_object());

                // 重置结果指针
                $join_query->data_seek(0);
                $smarty->assign("positions", $join_query);
            }
        }
    }

    $alert = "<div class='alert $alert_mode'>$alert_message</div>";
    if ($error) {
        $smarty->assign("error", $error);
        $smarty->assign("alert", $alert);
    }
    $show_alert and $smarty->assign("alert", $alert);
    $smarty->assign("user", $user);
    $smarty->display("position/add.tpl");

    isset($position_model) and $position_model->release();
