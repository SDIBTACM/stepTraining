<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 11, 2018 10:06
 */


namespace Home\Model;


use Constant\DataTableConfig;

class StudentSolvedNumModel extends BaseModel
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
        return DataTableConfig::PROBLEM_AC_NUM;
    }

    protected function getPrimaryId() {
        return 'id';
    }
    public function getLatestByUserIdAndOj($userId, $oj) {
        return $this->getDao()->order('catch_time')->where(array('origin_oj' => $oj, 'user_id' => $userId))->limit(1)->select()[0];
    }
}