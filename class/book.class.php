<?php

require_once("dbc.class.php");

class Book {
    private $title;
    private $author;
    private $isbn;
    private $category;
    private $douban_link;
    private $dbc;

    public function __construct() {
        $this->dbc = new DatabaseConnection("localhost", "root", "123456", "bookshelf");
    }

    /**
     * 添加书籍
     *
     * @param $title
     * @param $author
     * @param $isbn
     * @param $category
     * @param $douban_link
     */
    public function add($title, $author, $isbn, $category, $douban_link) {
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->category = $category;
        $this->douban_link = $douban_link;
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
     * 获取指定title的书籍
     * @param string $title
     */
    public function get($title) {}

    /**
     * 更新书籍
     *
     * @param $title
     * @param $author
     * @param $isbn
     * @param $category
     * @param $douban_link
     */
    public function update($title, $author, $isbn, $category, $douban_link) {}

    /**
     * 删除书籍
     *
     * @param $title
     */
    public function remove($title){}

    /**
     * 封面处理
     * @param $cover
     */
    protected function handleCover($cover) {}
}