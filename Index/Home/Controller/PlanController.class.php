<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 19:37
 */

namespace Home\Controller;

use Basic\Log;
use Home\Business\PlanBusiness;
use Home\Model\CategoryModel;
use Home\Model\PlanModel;
use Home\Model\UserModel;

class PlanController extends TemplateController
{
    public function index() {
        $planId = I('get.id', 1, 'intval');
        if (!PlanBusiness::instance()->isExistPlan($planId))
            $this->alertError('The Plan You find does not exist');
        $planInfo = PlanModel::instance()->getById($planId);

        $problemList = PlanBusiness::instance()->getProblemByPlanId($planId);
        $studentRaw = UserModel::instance()->getAllStudent();
        $studentAcList = PlanBusiness::instance()->getStudentAcTImeList($planId);
        $categoryRaw = CategoryModel::instance()->getAll();

        $studentList = array(); $i = 0;
        $stuIdHashId = array(); $idHashStuId = array();
        foreach ($studentRaw as $item) {
            $idHashStuId[$item['id']] = $i;
            $stuIdHashId[$i] = $item['id'];
            $studentList[$i++] = $item;
        }

        $categoryList = array();
        foreach ($categoryRaw as $item) $categoryList[$item['id']] = $item['name'];

        $this->assign('problem_list', $problemList);
        $this->assign('student_list', $studentList);
        $this->assign('id_to_stu', $stuIdHashId);
        $this->assign('student_ac_list', $studentAcList);
        $this->assign('category_list', $categoryList);
        $this->assign('title', $planInfo['name']);


        Log::debug('', $studentAcList);
        $this->auto_display();

    }


}