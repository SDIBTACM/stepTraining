<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 11/3/18 2:02 PM
 */

namespace Crawler\Controller;

class BaseController
{
    public function __construct() {
        ini_set('max_execution_time', '300');
        if (!IS_CLI) exit();
    }
}