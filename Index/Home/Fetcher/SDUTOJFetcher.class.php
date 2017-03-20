<?php
namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:34
 */
class SDUTOJFetcher extends AbsFetcherOJ
{
    protected function getSwitch() {
        return C('switch_SDUTOJ');
    }

    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    protected function getUserSolvePageUrl(Person $person) {
        return "http://acm.sdut.edu.cn/onlinejudge2/index.php/Home/User/standings?username=" . $person->getSdutojId();
    }

    /**
     * 从html中过滤出解决的题数
     * @param $html
     * @param Person $person
     * @return mixed
     */
    protected function filterSolve($html, Person $person) {
        $pattern = '|<tbody>[\s\S]*?<tr>[\s\S]*?<td>1</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>(\d+)</td>|';
        preg_match($pattern, $html, $solved);
        return isset($solved[1]) && !empty($solved[1]) ? $solved[1] : 0;
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
        return "sdutoj_solved";
    }
}