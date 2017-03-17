<?php
namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:35
 */
class CodeForceOJFilter implements FilterOJ
{
    public function getPageHtml() {
        // TODO: Implement getPageHtml() method.
    }

    public function getSolved(Person $person) {
        return 2;
    }

    public function getDbSolveKey() {
        return "cf_rating";
    }
}