<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/3/18 1:51 PM
 */

namespace Crawler\Controller;


use Basic\Log;

class UpdateSolvedController extends BaseController
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {

    }

    public function __call($name, $arguments) {
        $ojList = C('SUPPORT_INFO_OJ');
        $ojCrawlerName = C('OJ_TO_CRAWLER_NAME');

        if (!in_array($name, $ojList)) Log::warn("require: ask to crawler oj: {}, but not support", $name);
        $fetcherName = 'Crawler\\Fetcher\\'. $ojCrawlerName[$name] . 'Fetcher';

        $handle = new $fetcherName();
    }
}