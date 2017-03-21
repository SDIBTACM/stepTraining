<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 21/03/2017 22:34
 */

namespace Home\Manager;


class ProblemManager extends BaseManager
{
    private static $_instance = null;

    const POJ_TYPE = 1;

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
        return "problem";
    }

    public function getAllProblemId($type) {
        $where = array('oj_type' => $type);
        $field = array('oj_pid');
        $res = $this->getDao()->field($field)->where($where)->select();
        $problemIds = array();
        foreach ($res as $r) {
            $problemIds[] = $r['oj_pid'];
        }
        return $problemIds;
    }
}