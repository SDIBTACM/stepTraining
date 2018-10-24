<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-22 下午6:52
 */

namespace Admin\Model;

use Constant\DataTableConfig;

class UserModel extends BaseModel
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
        return DataTableConfig::USER;
    }

    protected function getPrimaryId() {
        return 'id';
    }

}