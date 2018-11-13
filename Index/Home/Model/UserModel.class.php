<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 20:29
 */

namespace Home\Model;

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
            'is_show' => 1,
            'identity' => 0
        );
        return $this->queryAll($where, array('id'));
    }

    public function getAllStudent($filed = array()){
        $where = array(
            'status' => 0,
            'is_show' => 1,
            'identity' => 0
        );
        return $this->queryAll($where, $filed);
    }
}