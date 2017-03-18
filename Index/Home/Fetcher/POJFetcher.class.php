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
class POJFetcher extends AbsFetcherOJ
{
    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    protected function getUserSolvePage(Person $person) {
        $url = 'http://poj.org/searchuser?key=' . $person->getPojId() .' &B1=Search';
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
        // TODO: Implement getUserProblemStatusPage() method.
    }

    /**
     * 从html中过滤出题目的解决结果
     * @param $html
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function filterProblemStatus($html, Person $person, $problemId) {
        // TODO: Implement filterProblemStatus() method.
    }

    public function getDbSolveKey() {
        return "poj_solved";
    }
}