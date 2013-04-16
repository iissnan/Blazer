<?php
    session_start();
    require_once("include/auth.php");

    require_once("class/book.class.php");
    require_once("class/paginator.class.php");
    $book_model = new BookModel();
    $books_total = $book_model->total();

    // 分页
    $page = !isset($_GET["page"]) ? 1 : $_GET["page"];
    $page_size = 10;
    $paginator = new Paginator($books_total, $page, $page_size);

    // 获取过滤后的$page
    $page = $paginator->getPage();
    $page_total = $paginator->getTotal();


    // 获取多本书籍
    $books_rs = $book_model->getItems($page_size, $page, "");
    if ($books_rs) {
        $Category = new Model("categories");
        $Author = new Model("authors");
        //$books = $books->fetch_all(); // require PHP5.3.0
        $books = array();
        for($i = 0; $i < $books_rs->num_rows; $i++) {
            $book = $books_rs->fetch_array();

            // 获取作者信息
            $category_result = $Category->getJoinItems(
                array("books_categories" ),
                "books_categories.book_id=" . $book["id"] . " AND books_categories.category_id=categories.id"
            );
            if ($category_result) {
                $categories = array();
                for ($j = 0; $j < $category_result->num_rows; $j++) {
                    array_push($categories, $category_result->fetch_object()->name);
                }
                $book["category"] = join(",", $categories);
            }

            // 获取分类信息
            $author_result = $Author->getJoinItems(
                array("books_authors"),
                "books_authors.book_id=" . $book["id"] . " AND books_authors.author_id=authors.id"
            );
            if ($author_result) {
                $authors = array();
                for ($k = 0; $k < $author_result->num_rows; $k++) {
                    array_push($authors, $author_result->fetch_object()->name);
                    $book["author"] = join(",", $authors);
                }
            }
            array_push($books, $book);
        }
    }

    require_once("include/smarty.php");
    $smarty->assign("page_title", "书架");
    if ($paginator->hasPagination()) {
        $smarty->assign(array(
            "pagination" => true,
            "page_current" => $page,
            "page_total" => $page_total
        ));
    }

    // 获取用户信息
    if (isset($_SESSION["user"])) {
        $smarty->assign("user", $_SESSION["user"]);
    }

    $smarty->assign("total", $books_total);
    $smarty->assign("books", $books);
    $smarty->display("index.tpl");