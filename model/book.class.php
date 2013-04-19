<?php

require_once("dbm.class.php");
require_once("author.class.php");
require_once("tag.class.php");

/**
 * Book Model
 */
class BookModel extends DatabaseManipulate{
    protected $table = "books";

    public function __construct() {
        parent::__construct($this->table);
    }

    public function add($data) {
        $cover = $data["cover"];
        $cover = is_array($cover) ? $this->handle_cover($cover) : $cover;
        $data["cover"] = $cover;
        parent::insert($data);
        return parent::execute();
    }

    public function update($data) {
        $cover = $data["cover"];
        $cover = is_array($cover) ? $this->handle_cover($cover) : $cover;
        $data["cover"] = $cover;
        return parent::update($data);
    }

    /**
     * 添加分类
     *
     * @param integer $book_id
     * @param mixed $categories_raw
     * @return boolean
     */
    public function add_category($book_id, $categories_raw) {
        if (!$categories_raw) {
            return true;
        }
        $categories = is_array($categories_raw) ? $categories_raw : explode(",", $categories_raw);
        $category_model = new TagModel();
        $book_category_model = new DatabaseManipulate("books_categories");
        $processResult = false;
        foreach($categories as $category) {
            $category = trim($category);
            $category_id = false;

            if ($category == "") {
                continue;
            }

            // 检索分类是否已存在
            $category_result = $category_model->get_item("name", $category);
            if ($category_result && $category_result->num_rows > 0) {
                $category_id = $category_result->fetch_object()->id;
            } else {
                $result = $category_model->insert(array("name" => $category))->execute();
                if ($result) {
                    $category_id = $category_model->get_last_id();
                }
            }
            if ($category_id !== false) {
                $book_category_data = array("book_id" => $book_id, "category_id" => $category_id);
                if ($book_category_model->insert($book_category_data)->execute()) {
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
        if (!$authors) {
            return true;
        }
        $authors = is_array($authors) ? $authors : explode(",", $authors);
        $author_model = new AuthorModel();
        $book_author_model = new DatabaseManipulate("books_authors");
        $processResult = false;
        $author_id = false;
        foreach($authors as $author) {
            $author = trim($author);

            if ($author == "") {
                continue;
            }

            // 检测作者是否已存在
            $author_query_result = $author_model->get_item("name", $author);
            if ($author_query_result && $author_query_result->num_rows > 0) {
                $author_id = $author_query_result->fetch_object()->id;
            } else {
                $author_result = $author_model->insert(array("name" => $author))->execute();

                if ($author_result) {
                    $author_id = $author_model->get_last_id();
                }
            }
            if ($author_id !== false) {
                $book_author_data = array("book_id" => $book_id, "author_id" => $author_id);
                if ($book_author_model->insert($book_author_data)->execute()) {
                    $processResult = true;
                }
            }
        }

        return $processResult;
    }

    public function update_category($book_id, $categories_raw) {
        $category_model = new TagModel();
        $book_category_model = new DatabaseManipulate("books_categories");

        // 获取书籍旧的分类数据
        $categories_old = array();
        $categories_old_result = $category_model->select("*", "books_categories, categories")
                                                ->where("books_categories.book_id=$book_id")
                                                ->where("books_categories.category_id=categories.id")
                                                ->execute();
        if ($categories_old_result) {
            for ( $i = 0; $i < $categories_old_result->num_rows; $i++) {
                $book_category = $categories_old_result->fetch_object();
                array_push($categories_old, $book_category->name);
            }
        }

        // 如果分类为空，执行删除操作
        if ($categories_raw == "") {
            $book_category_model->remove()->where("book_id='$book_id'");
        } else {
            $categories = explode(",", $categories_raw);

            // 剔除首尾空格
            foreach ($categories as &$category) {
                $category = trim($category);
            }

            // 删除旧的分类
            $categories_for_query = array_map(function($item) {
                return "'$item'";
            }, $categories);
            $categories_for_query = join(',', $categories_for_query);
            $category_model->remove("book_categories")
                            ->where("books_categories.book_id=$book_id ")
                            ->where("books_categories.category_id IN " .
                                    "(SELECT id FROM categories WHERE categories.name NOT IN ($categories_for_query))")
                            ->execute();

            // 新增的分类
            if (count($categories_old) > 0) {
                $categories_new = array();
                foreach($categories as $category_clean) {
                    if (!in_array($category_clean, $categories_old) && $category_clean != "") {
                        array_push($categories_new, $category_clean);
                    }
                }
            } else {
                $categories_new = $categories;
            }
            $this->add_category($book_id, $categories_new);
        }
    }

    public function update_author($book_id, $authors_raw) {
        $author_model = new AuthorModel("authors");
        $book_author_model = new DatabaseManipulate("books_authors");

        // 获取书籍旧的作者数据
        $authors_old = array();
        $authors_old_result = $author_model->select("*", "books_authors, authors")
                                            ->where("books_authors.book_id=$book_id")
                                            ->where("books_authors.author_id=authors.id")
                                            ->execute();
        if ($authors_old_result) {
            for ( $i = 0; $i < $authors_old_result->num_rows; $i++) {
                $book_author = $authors_old_result->fetch_object();
                array_push($authors_old, $book_author->name);
            }
        }

        // 如果作者为空，执行删除操作
        if ($authors_raw == "") {
            $book_author_model->remove()->where("book_id='$book_id'");
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
            $author_model->remove("books_authors")
                         ->where("books_authors.book_id=$book_id")
                         ->where("books_authors.author_id IN " .
                                    "(SELECT id FROM authors WHERE authors.name NOT IN ($authors_for_query))")
                         ->execute();

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
    public function handle_cover($cover) {
        // 封面存储路径
        define("DIR_COVER", "../assets/cover");

        // 上传的图片最大限制为2M
        define("MAX_SIZE", 2000000);

        if (!is_dir(DIR_COVER)) {
            mkdir(DIR_COVER);
        }

        // 允许的上传图片类型
        $allow_mimes = array("image/png", "image/jpeg", "image/gif");
        if ($cover["size"] == 0) {}
        if ($cover["size"] > MAX_SIZE) {
            //echo "图片大小必需小于2M";
            return "";
        }
        if (!in_array($cover["type"], $allow_mimes) && $cover["size"] != 0) {
            //echo "仅支持PNG, GIF和JPG格式的图片";
            return "";
        }
        $filename = md5($cover["name"]);
        if (!move_uploaded_file($cover["tmp_name"], DIR_COVER . '/' . $filename)) {
            //echo "图片上传失败";
            return "";
        } else {
            return $filename;
        }
    }
}