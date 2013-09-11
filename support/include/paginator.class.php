<?php

/**
 * 分页类
 */
class Paginator {
    private $page;
    private $total;
    private $page_size;

    /**
     * Constructor
     *
     * @param int $item_total
     * @param int $page
     * @param int $page_size
     */
    public function __construct($item_total, $page=1, $page_size=10) {
        $this->setPageSize($page_size);
        $this->setTotal($item_total, $page_size);
        $this->setPage($page);
    }

    /**
     * 获取页码
     *
     * @return int
     */
    public function getPage() {
        return $this->page;
    }

    /**
     * 设置页码（边界情况处理）
     *
     * @param $page
     */
    public function setPage($page) {
        $page = intval($page);
        $page <= 0 and $page = 1;
        $page > $this->total and  $page = $this->total;
        $this->page = $page;
    }

    /**
     * 获取总页数
     *
     * @return int
     */
    public function getTotal() {
        return $this->total;
    }

    /**
     * 计算总页数
     *
     * @param int $items_total
     * @param int $page_size
     */
    public function setTotal($items_total, $page_size) {
        $this->total = ceil($items_total / $page_size);
    }

    /**
     * 获取单页项目个数
     *
     * @return int
     */
    public function getPageSize() {
        return $this->page_size;
    }

    /**
     * 设置单页项目个数
     *
     * @param int $page_size
     */
    public function setPageSize($page_size) {
        $this->page_size = $page_size == 0 ? 10 : $page_size;
    }

    /**
     * 是否需要分页
     *
     * @return bool
     */
    public function hasPagination() {
        return $this->total > 1;
    }
}