<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 11, 2018 09:54
 */


namespace Home\Business;


use Basic\Log;
use Home\Model\CategoryModel;
use Home\Model\PlanModel;
use Home\Model\PlanProblemModel;
use Home\Model\ProblemAcTimeModel;
use Home\Model\ProblemModel;
use Home\Model\UserModel;

class PlanBusiness
{
    public static function instance() {
        return new self;
    }

    public function isExistPlan($id) {
        return PlanModel::instance()->countNumber(array('id' => $id, 'status' => 0)) != 0;
    }

    public function getStudentAcTimeList($planId) {
        $problemIdList = $this->getProblemInPlan($planId);
        $studentIdList = $this->getStudentList();

        if (count($problemIdList) == 0|| count($studentIdList) == 0) return null;

        $where = array(
            'problem_id' => array('IN', $problemIdList),
            'user_id' => array('IN', $studentIdList),
        );

        $StudentProblemAcRaw = ProblemAcTimeModel::instance()->queryAll($where);

        $problemAcTimeList = array();

        foreach ($problemIdList as $problem) $problemAcTimeList[$problem] = array();

        foreach ($StudentProblemAcRaw as $item) {
            $problemAcTimeList[$item['problem_id']][$item['user_id']] = $item['ac_time'];
        }
        Log::debug('', $problemAcTimeList);
        return $problemAcTimeList;
    }

    private function getStudentList() {
        $res = UserModel::instance()->getAllStudentId();
        $ans = array();

        foreach ($res as $re) array_push($ans, $re['id']);
        return $ans;
    }

    public function getProblemByPlanId($planId) {
        $problemIdList = $this->getProblemInPlan($planId);
        if (count($problemIdList) == 0) return null;

        $where = array(
            'id' => array('IN', $problemIdList),
            'status' => 0,
        );

        $field = array('id', 'category_id', 'description', 'origin_oj', 'origin_id');

        $problemList = ProblemModel::instance()->queryAll($where, $field);

        return $problemList;
    }



    private function getProblemInPlan($planId) {
        $res = PlanProblemModel::instance()->queryAll(array('plan_id' => $planId), array('problem_id'));
        $ans = array();

        foreach ($res as $re) array_push($ans, $re['problem_id']);
        return $ans;
    }
}