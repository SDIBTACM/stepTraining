<?php
namespace Crawler\Fetcher;

use Crawler\Common\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:38
 */
class BestCodeOJFetcher extends AbsFetcherOJ
{
    /**
     * 获取某个学生解决题数页面的html信息
     * @param Person $person
     * @return mixed
     */
    protected function getUserSolvePageUrl(Person $person) {
        return "http://bestcoder.hdu.edu.cn/rating.php?user=" . $person->getAccountId();
    }

    /**
     * 从html中过滤出解决的题数
     * @param Person $person
     * @return mixed
     */
    protected function filterSolvePattern(Person $person) {
        return "|<span class=\"text-muted\">RATING</span>[\s\S]*?<span class=\"bigggger\">(\d+)</span>|";

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
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    protected function filterProblemStatusPattern(Person $person, $problemId) {
        return null;
    }

}