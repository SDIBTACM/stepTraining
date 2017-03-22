<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 20:29
 */

namespace Home\Model;


use Domain\Person;
use Home\Manager\UserManager;

class UserModel
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

    public function getAllPersonOJList() {
        $field = array(
            'id', 'poj_id', 'hdoj_id', 'cf_id', 'bc_id'
        );
        $res = UserManager::instance()->queryAll(array(), $field);
        $personList = array();
        foreach($res as $r) {
            $personList[] = new Person($r['id'], $r['poj_id'], $r['hdoj_id'], null,
                $r['cf_id'], $r['bc_id']);
        }
        return $personList;
    }

    public function getAllUserByGrade($grade) {
        $where = array(
            'grade' => $grade
        );
        $field = array(
            'user_name', 'class_name', 'poj_solved', 'hdoj_solved', 'cf_rating', 'bc_rating'
        );

        return UserManager::instance()->queryAll($where, $field);
    }
}