<?php
namespace Home\Controller;
use Domain\Person;
use Home\Fetcher\FetcherBoot;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        $person1 = new Person(1, 2, 3, 4, 5, 6);
        $person2 = new Person(7, 8, 9, 10, 11, 12);
        $personList = array($person1, $person2);

        foreach($personList as $person) {
            FetcherBoot::instance()->doFetch($person);
        }
    }
}