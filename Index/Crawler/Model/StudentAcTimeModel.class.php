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

    public function isExist($stuId, $proId) {
        $where = array(
            'user_id' => $stuId,
            'problem_id' => $proId,
        );
        
        return $this->countNumber($where) > 0 ? true : false;
    }

    public function getProblemIsAc($userId, $problemList) {
        $problemId = array();
        foreach ($problemList as $pro) array_push($problemId, $pro['problem_id']);

        $where = array(
            'problem_id' => array('IN', $problemId),
            'user_id' => $userId,
        );

        $query = $this->queryAll($where, array('problem_id'));

        $result = array();
        foreach ($query as $item) array_push($result, $item['problem_id']);
        return $result;
    }
}