<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/6/18 6:47 PM
 */

namespace Crawler\Fetcher;

use Crawler\Common\Person;

class SDIBTOJFetcher extends AbsFetcherOJ
{

    protected function getUserSolvePageUrl(Person $person) {
        return 'http://acm.sdibt.edu.cn/JudgeOnline/userinfo.php?user=' . $person->getAccountId();
    }

    protected function filterSolvePattern(Person $person) {
        return '|Solved<td align=center><a href=.*?>(.*?)</a>|';
    }

    protected function getUserProblemStatusPageUrl(Person $person, $problemId) {
        return 'http://acm.sdibt.edu.cn/JudgeOnline/status.php?jresult=4&problem_id=' . $problemId . '&user_id=' . $person->getAccountId();
    }

    protected function filterProblemStatusPattern(Person $person, $problemId) {
        return '|<tr align=center class=\'evenrow\'><td>.*?<td>.*?<td>.*?<td>.*?Accepted.*?<td>.*?<td>.*?<td>.*?<td>.*?<td>(.*?)</tr>|';
    }
}