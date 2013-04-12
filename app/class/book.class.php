<?php

require_once("model.class.php");

/**
 * Book Model
 */
class Book extends Model{
    protected $table = "books";

    public function __construct() {
        parent::__construct($this->table);
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