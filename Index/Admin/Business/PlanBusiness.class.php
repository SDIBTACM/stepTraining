<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 10, 2018 13:38
 */


namespace Admin\Business;


use Admin\Model\PlanModel;
use Basic\Log;
use Basic\Result;


class PlanBusiness
{
    public static function instance() {
        return new self;
    }

    public function save($planInfo) {
        Log::debug('',$planInfo);
        if ($planInfo['id']) {
            return $this->update($planInfo);
        } else {
            return $this->add($planInfo);
        }
    }

    private function update($planInfo) {
        if ($planInfo['name'] == null) {
            return Result::returnFailed('name no allow null');
        }

        $res = PlanModel::instance()->updateById($planInfo['id'], array('name' => $planInfo['name']));

        if ($res === false) {
            return Result::returnFailed('update fail');
        } else {
            return Result::returnSuccess();
        }
    }

    private function add($planInfo) {
        if ($planInfo['name'] == null) {
            return Result::returnFailed('name no allow null');
        }

        $res = PlanModel::instance()->insertData(array('name' => $planInfo['name']));

        if ($res === false) {
            return Result::returnFailed('insert fail');
        } else {
            return Result::returnSuccess();
        }
    }

    public function delete($id) {
        if (0 === PlanModel::instance()->countNumber(array('id' => $id, 'status' => '0'))) {
            return Result::returnFailed('can not find plan');
        }

        $res = $res = PlanModel::instance()->updateById($id, array('status' => -1));

        if ($res === false) {
            return Result::returnFailed('delete fail');
        } else {
            return Result::returnSuccess();
        }
    }

}