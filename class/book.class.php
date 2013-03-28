<?php

class Book {
    private $title;
    private $author;
    private $isbn;
    private $category;
    private $douban_link;

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

    public function all(){}

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