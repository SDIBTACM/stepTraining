<?php
namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:38
 */
class BestCodeOJFilter implements  FilterOJ
{
    public function getPageHtml() {
        // TODO: Implement getPageHtml() method.
    }

    public function getSolved(Person $person) {
        // TODO: Implement getSolved() method.
        return 1;
    }

    public function getDbSolveKey() {
        return "bc_rating";
    }
}