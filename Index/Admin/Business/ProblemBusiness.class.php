<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-29 下午6:00
 */

namespace Admin\Business;


use Admin\Model\ProblemModel;
use Basic\Result;

class ProblemBusiness
{
    public static function instance() {

    }

    public function save($problemInfo) {

    }

    public function delete($id) {
        $res = ProblemModel::instance()->updateById($id, array('status' => -1));
        if ($res === false) {
            return Result::returnFailed('update fail');
        } else return Result::returnSuccess();
    }
}