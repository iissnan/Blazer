<?php

require_once("model.class.php");

/**
 * Book Model
 */
class BookModel extends Model{
    protected $table = "books";

    public function __construct() {
        parent::__construct($this->table);
    }

    /**
     * 添加分类
     *
     * @param integer $book_id
     * @param string $categories_raw
     * @return boolean
     */
    public function add_category($book_id, $categories_raw) {
        $categories = explode(",", $categories_raw);
        $category_model = new Model("categories");
        $book_category_model = new Model("books_categories");
        $processResult = false;
        foreach($categories as $category) {
            $category = trim($category);
            $category_id = false;
            $result = $category_model->add(array("name" => $category));
            if ($result) {
                $category_id = $category_model->dbc->db->insert_id;
            } else {
                $category_result = $category_model->getItem("name", $category);
                if ($category_result) {
                    $category_id = $category_result->fetch_object()->id;
                }
            }
            if ($category_id !== false) {
                if ($book_category_model->add(array("book_id" => $book_id, "category_id" => $category_id))) {
                    $processResult = true;
                }
            }
        }

        return $processResult;
    }


    /**
     * @param $book_id
     * @param $authors
     * @return bool
     */
    public function add_author($book_id, $authors) {
        $authors = explode(",", $authors);
        $author_model = new Model("authors");
        $book_author_model = new Model("books_authors");
        $processResult = false;
        $author_id = false;
        foreach($authors as $author) {
            $author = trim($author);
            $author_result = $author_model->add(array("name" => $author));
            if ($author_result) {
                $author_id = $author_model->dbc->db->insert_id;
            } else {
                $author_query_result = $author_model->getItem("name", $author);
                $author_query_result and $author_id = $author_query_result->fetch_object()->id;
            }
            if ($author_id !== false) {
                if ($book_author_model->add(array("book_id" => $book_id, "author_id" => $author_id))) {
                    $processResult = true;
                }
            }
        }

        return $processResult;
    }

    public function update_category($book_id, $categories_raw) {
        $category_model = new Model("categories");
        $book_category_model = new Model("books_categories");

        // 获取书籍旧的分类数据
        $categories_old = array();
        $categories_old_result = $category_model->getJoinItems(
            array("books_categories"),
            "books_categories.book_id=$book_id AND books_categories.category_id=categories.id"
        );
        if ($categories_old_result) {
            for ( $i = 0; $i < $categories_old_result->num_rows; $i++) {
                $book_category = $categories_old_result->fetch_object();
                array_push($categories_old, $book_category->name);
            }
        }

        // 如果分类为空，执行删除操作
        if ($categories_raw == "") {
            $book_category_model->remove("book_id='$book_id'");
        } else {
            $categories = explode(",", $categories_raw);
            $categories_clean = array_map(function($item){
                return trim($item);
            }, $categories);

            // 删除旧的分类
            $category_model->dbc->execute(
                "DELETE FROM books_categories " .
                    "WHERE id IN (SELECT id FROM categories WHERE categories.name NOT IN ($categories_clean))"
            );

            // 新增的分类
            if (count($categories_old) > 0) {
                $categories_new = array();
                foreach($categories_clean as $category_clean) {
                    if (!in_array($category_clean, $categories_old)) {
                        array_push($categories_new, $category_clean);
                    }
                }
            } else {
                $categories_new = $categories_clean;
            }
            $this->add_category($book_id, $categories_new);
        }



        // 删除冗余的分类数据：
        //   若旧的分类在books_categories里的引用为0，则在categories删除掉
        for ( $i = 0; $i < count($categories_old); $i++) {
            $count_result = $book_category_model->total(
                "books_categories.category_id=categories.id AND categories.name='$categories_old[$i]'",
                array("categories")
            );
            if ($count_result == 0) {
                $category_model->remove("name='$categories_old[$i]'");
            }
        }

    }

    public function update_author($book_id, $author_raw) {
        /*
        $authors = explode(",", $author);
        $author_model = new Model("authors");
        $book_author_model = new Model("books_authors");
        foreach($authors as $author) {
            $author = trim($author);
            if ($author == "") {
                $Book_Author->remove("book_id=$id");
            } else {
                $author_model->updateJoin(
                    array("books_authors"),
                    "books_authors.book_id=$id" .
                        " AND books_authors.author_id=authors.id ",
                    array("authors.name" => $author)
                );
            }

        }
        */
    }

    /**
     * 封面处理
     *
     * @param $cover
     * @return string
     */
    public function handleCover($cover) {
        $cover = gettype($cover) == "array" ? $this->handleCover($cover) : $cover;
        // 封面存储路径
        define("DIR_COVER", "../cover");

        // 上传的图片最大限制为500K
        define("MAX_SIZE", 500000);

        if (!is_dir(DIR_COVER)) {
            mkdir(DIR_COVER);
        }

        // 允许的上传图片类型
        $allow_mimes = array("image/png", "image/jpeg", "image/gif");
        if ($cover["size"] == 0) {}
        if ($cover["size"] > MAX_SIZE) {
            echo "图片大小必需小于500K";
            return "";
        }
        if (! in_array($cover["type"], $allow_mimes)) {
            echo "仅支持PNG, GIF和JPG格式的图片";
            return "";
        }
        if (!move_uploaded_file($cover["tmp_name"], DIR_COVER . '/' . $cover["name"])) {
            echo "图片上传失败";
            return "";
        } else {
            return DIR_COVER . "/" . $cover["name"];
        }
    }
}