<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-24 下午4:56
 */

namespace Home\Model;


use Constant\DataTableConfig;

class CategoryModel extends BaseModel
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
        return DataTableConfig::CATEGORY;
    }

    protected function getPrimaryId() {
        return 'id';
    }

    public function getAll($field = array()) {
        return $this->queryAll(array('status' => 0), $field);
    }
}