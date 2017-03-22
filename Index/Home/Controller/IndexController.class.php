<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 19:34
 */

namespace Home\Controller;

use Home\Model\UserModel;

class IndexController extends TemplateController
{

    public function index() {
        $grade = I('grade', 0);
        if ($grade == 0) {
            $grade = intval(date('Y'));
        }

        $res = UserModel::instance()->getAllUserByGrade($grade);
        $this->addWidget('userList', $res);
        $this->auto_display();
    }
}