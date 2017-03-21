<?php
namespace Home\Fetcher;

use Domain\Person;
use Home\Manager\ProblemManager;

/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 22:47
 */
class FetcherBoot
{
    private static $_instance = null;

    private static $fetchSolvedList = array();

    private static $fetchProblemStatusFetcher = null;

    private function __construct() {
    }

    private function __clone() {
    }

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
            self::initSolvedFetcher();
            self::initProblemFetcher();
        }
        return self::$_instance;
    }

    private static function initSolvedFetcher() {
        self::$fetchSolvedList = array(
            new BestCodeOJFetcher(),
            new CodeForceOJFetcher(),
            new HDOJFetcher(),
            new POJFetcher(),
            new SDUTOJFetcher()
        );
    }

    private static function initProblemFetcher() {
        self::$fetchProblemStatusFetcher = array(
            ProblemManager::POJ_TYPE => new POJFetcher()
        );
    }

    public function doSolvedFetch(Person $person) {
        $userScore = array();
        $userScore['user_id'] = $person->getUserId();
        foreach (self::$fetchSolvedList as $fetcher) {
            if ($fetcher instanceof IFetcherOJ) {
                $userScore[$fetcher->getDbSolveKey()] = $fetcher->getSolved($person);
            }
        }
        dump($userScore);
        //todo updateDB($userScore, $person->getUserId());
    }

    public function doProblemFetch(Person $person, $problemId, $ojType) {
        $fetcher = self::$fetchProblemStatusFetcher[$ojType];
        if ($fetcher instanceof IFetcherOJ) {
            $res = $fetcher->getProblemStatus($person, $problemId);
            dump("userId:" . $person->getUserId() . ", problemId:" . $problemId . ",ojType:" . $ojType . ",result:" . $res);
            // todo update or insert db
        }
    }
}