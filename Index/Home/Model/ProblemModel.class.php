<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 19:39
 */

namespace Home\Model;


use Home\Manager\ProblemManager;

class ProblemModel
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

    public function getAllProblemIdList($planType) {
        $where = array('plan_type' => $planType);
        $field = array('oj_pid');
        $res = ProblemManager::instance()->queryAll($where, $field);
        $problemIds = array();
        foreach ($res as $r) {
            $problemIds[] = $r['oj_pid'];
        }
        return $problemIds;
    }
}