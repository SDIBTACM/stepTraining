<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-20 下午6:42
 */

namespace Admin\Model;

abstract class BaseModel
{
    /**
     * @return string table name
     */
    abstract protected function getTableName();

    /**
     * @return string primary id
     */
    abstract protected function getPrimaryId();

    /**
     * @return \Think\Model model
     */
    protected function getDao() {
        return M($this->getTableName());
    }

    /**
     * @param $data array
     * @return int|mixed exec result
     */
    public function insertData($data) {
        if (empty($data)) return 0;
        return $this->getDao()->add($data);
    }

    /**
     * @param $id mixed must be primary key
     * @return int|bool exec result
     */
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

    /**
     * @param $where mixed where
     * @return int|bool exec result
     */

    public function delByWhere($where) {
        if (is_null($where)) return false;
        return $this->getDao()->where($where)->delete();
    }

    /**
     * @param $id mixed must be primary key
     * @param array $field the field you want
     * @return mixed|null exec result
     */
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

    /**
     * @param $id mixed must be primary key
     * @param $data array the data will update
     * @return int|null exec result
     */
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

    public function updateByWhere($where, $data) {
        if ( empty($where) || empty($data)) {
            return null;
        }
        return $this->getDao()->where($where)->data($data)->save();
    }

    /**
     * @param $where array the condition
     * @param null $field
     * @return int|null count
     */
    public function countNumber($where, $field = null) {
        if ($field != null) {
            return $this->getDao()->where($where)->count($field);
        } else {
            return $this->getDao()->where($where)->count();
        }
    }

    /**
     * @param $where array the condition
     * @param array $field if not, will return all field
     * @return mixed|null
     */
    public function queryOne($where, $field = array()) {
        if (empty($where)) {
            return null;
        }
        return $this->getDao()->field($field)->where($where)->find();
    }

    /**
     * @param $where array the condition
     * @param array $field if not, will return all field
     * @param $order array|string the field and sequence will order by
     * @return array|mixed
     */
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

    /**
     * complex query
     * @param $query array the condition
     * @param array $field if not, will return all field
     * @return mixed
     */
    public function queryData($query, $field = array()) {
        $where = array();
        $dao = $this->getDao();
        foreach ($query as $k => $v) {
            $where[$k] = $query[$k];
            if ($k == "_logic" || $k == "_complex") {
                $where[$k] = $query[$k];
            }
        }

        $dao = $dao->field($field)->where($where);

        if (!empty($query['group'])) {
            $dao->group($query['group']);
        }

        if (!empty($query['order'])) {
            $dao->order($query['order']);
        }

        if (!empty($query['limit'])) {
            $dao->limit($query['limit']);
        }
        $res = $dao->select();
        return $res;
    }

}