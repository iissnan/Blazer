<?php
    session_start();
    require_once("../require.global.php");
    redirect_unless_login("/login.php");
    require_once(MODEL_DIR . "/book.class.php");

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
                    header("location: /position/add.php?book_id=$book_id&source=add&code=1");
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

            if ($_GET["code"] === "1") {
                $show_alert = true;
                $alert_mode = "alert-success";
                switch ($_GET["source"]){
                    case "add":
                        $alert_message = "添加成功"; break;
                }
            }

            // 获取书籍信息
            $book_model = new BookModel();
            $book_result = $book_model->get_item("id", $book_id);
            if ($book_result && $book_result->num_rows > 0) {

                $smarty->assign("book", $book_result->fetch_object());

                // 获取进度信息
                $model = new DatabaseManipulate("positions");
                $join_query = $model->select("*")
                                    ->where("`user_id`='$user->id'")
                                    ->where("`book_id`='$book_id'")
                                    ->order_by("id")
                                    ->execute();

                if ($join_query && $join_query->num_rows > 0) {
                    $smarty->assign("positions", $join_query);
                }
            } else {
                $error = true;
                $alert_message = "未找到请求的书籍信息";
            }
        }
    }

    $smarty->assign("error", $error);
    $smarty->assign("show_alert", $show_alert);
    $smarty->assign("alert_mode", $alert_mode);
    $smarty->assign("alert_message", $alert_message);
    $smarty->assign("user", $user);
    $smarty->display("position/add.tpl");

    isset($position_model) and $position_model->release();
