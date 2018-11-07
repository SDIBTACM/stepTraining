<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/3/18 1:51 PM
 */

namespace Crawler\Controller;
use Crawler\Common\Person;
use Crawler\Model\ProblemModel;
use Crawler\Model\StudentAccountModel;
use Crawler\Fetcher\POJFetcher;
use Crawler\Fetcher\HDOJFetcher;
use Crawler\Fetcher\BestCodeOJFetcher;
use Crawler\Fetcher\CodeForceOJFetcher;
use Crawler\Fetcher\SDIBTOJFetcher;
use Crawler\Fetcher\SDUTOJFetcher;

use Basic\Log;
use Crawler\Model\StudentSolvedNum;

class UpdateSolvedController extends BaseController
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $ojList = C('SUPPORT_OJ');
        foreach ($ojList as $oj) {
            Log::info("Now is fetching OJ: {} solved count", $oj);
            $this->$oj();
            Log::info("Now finished fetched OJ: {} solved count", $oj);
        }
    }

    public function __call($name, $arguments) {
        $ojList = C('SUPPORT_OJ');
        $ojCrawlerName = C('OJ_TO_CRAWLER_NAME');

        if (!in_array($name, $ojList)) Log::warn("require: ask to crawler oj: {}, but not support", $name);
        $fetcherName = 'Crawler\\Fetcher\\'. $ojCrawlerName[$name] . 'Fetcher';

        $handle = new $fetcherName();

        $stuAccountList = StudentAccountModel::instance()->getAccountByOJName($name);

        foreach($stuAccountList as $stu) {
            $res = $handle->getSolved(new Person($stu['user_id'], $stu['origin_id']));

            if ($res) {
                StudentSolvedNum::instance()->insertNew($stu['user_id'], $res, $name);
                Log::info("New record: { person: {}, catch: {}, ac num: {} }",
                    $stu['user_id'], $name, $res);
            }
        }
    }
}