<?php
namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:34
 */
class SDUTOJFilter implements FilterOJ
{
    public function getPageHtml() {
        // TODO: Implement getPageHtml() method.
    }

    public function getSolved(Person $person) {
        return 5;
    }

    public function getDbSolveKey() {
        return "sdutoj_solved";
    }
}