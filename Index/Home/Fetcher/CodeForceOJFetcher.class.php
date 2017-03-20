<?php
namespace Home\Fetcher;

use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:35
 */
class CodeForceOJFetcher extends AbsFetcherOJ
{
    protected function getSwitch() {
        return C('switch_CodeForceOJ');
    }

    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    protected function getUserSolvePageUrl(Person $person) {
        return 'http://codeforces.com/profile/' . $person->getCodeforceId();
    }

    /**
     * 从html中过滤出解决的题数
     * @param Person $person
     * @return mixed
     */
    protected function filterSolvePattern(Person $person) {
        return '|<span style=\"font-weight:bold;\" class=\"user-.*?\">(\d+)</span> <span|';
    }

    /**
     * 获取某个学生某题状态页面的html信息
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function getUserProblemStatusPageUrl(Person $person, $problemId) {
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
        return "cf_rating";
    }
}