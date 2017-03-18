<?php
namespace Home\Fetcher;
use Domain\Person;
use Home\Crawler\MCrawler;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:30
 */
class HDOJFetcher extends AbsFetcherOJ
{
    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    protected function getUserSolvePage(Person $person) {
        $url = 'http://acm.hdu.edu.cn/search.php?field=author&key=' . $person->getPojId();
        return MCrawler::instance()->execute($url);
    }

    /**
     * 从html中过滤出解决的题数
     * @param $html
     * @param Person $person
     * @return mixed
     */
    protected function filterSolve($html, Person $person) {
        // TODO: Implement filterSolve() method.
    }

    /**
     * 获取某个学生某题状态页面的html信息
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function getUserProblemStatusPage(Person $person, $problemId) {
        return null;
    }

    /**
     * 从html中过滤出题目的解决结果
     * @param $html
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function filterProblemStatus($html, Person $person, $problemId) {
        return null;
    }


    public function getDbSolveKey() {
        return "hdoj_solved";
    }
}