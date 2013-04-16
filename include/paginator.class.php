<?php

/**
 * 分页类
 */
class Paginator {
    private $page;
    private $total;
    private $page_size;

    public function __construct($item_total, $page=1, $page_size=10) {
        $this->setPageSize($page_size);
        $this->setTotal($item_total, $page_size);
        $this->setPage($page);
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $page = intval($page);
        $page <= 0  and $page = 1;
        $page > $this->total and  $page = $this->total;
        $this->page = $page;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($items_total, $page_size) {
        $this->total = ceil($items_total / $page_size);
    }


    public function getPageSize() {
        return $this->page_size;
    }

    public function setPageSize($page_size) {
        $this->page_size = $page_size == 0 ? 10 : $page_size;
    }

    public function hasPagination() {
        return $this->total > 1;
    }

    public function __destruct() {
        // pass
    }
}