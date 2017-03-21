<?php
namespace Home\Controller;
use Domain\Person;
use Home\Fetcher\FetcherBoot;
use Home\Manager\ProblemManager;
use Home\Manager\UserManager;
use Think\Controller;

class IndexController extends Controller {

    public function getUserSolved(){
        $personList = UserManager::instance()->getAllUser();
        foreach($personList as $person) {
            FetcherBoot::instance()->doSolvedFetch($person);
            sleep(1);
        }
    }

    public function getProblemStatus() {
        $personList = UserManager::instance()->getAllUser();
        $problemIds = ProblemManager::instance()->getAllProblemId(ProblemManager::POJ_TYPE);
        foreach ($personList as $person) {
            foreach ($problemIds as $problemId) {
                FetcherBoot::instance()->doProblemFetch($person, $problemId);
            }
        }
    }
}