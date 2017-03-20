<?php
namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:30
 */
class POJFetcher extends AbsFetcherOJ
{
    protected function getSwitch() {
        return C('switch_POJ');
    }

    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    protected function getUserSolvePageUrl(Person $person) {
        return 'http://poj.org/userstatus?user_id=' . $person->getPojId();
    }

    /**
     * 从html中过滤出解决的题数
     * @param Person $person
     * @return mixed
     */
    protected function filterSolvePattern(Person $person) {
        return "|<td align=center width=25%><a href=status\?result=0&user_id=" . $person->getPojId() . ">(\d+)</a></td>|";
    }

    /**
     * 获取某个学生某题状态页面的html信息
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function getUserProblemStatusPageUrl(Person $person, $problemId) {
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