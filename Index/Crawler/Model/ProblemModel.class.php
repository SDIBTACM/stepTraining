<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 21/03/2017 22:34
 */

namespace Crawler\Model;

class ProblemModel extends BaseModel
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
        return "problem";
    }

    protected function getPrimaryId() {
        return 'id';
    }

    public function getAllProblem() {
        $where = array(
            'status' => 0,
        );

        return $this->queryAll($where, array('id problem_id', 'origin_oj', 'origin_id'));
    }

    public function getProblemByOJName($name) {
        $where = array(
            'status' => 0,
            'origin_oj' => $name,
        );

        return $this->queryAll($where, array('id problem_id', 'origin_oj', 'origin_id'));
    }
}