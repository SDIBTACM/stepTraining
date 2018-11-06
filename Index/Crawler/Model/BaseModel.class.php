<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 21/03/2017 22:31
 */

namespace Crawler\Model;


abstract class BaseModel
{
    abstract protected function getTableName();

    abstract protected function getPrimaryId();

    protected function getDao() {
        return M($this->getTableName());
    }

    public function updateById($id, $data) {
        $key = $this->getPrimaryId();
        if ($key == null || empty($id) || empty($data)) {
            return null;
        }
        $where = array(
            $key => $id
        );
        return $this->getDao()->where($where)->data($data)->save();
    }

    public function insertData($data) {
        if (empty($data)) return 0;
        return $this->getDao()->add($data);
    }

    public function delById($id) {
        $key = $this->getPrimaryId();
        if ($key == null) {
            return 0;
        }
        $where = array(
            $key => $id
        );
        return $this->getDao()->where($where)->limit('1')->delete();
    }

    public function getById($id, $field = array()) {
        $key = $this->getPrimaryId();
        if ($key == null || empty($id)) {
            return null;
        }
        $where = array(
            $key => $id
        );
        return $this->getDao()->field($field)->where($where)->find();
    }

    public function countNumber($where, $field = null) {
        if ($field != null) {
            return $this->getDao()->where($where)->count($field);
        } else {
            return $this->getDao()->where($where)->count();
        }
    }

    public function queryOne($where, $field = array()) {
        if (empty($where)) {
            return null;
        }
        return $this->getDao()->field($field)->where($where)->find();
    }

    public function queryAll($where, $field = array(), $order = array()) {
        if (empty($where)) {
            return array();
        }
        if (empty($order)) {
            return $this->getDao()->field($field)->where($where)->select();
        } else {
            return $this->getDao()->field($field)->where($where)->order($order)->select();
        }
    }

}