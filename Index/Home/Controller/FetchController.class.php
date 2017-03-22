<?php
namespace Home\Controller;

use Domain\Plan;
use Home\Fetcher\FetcherBoot;
use Home\Model\ProblemModel;
use Home\Model\UserModel;
use Think\Controller;
use Think\Log;

class FetchController extends Controller
{
    public function _initialize() {
        $passwd = I('passwd', '');
        if ($passwd !== C("DB_PWD")) {
            Log::record("someone try to hack, passwd: " . $passwd, Log::ERR);
            exit;
        }
    }

    public function index() {
        echo "index test";
    }

    public function getUserSolved() {
        $personList = UserModel::instance()->getAllPersonOJList();
        Log::record("get user solved start", Log::INFO);
        foreach ($personList as $person) {
            FetcherBoot::instance()->doSolvedFetch($person);
            sleep(1);
        }
        Log::record("get user solved end", Log::INFO);
    }

    public function getProblemStatus() {
        $personList = UserModel::instance()->getAllPersonOJList();
        $problemIds = ProblemModel::instance()->getAllProblemIdList(Plan::POJ_PlAN_TYPE);
        Log::record("get problem status start", Log::INFO);
        foreach ($personList as $person) {
            foreach ($problemIds as $problemId) {
                FetcherBoot::instance()->doProblemFetch($person, $problemId, Plan::POJ_PlAN_TYPE);
                usleep(20000);
            }
        }
        Log::record("get problem status end", Log::INFO);
    }
}