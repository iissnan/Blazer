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
     * @param mixed $categories_raw
     * @return boolean
     */
    public function add_category($book_id, $categories_raw) {
        $categories = gettype($categories_raw) == "array" ?
            $categories_raw :
            explode(",", $categories_raw);
        $category_model = new Model("categories");
        $book_category_model = new Model("books_categories");
        $processResult = false;
        foreach($categories as $category) {
            $category = trim($category);
            $category_id = false;

            if ($category == "") {
                continue;
            }

            // 检索分类是否已存在
            $category_result = $category_model->getItem("name", $category);
            if ($category_result && $category_result->num_rows > 0) {
                $category_id = $category_result->fetch_object()->id;
            } else {
                $result = $category_model->add(array("name" => $category));
                if ($result) {
                    $category_id = $category_model->dbc->db->insert_id;
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
        $authors = gettype($authors) == "array" ?
            $authors :
            explode(",", $authors);
        $author_model = new Model("authors");
        $book_author_model = new Model("books_authors");
        $processResult = false;
        $author_id = false;
        foreach($authors as $author) {
            $author = trim($author);

            if ($author == "") {
                continue;
            }

            // 检测作者是否已存在
            $author_query_result = $author_model->getItem("name", $author);
            if ($author_query_result && $author_query_result->num_rows > 0) {
                $author_id = $author_query_result->fetch_object()->id;
            } else {
                $author_result = $author_model->add(array("name" => $author));

                if ($author_result) {
                    $author_id = $author_model->dbc->db->insert_id;
                }
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

            // 剔除首尾空格
            foreach ($categories as &$category) {
                $category = trim($category);
            }

            // 删除旧的分类
            $categories_for_query = array_map(function($item) {
                return "'$item'";
            }, $categories_clean);
            $categories_for_query = join(',', $categories_for_query);
            $category_model->dbc->execute(
                "DELETE FROM books_categories " .
                    "WHERE books_categories.book_id=$book_id " .
                    "AND books_categories.category_id " .
                    "IN (SELECT id FROM categories WHERE categories.name NOT IN ($categories_for_query))"
            );

            // 新增的分类
            if (count($categories_old) > 0) {
                $categories_new = array();
                foreach($categories_clean as $category_clean) {
                    if (!in_array($category_clean, $categories_old) && $category_clean != "") {
                        array_push($categories_new, $category_clean);
                    }
                }
            } else {
                $categories_new = $categories_clean;
            }
            $this->add_category($book_id, $categories_new);
        }
    }

    public function update_author($book_id, $authors_raw) {
        $author_model = new Model("authors");
        $book_author_model = new Model("books_authors");

        // 获取书籍旧的作者数据
        $authors_old = array();
        $authors_old_result = $author_model->getJoinItems(
            array("books_authors"),
            "books_authors.book_id=$book_id AND books_authors.author_id=authors.id"
        );
        if ($authors_old_result) {
            for ( $i = 0; $i < $authors_old_result->num_rows; $i++) {
                $book_author = $authors_old_result->fetch_object();
                array_push($authors_old, $book_author->name);
            }
        }

        // 如果作者为空，执行删除操作
        if ($authors_raw == "") {
            $book_author_model->remove("book_id='$book_id'");
        } else {
            $authors = explode(",", $authors_raw);
            $authors_clean = array_map(function($item){
                return trim($item);
            }, $authors);

            // 删除旧的作者
            $authors_for_query = array_map(function($item) {
                return "'$item'";
            }, $authors_clean);
            $authors_for_query = join(',', $authors_for_query);
            $author_model->dbc->execute(
                "DELETE FROM books_authors " .
                    "WHERE books_authors.book_id=$book_id " .
                    "AND books_authors.author_id " .
                    "IN (SELECT id FROM authors WHERE authors.name NOT IN ($authors_for_query))"
            );

            // 新增的作者
            if (count($authors_old) > 0) {
                $authors_new = array();
                foreach($authors_clean as $author_clean) {
                    if (!in_array($author_clean, $authors_old) && $author_clean != "") {
                        array_push($authors_new, $author_clean);
                    }
                }
            } else {
                $authors_new = $authors_clean;
            }
            $this->add_author($book_id, $authors_new);
        }
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