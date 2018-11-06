<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 17/03/2017 20:09
 */

namespace Crawler\Fetcher;
use Crawler\Common\Person;


interface IFetcherOJ
{
    /**
     * 获取某个学生某个oj上的解决题数
     * @param Person $person
     * @return mixed
     */
    public function getSolved(Person $person);

    /**
     * 获取某个学生某个oj上某道题的结果
     * @param Person $person
     * @param $problemId
     * @return mixed
     */
    public function getProblemStatus(Person $person, $problemId);

}