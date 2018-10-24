<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 01/12/2017 20:31
 */

namespace Basic;


class Result
{
    public $success;

    public $message;

    public $data;

    /**
     * Result constructor.
     * @param $success
     * @param $message
     * @param null $data
     */
    private function __construct($success, $message, $data) {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @return boolean
     */
    public function isSuccess() {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @return null
     */
    public function getData() {
        return $this->data;
    }

    public static function returnSuccess($message = "") {
        return new Result(true, $message, null);
    }

    public static function returnFailed($message = "", $data = null) {
        return new Result(false, $message, $data);
    }
}