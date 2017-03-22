<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 21/03/2017 22:34
 */

namespace Home\Manager;


class ProblemManager extends BaseManager
{
    private static $_instance = null;

    private function __construct() {
    }

    private function __clone() {
    }

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    protected function getTableName() {
        return "problem";
    }
}