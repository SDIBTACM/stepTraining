<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 21/03/2017 22:31
 */

namespace Home\Manager;


use Domain\Person;

class UserManager extends BaseManager
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
        return "user";
    }

    public function getAllUser() {
        $field = array(
            'id', 'poj_id', 'sdutoj_id', 'hdoj_id', 'cf_id', 'bc_id'
        );
        $res = $this->getDao()->field($field)->select();
        $personList = array();
        foreach($res as $r) {
            $personList[] = new Person($r['id'], $r['poj_id'], $r['hdoj_id'],
                $r['sdutoj_id'], $r['cf_id'], $r['bc_id']);
        }
        return $personList;
    }
}