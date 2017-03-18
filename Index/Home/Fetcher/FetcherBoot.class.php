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
            new BestCodeOJFetcher(),
            new CodeForceOJFetcher(),
            new HDOJFetcher(),
            new POJFetcher(),
            new SDUTOJFetcher()
        );
    }

    public function doGeneralFetch(Person $person) {
        $userScore = array();
        foreach (self::$fetchList as $fetcher) {
            if ($fetcher instanceof IFetcherOJ) {
                $userScore[$fetcher->getDbSolveKey()] = $fetcher->getSolved($person);
            }
        }
        dump($userScore);
        //todo updateDB($userScore, $person->getUserId());
    }

    public function fetchPageHtml(Person $person) {
        foreach (self::$fetchList as $fetcher) {
            if ($fetcher instanceof IFetcherOJ) {
                dump($fetcher->getUserInfo($person));
            }
        }
    }
}