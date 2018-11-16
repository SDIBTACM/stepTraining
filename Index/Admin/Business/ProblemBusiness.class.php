<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-29 下午6:00
 */

namespace Admin\Business;


use Admin\Model\CategoryModel;
use Admin\Model\ProblemModel;
use Basic\Result;

class ProblemBusiness
{
    public static function instance() {
        return new self;
    }

    public function save($problemInfo) {

        if($problemInfo['origin_id'] == null || $problemInfo['origin_oj'] == null)
            return Result::returnFailed('field: origin id Or origin oj not allowed to be empty');

        $supportOj = C('SUPPORT_GET_AC_INFO_OJ');
        if (!in_array($problemInfo['origin_oj'], $supportOj)) return Result::returnFailed('do not support this oj');
        $count = ProblemModel::instance()->countNumber(array(
            'origin_id' => $problemInfo['origin_id'],
            'origin_oj' => $problemInfo['origin_oj'],
            'id' => array('NEQ', $problemInfo['id'])));

        if ($count != 0) {
            return Result::returnFailed('You have same problem with OJ and problem id');
        }

        $count = CategoryModel::instance()->countNumber(array('id' => $problemInfo['category_id'], 'status' => 0));
        if (!$count) {
            return Result::returnFailed('Where do you get this category..');
        }

        if ($problemInfo['id']) {
            $res = ProblemModel::instance()->updateById($problemInfo['id'], $problemInfo);
            if ($res === false) {
                return Result::returnFailed('Update fail');
            } else {
                return Result::returnSuccess();
            }
        } else {
            $res = ProblemModel::instance()->insertData($problemInfo);
            if ($res === false) {
                return Result::returnFailed('insert fail');
            } else {
                return Result::returnSuccess();
            }
        }

    }

    public function delete($id) {
        $res = ProblemModel::instance()->updateById($id, array('status' => -1));

        if ($res === false) {
            return Result::returnFailed('update fail');
        } else return Result::returnSuccess();
    }
}
