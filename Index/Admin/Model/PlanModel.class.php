<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 10, 2018 08:25
 */


namespace Admin\Model;


use Basic\Log;
use Constant\DataTableConfig;

class PlanModel extends BaseModel
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
        return DataTableConfig::PLAN;
    }

    protected function getPrimaryId() {
        return 'id';
    }
}