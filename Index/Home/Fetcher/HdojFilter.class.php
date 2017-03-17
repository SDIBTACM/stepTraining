<?php
namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:30
 */
class HDOJFilter implements  FilterOJ
{
    public function getPageHtml() {
        // TODO: Implement getPageHtml() method.
    }

    public function getSolved(Person $person) {
        return 3;
    }

    public function getDbSolveKey() {
        return "hdoj_solved";
    }
}