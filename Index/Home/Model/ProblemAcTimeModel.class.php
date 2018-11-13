<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 11, 2018 10:05
 */


namespace Home\Model;


use Constant\DataTableConfig;

class ProblemAcTimeModel extends BaseModel
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
        return DataTableConfig::PROBLEM_AC_TIME;
    }

    protected function getPrimaryId() {
        return 'id';
    }


}