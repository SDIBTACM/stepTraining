<?php
namespace Home\Fetcher;
use Domain\Person;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 22:47
 */
class FetcherBoot
{
    private static $_instance = null;

    private static $fetchList = null;

    private static $cnt = 0;

    private function __construct() {
    }

    private function __clone() {
    }

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
            self::initFetcher();
        }
        return self::$_instance;
    }

    private static function initFetcher() {
        self::$fetchList = array(
            new BestCodeOJFilter(),
            new CodeForceOJFilter(),
            new HDOJFilter(),
            new POJFilter(),
            new SDUTOJFilter()
        );
        self::$cnt++;
    }

    public function doFetch(Person $person) {
        $userScore = array();
        foreach (self::$fetchList as $fetcher) {
            if ($fetcher instanceof FilterOJ) {
                $userScore[$fetcher->getDbSolveKey()] = $fetcher->getSolved($person);
            }
        }
        dump($userScore);
        dump(self::$cnt);
        //todo updateDB($userScore, $person->getUserId());
    }
}