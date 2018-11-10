<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 10, 2018 19:06
 */


namespace Admin\Business;


use Admin\Model\PlanProblemModel;
use Admin\Model\ProblemModel;
use Basic\Log;
use Basic\Result;
use Constant\DataTableConfig;

class PlanProblemBusiness
{
    public static function instance() {
        return new self;
    }

    public function getProblemList($oj, $cateId) {
        $where = array('status' => 0,);
        if ($oj) $where['origin_oj'] = $oj;
        if ($cateId) $where['category_id'] = $cateId;


        $field = array('id problem_id', 'description', 'category_id', 'origin_oj', 'origin_id');

        $problemList = ProblemModel::instance()->queryAll($where, $field);
        Log::debug('', $problemList);
        return $problemList;

    }

    public function getProblemSelected($oj, $cateId, $planId) {

        $problemList = $this->getProblemList($oj, $cateId);

        $problemIdArr = array('');
        if (is_array($problemIdArr) && !is_null($problemIdArr))
            foreach ($problemList as $item) array_push($problemIdArr, $item['problem_id']);

        $hasAddList = PlanProblemModel::instance()->queryData(
            array('problem_id' => array('IN', $problemIdArr), 'plan_id' => $planId), array('problem_id'));
        $hasAddId = array();

        foreach ($hasAddList as $item) array_push($hasAddId, $item['problem_id']);

        return $hasAddId;
    }

    public function add($plan_id, $problem_id) {
        if (0 == ProblemModel::instance()->countNumber(array('id' => $problem_id, 'status' => 0)))
            return Result::returnFailed('can not find the problem');

        if (0 != PlanProblemModel::instance()->countNumber(array('plan_id' => $plan_id, 'problem_id' => $problem_id)))
            return Result::returnFailed('problem has added in the plan');

        $res = PlanProblemModel::instance()->insertData(array('plan_id' => $plan_id, 'problem_id' => $problem_id));

        if ($res === false) {
            return Result::returnFailed('add fail');
        } else {
            return Result::returnSuccess();
        }
    }

    public function del($plan_id, $problem_id) {

        if (0 == ProblemModel::instance()->countNumber(array('id' => $problem_id, 'status' => 0)))
            return Result::returnFailed('can not find the problem');

        if (0 == PlanProblemModel::instance()->countNumber(array('plan_id' => $plan_id, 'problem_id' => $problem_id)))
            return Result::returnFailed('problem not add in the plan');

        $id = PlanProblemModel::instance()->queryOne(array('plan_id' => $plan_id, 'problem_id' => $problem_id), array('id'));
        $res = PlanProblemModel::instance()->delById($id['id']);

        if ($res === false) {
            return Result::returnFailed('del fail');
        } else {
            return Result::returnSuccess();
        }
    }
}