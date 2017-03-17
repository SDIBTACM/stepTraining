<?php

namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:09
 */
interface FilterOJ
{
    public function getPageHtml();

    public function getSolved(Person $person);

    public function getDbSolveKey();
}