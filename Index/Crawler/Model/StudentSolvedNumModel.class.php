<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/3/18 1:58 PM
 */

namespace Crawler\Model;


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

    public function insertNew($stuId, $num, $oj) {
        $data = array(
            'user_id' => $stuId,
            'num' => $num,
            'origin_oj' => $oj,
            'catch_time' => date("Y-m-d H:i:s"),
        );
        return $this->insertData($data);
    }

}