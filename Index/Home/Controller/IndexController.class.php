<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 19:34
 */

namespace Home\Controller;

use Basic\Log;
use Home\Model\StudentSolvedNumModel;
use Home\Model\UserModel;

class IndexController extends TemplateController
{

    public function index() {
        $studentList = UserModel::instance()->getAllStudent(array('id', 'class', 'nick_name'));
        Log::debug('',$studentList);
        $supportOj = C('SUPPORT_OJ');
        $countList = array();

        foreach ($studentList as $student) {
            $countList[$student['id']] = $student;

            foreach ($supportOj as $oj) {
                $res = StudentSolvedNumModel::instance()->getLatestbyUserIdAndOj($student['id'], $oj);
                Log::debug('', $res);
                $countList[$student['id']][$oj] =
                    StudentSolvedNumModel::instance()->getLatestbyUserIdAndOj($student['id'], $oj)['num'];

            }
        }
        Log::debug('',$countList);
        $this->assign('student_list', $countList);
        $this->auto_display();
    }

    public function full() {
        $year = I('get.year', 0);
        $month = I('get.year', 0);
    }
}