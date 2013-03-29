<?php

require_once("dbc.class.php");

class Book {
    private $dbc;

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
            "books",
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
        return $this->dbc->get("books");
    }

    /**
     * 获取指定key的书籍，key若为数字则用id检索，若为string则用title检索
     *
     * @param mixed $key (int)id 或者 (string)title
     * @return mixed
     */
    public function get($key) {
        $filter = gettype($key) == "string" ? "title = '$key'" : " id = $key";
        return $this->dbc->get("books", $filter, 1);
    }

    /**
     * 更新书籍
     *
     * @param string $title 标题
     * @param string $author 作者
     * @param string $isbn ISBN
     * @param string $category 分类
     * @param array $cover 封面（文件上传数组）
     * @param string $douban_link 豆瓣链接
     *
     * @return boolean 执行成功或者失败
     */
    public function update($title, $author, $isbn, $category, $cover, $douban_link) {
        $fields = array(
            "title" => $title,
            "author" => $author,
            "isbn" => $isbn,
            "category" => $category,
            "cover" => $this->handleCover($cover),
            "douban_link" => $douban_link,
            "update_at" => date("Y-m-d H:i:s")
        );
        $values = "";
        $result = $this->dbc->update("books", $fields, $values);
        return ($result && $result->num_rows > 0);
    }

    /**
     * 删除书籍
     *
     * @param $key
     * @return mixed
     */
    public function remove($key) {
        return $this->dbc->remove($key);
    }

    /**
     * 封面处理
     * @param $cover
     * @return string
     */
    protected function handleCover($cover) {
        return "";
    }
}