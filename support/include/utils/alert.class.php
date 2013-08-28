<?php

namespace minamo\utils;


/**
 * Class Alert
 * Alert类用于显示提示信息
 *
 * @package minamo\utils
 */
class Alert {
    private $modes = array(
        "info" => "alert-info",
        "warn" => "",
        "pass" => "alert-success",
        "error" => "alert-error"
    );

    private $is_display;
    private $mode;
    private $message;
    private $count;

    public function __construct() {
        $this->set_display(false);
        $this->set_mode("error");
        $this->message = "";
        $this->count = 0;
    }

    public function show() {
        $this->set_display(true);
    }

    public function hide() {
        $this->set_display(false);
    }

    public function is_display() {
        return $this->is_display;
    }

    public function set_display($is_display) {
        $this->is_display = $is_display;
    }

    public function get_mode() {
        return $this->mode;
    }

    public function set_mode($mode) {
        !array_key_exists($mode, $this->modes) and $mode = "info";
        $this->mode = $this->modes[$mode];
        return $this;
    }

    public function get_message() {
        return $this->message;
    }

    public function set_message($message) {
        $this->message = $message;
        return $this;
    }

    public function add_message($message) {
        $this->message = $this->message . $message;
        return $this;
    }
}