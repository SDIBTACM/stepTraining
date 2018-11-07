<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/3/18 1:53 PM
 */

namespace Crawler\Controller;


use Basic\Log;
use Crawler\Common\Person;
use Crawler\Model\ProblemModel;
use Crawler\Model\StudentAccountModel;
use Crawler\Model\StudentAcTime;
use Crawler\Fetcher\POJFetcher;
use Crawler\Fetcher\HDOJFetcher;
use Crawler\Fetcher\BestCodeOJFetcher;
use Crawler\Fetcher\CodeForceOJFetcher;
use Crawler\Fetcher\SDIBTOJFetcher;
use Crawler\Fetcher\SDUTOJFetcher;


class UpdateProblemStatusController extends BaseController
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $ojList = C('SUPPORT_GET_AC_INFO_OJ');
        foreach ($ojList as $oj) {
            Log::info("Now is fetching OJ: {} problem status", $oj);
            $this->$oj();
            Log::info("Now finished fetched OJ: {} problem status", $oj);
        }
    }

    public function __call($name, $arguments) {
        $ojList = C('SUPPORT_GET_AC_INFO_OJ');
        $ojCrawlerName = C('OJ_TO_CRAWLER_NAME');

        if (!in_array($name, $ojList)) Log::warn("require: ask to crawler oj: {}, but not support", $name);

        $problemList = ProblemModel::instance()->getProblemByOJName($name);

        $stuAccountList = StudentAccountModel::instance()->getAccountByOJName($name);

        $fetcherName = 'Crawler\\Fetcher\\'. $ojCrawlerName[$name] . 'Fetcher';

        $handle = new $fetcherName();

        foreach ($stuAccountList as $stu) {
            Log::info("Now is fetching student: {} {}", $name, $stu['origin_id']);
            $isProblemAc = StudentAcTimeModel::instance()->getProblemIsAc($stu['user_id'], $problemList);
            foreach ($problemList as $problem){
                if (in_array($problem['problem_id'], $isProblemAc)) return ;

                $res = $handle->getProblemStatus(new Person($stu['user_id'], $stu['origin_id']), $problem['origin_id']);
                
                if ($res) { 
                    StudentAcTimeModel::instance()->insertNew($stu['user_id'], $problem['problem_id'], $res);
                    Log::info("New record: {person: {}, catch: {} {} ac time: {} }", 
                        $stu['user_id'], $name, $problem['problem_id'], $res);
                }
            }
        }
    }

}