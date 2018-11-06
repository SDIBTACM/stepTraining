<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 21/03/2017 22:31
 */

namespace Crawler\Model;

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

    public function getAllStudentId() {
        $where = array(
            'status' => 0,
            'is_update' => 1,
            'identity' => 0
        );
        return $this->queryAll($where, array('id'));
    }

}