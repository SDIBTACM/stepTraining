<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-24 下午5:07
 */

namespace Admin\Model;


use Constant\DataTableConfig;

class UserAccountModel extends BaseModel
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
        return DataTableConfig::USER_ACCOUNT;
    }
}
