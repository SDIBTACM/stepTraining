<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/3/18 2:07 PM
 */

namespace Crawler\Model;

use Constant\DataTableConfig;

class StudentAccountModel extends BaseModel
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

    protected function getPrimaryId() {
        return 'id';
    }

    public function getAccountByOJName($name) {
        $res = UserModel::instance()->getAllStudentId();
        $stuId = array();
        foreach ($res as $item) array_push($stuId, $item['id']);
        $where = array(
            'user_id' => array('IN', $stuId),
            'origin_oj' => $name,
        );
        return $this->queryAll($where, array('user_id', 'origin_id', 'origin_oj'));
    }

    public function getAllAccount() {
        $res = UserModel::instance()->getAllStudentId();
        $stuId = array();
        foreach ($res as $item) array_push($stuId, $item['id']);
        $where = array(
            'user_id' => array('IN', $stuId),
        );
        return $this->queryAll($where, array('user_id', 'origin_id', 'origin_oj'));
    }


}