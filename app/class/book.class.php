<?php

require_once("dbc.class.php");

class Book {
    private $dbc;
    private $table = "books";

    public function __construct() {
        $this->dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    }

    /**
     * 添加书籍
     *
     * @param string $title
     * @param string $author
     * @param string $isbn
     * @param array $cover
     * @param string $category
     * @param string $douban_link
     * @return mixed
     */
    public function add($title, $author, $isbn, $cover, $category, $douban_link) {
        $result = $this->dbc->insert(
            $this->table,
            array("title", "author", "isbn", "category", "cover", "douban_link"),
            array($title, $author, $isbn, $category, $this->handleCover($cover), $douban_link)
        );

        return $result;
    }

    /**
     * 获取所有书籍
     *
     * @return mixed
     */
    public function all(){
        return $this->dbc->get($this->table);
    }

    /**
     * 获取指定key的书籍，key若为数字则用id检索，若为string则用title检索
     *
     * @param mixed $key (int)id 或者 (string)title
     * @return mixed
     */
    public function get($key) {
        $filter = gettype($key) == "string" ? "title = '$key'" : " id = $key";
        return $this->dbc->get($this->table, $filter, 1);
    }

    /**
     * 更新书籍
     *
     * @param string $id
     * @param string $title 标题
     * @param string $author 作者
     * @param string $isbn ISBN
     * @param string $category 分类
     * @param array $cover 封面（文件上传数组）
     * @param string $douban_link 豆瓣链接
     *
     * @return boolean 执行成功或者失败
     */
    public function update($id, $title, $author, $isbn, $category, $cover, $douban_link) {
        $cover = gettype($cover) == "array" ? $this->handleCover($cover) : $cover;
        $fields = array(
            "title" => $title,
            "author" => $author,
            "isbn" => $isbn,
            "category" => $category,
            "cover" => $cover,
            "douban_link" => $douban_link,
            "update_at" => date("Y-m-d H:i:s")
        );
        return $this->dbc->update($this->table, $fields, "id=$id");
    }

    /**
     * 删除书籍
     *
     * @param $id
     * @return boolean
     */
    public function remove($id) {
        return $this->dbc->remove($this->table, "id = $id");
    }

    /**
     * 封面处理
     * @param $cover
     * @return string
     */
    protected function handleCover($cover) {
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