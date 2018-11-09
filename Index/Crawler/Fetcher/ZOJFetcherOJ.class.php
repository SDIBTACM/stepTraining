<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/9/18 8:12 PM
 */

namespace Crawler\Fetcher;


use Crawler\Common\Person;

class ZOJFetcherOJ extends AbsFetcherOJ
{

    protected function getUserSolvePageUrl(Person $person) {
        return 'http://acm.zju.edu.cn/onlinejudge/showUserStatus.do?handle=' . $person->getAccountId();
    }

    protected function filterSolvePattern(Person $person) {
        return '|<font size="3">AC Ratio:</font> <font.*?>(.*?)/.*?</font.>|';
    }

    protected function getUserProblemStatusPageUrl(Person $person, $problemId) {
        return 'http://acm.zju.edu.cn/onlinejudge/showRuns.do?contestId=1&problemCode=' . $problemId .
            '&handle=' . $person->getAccountId() . '&judgeReplyIds=5';
    }

    protected function filterProblemStatusPattern(Person $person, $problemId) {
        return'|<tr.*?>[\s\S]*?<td.*?>.*?</td>[\s\S]*?<td.*?>(.*?)</td>[\s\S]*?<td.*?>[\s\S]*?<span.*?>[\s\S]*?Accepted[\s\S]*?</span></td>[\s\S]*?<td.*?>.*?</td>[\s\S]*?<td.*?>.*?</td>[\s\S]*?<td.*?>.*?</td>[\s\S]*?<td.*?>.*?</td>[\s\S]*?<td.*?>.*?</td>[\s\S]*?</tr>|';
    }
}