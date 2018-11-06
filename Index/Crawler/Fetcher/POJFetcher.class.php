<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:30
 */
namespace Crawler\Fetcher;

use Crawler\Common\Person;


class POJFetcher extends AbsFetcherOJ
{

    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    protected function getUserSolvePageUrl(Person $person) {
        if (empty($person->getAccountId())) {
            return null;
        }
        return 'http://poj.org/userstatus?user_id=' . $person->getAccountId();
    }

    /**
     * 从html中过滤出解决的题数
     * @param Person $person
     * @return mixed
     */
    protected function filterSolvePattern(Person $person) {
        return "|<td align=center width=25%><a href=status\?result=0&user_id=" . $person->getAccountId() . ">(\d+)</a></td>|";
    }

    /**
     * 获取某个学生某题状态页面的html信息
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function getUserProblemStatusPageUrl(Person $person, $problemId) {
        if (empty($person->getAccountId()) || empty($problemId)) {
            return null;
        }
        return "http://poj.org/status?problem_id=" . $problemId . "&user_id=" . $person->getAccountId() . "&result=0";
    }

    /**
     * 从html中过滤出题目的解决结果
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function filterProblemStatusPattern(Person $person, $problemId) {
        return "|<tr align=center><td>.*?</td><td><a href=userstatus\?user_id=.*?</a></td><td><a href=problem\?id=.*?</a></td><td><font color=blue>Accepted</font></td><td>.*?</td><td>.*?</td><td>.*?</td><td>.*?</td><td>(.*?)</td></tr>|";
    }

}