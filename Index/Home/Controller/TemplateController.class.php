<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 21:20
 */

namespace Home\Controller;


use Domain\Plan;
use Think\Controller;

class TemplateController extends Controller
{
    public function _initialize() {
        $this->addWidget('planTabList', Plan::$plan_map);
    }

    protected function alertError($errmsg, $url = '') {
        $url = empty($url) ? "window.history.back();" : "location.href=\"{$url}\";";
        echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
        echo "<script>function MyTips(){alert('{$errmsg}');{$url}}</script>";
        echo "</head><body onload='MyTips()'></body></html>";
        exit;
    }

    protected function echoError($errMsg) {
        if (IS_AJAX) {
            echo $errMsg;
            exit(0);
        } else {
            $this->error($errMsg);
        }
    }

    protected function auto_display($view = null, $layout = true) {
        layout($layout);
        $this->display($view);
    }

    protected function addWidget($name, $data) {
        $this->assign($name, $data);
    }

    protected function addWidgets($widgets) {
        foreach ($widgets as $name => $data) {
            $this->addWidget($name, $data);
        }
    }
}