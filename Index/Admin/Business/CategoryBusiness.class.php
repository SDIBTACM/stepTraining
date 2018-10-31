<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-29 下午6:00
 */

namespace Admin\Business;


use Admin\Model\CategoryModel;
use Basic\Result;

class CategoryBusiness
{
    public static function instance() {
        return new self;
    }

    public function save($categoryInfo) {
        if ($categoryInfo['name'] == null) return Result::returnFailed('field name not allowed to be empty');
        if ($categoryInfo['id']) {
            $res = CategoryModel::instance()->updateById($categoryInfo['id'], $categoryInfo);
            if ($res === false) {
                return Result::returnFailed('update fail');
            } else {
                return Result::returnSuccess();
            }
        } else {
            $res = CategoryModel::instance()->insertData($categoryInfo);
            if ($res === false) {
                return Result::returnFailed('insert new fail!');
            } else {
                return Result::returnSuccess();
            }
        }
    }

    public function delete($id) {
        if ($id == 1) {
            return Result::returnFailed('not allow to delete');
        }
        $res = CategoryModel::instance()->updateById($id, array('status' => -1));
        if ($res === false) {
            return Result::returnFailed('update fail');
        } else return Result::returnSuccess();
    }
}