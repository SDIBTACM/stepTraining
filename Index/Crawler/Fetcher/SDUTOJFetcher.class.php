<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:34
 */

namespace Crawler\Fetcher;
use Crawler\Common\Person;


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
        return "http://acm.sdut.edu.cn/onlinejudge2/index.php/Home/User/standings?username=" . $person->getAccountId();
    }

    /**
     * 从html中过滤出解决的题数
     * @param Person $person
     * @return mixed
     */
    protected function filterSolvePattern(Person $person) {
        return '|<tbody>[\s\S]*?<tr>[\s\S]*?<td>1</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>(\d+)</td>[\s\S]*?<td>.*?</td>|';
    }

    /**
     * 获取某个学生某题状态页面的html信息
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function getUserProblemStatusPageUrl(Person $person, $problemId) {
        return 'https://acm.sdut.edu.cn/onlinejudge2/index.php/Home/Solution/status?username=' . $person->getAccountId() . '&pid=' . $problemId . '&result=1';
    }

    /**
     * 从html中过滤出题目的解决结果
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function filterProblemStatusPattern(Person $person, $problemId) {
        return '|<tr.*?>[\s\S]*?<input.*?>[\s\S]*?<td>.*?</td>[\s\S]*?<td.*?>[\s\S]*?<a.*?>[\s\S]*?<span.*?>.*?</span>[\s\S]*?</a>[\s\S]*?</td>[\s\S]*?<td><a.*?>.*?</a></td>[\s\S]*?<td.*?>Accepted</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>.*?</td>[\s\S]*?<td>(.*?)</td>[\s\S]*?</tr>|';
    }

}