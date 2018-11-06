<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:30
 */

namespace Crawler\Fetcher;
use Crawler\Common\Person;

class HDOJFetcher extends AbsFetcherOJ
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
        return 'http://acm.hdu.edu.cn/userstatus.php?user=' . $person->getAccountId();
    }

    /**
     * 从html中过滤出解决的题数
     * @param Person $person
     * @return mixed
     */
    protected function filterSolvePattern(Person $person) {
        return '|<tr><td>Problems Solved</td><td align=center>(\d+)</td></tr>|';
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
        return 'http://acm.hdu.edu.cn/status.php?&status=5&user='. $person->getAccountId() . '&pid='. $problemId;
    }

    /**
     * 从html中过滤出题目的解决结果
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function filterProblemStatusPattern(Person $person, $problemId) {
        return '|<tr align=center ><td.*?>.*?</td><td>(.*?)</td><td><font color=red>Accepted</font></td><td><a href=".*?">.*?</a></td><td>.*?</td><td>.*?</td><td>.*?</td><td>.*?</td><td class=fixedsize>.*?</td></tr>|';
    }

}