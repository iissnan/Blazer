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

    public function updateCategory($id, $category) {
        $category = trim($category);
        $category_model = new Model("categories");
        $book_category_model = new Model("books_categories");

        // 取书籍旧的分类数据
        $book_category_result = $category_model->getJoinItems(
            array("books_categories"),
            "books_categories.book_id=$id AND books_categories.category_id=categories.id"
        );

        // 如果分类为空，执行删除操作
        if ($category == "") {
            $book_category_model->remove("book_id='$id'");
        } else {
            // 执行更新操作
            $category_model->updateJoin(
                array("books_categories"),
                "books_categories.book_id=$id".
                    " AND books_categories.category_id=categories.id ",
                array("categories.name" => $category)
            );
        }

        // 处理书籍的旧分类数据：若旧的分类在books_categories里的引用为0，则在categories删除掉
        for ( $i = 0; $i < $book_category_result->num_rows; $i++) {
            $book_category = $book_category_result->fetch_object();
            $count_result = $book_category_model->total(
                "books_categories.category_id=categories.id AND categories.name='$book_category->name'",
                array("categories")
            );
            if ($count_result == 0) {
                $category_model->remove("name='$book_category->name'");
            }
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