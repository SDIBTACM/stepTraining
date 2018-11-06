<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/3/18 1:57 PM
 */

namespace Crawler\Model;


use Constant\DataTableConfig;

class StudentAcTimeModel extends BaseModel
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

    public function insertNew($stuId, $proId, $acTime) {

        $data = array(
            'user_id' => $stuId,
            'problem_id' => $proId,
            'ac_time' => date("Y-m-d H:i:s", strtotime($acTime)),
        );

        return $this->insertData($data);
    }
}