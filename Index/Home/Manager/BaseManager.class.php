<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 21/03/2017 22:31
 */

namespace Home\Manager;


abstract class BaseManager
{
    protected function getDao() {
        return M($this->getTableName());
    }

    public function updateById($id, $data) {
        $where = array(
            'id' => $id
        );
        return $this->getDao()->where($where)->data($data)->save();
    }

    abstract protected function getTableName();

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