<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-24 下午1:51
 */

namespace Admin\Controller;


use Admin\Model\CategoryModel;
use Admin\Model\ProblemModel;
use Admin\Model\UserAccountModel;
use Admin\Model\UserModel;
use Basic\Log;

class ManagerController extends TemplateMustLoginController
{
    public function student() {
        if (IS_POST) {

        } else {
            $where = array(
                'identity' => 0,
                'status' => 0,
            );
            $field = array(
                'id',
                'nick_name',
                'is_update',
                'is_show',
            );
            $support_oj = C('SUPPORT_OJ');

            $studentResult = UserModel::instance()->queryAll($where, $field);
            $studentInfo = array();
            foreach ($studentResult as $item) {
                $studentInfo[$item['id']] = $item;
                $account = UserAccountModel::instance()->queryAll(
                    array('user_id' => $item['id']),
                    array('origin_oj', 'origin_id'));

                foreach ($account as $value) {
                    if (in_array($value['origin_oj'], $support_oj)) {
                        $studentInfo[$item['id']][$value['origin_oj']] = $value['origin_id'];
                    }
                }
            }
            Log::debug("",$studentInfo);
            $this->assign('student_info', $studentInfo);
            $this->assign('title', 'Student Management');
            $this->auto_display('student');
        }
    }

    public function problem() {
        if (IS_POST) {

        } else {
            $where = array(
                'identity' => 0,
            );
            $result = ProblemModel::instance()->queryAll($where);

        }
    }

    public function category() {
        if (IS_POST) {

        } else {
            $where = array(
                'identity' => 0,
            );
            $result = CategoryModel::instance()->queryAll($where);

        }
    }

    public function user() {
        if (IS_POST) {

        } else {
            $where = array(
                'identity' => 1,
            );
            $result = UserModel::instance()->queryAll($where);

        }
    }
}