<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 27/11/2017 23:27
 */

namespace Admin\Controller;

use Admin\Model\UserModel;
use Think\Controller;

class TemplateController extends Controller
{
    protected $userInfo = null;

    protected $isNeedLogin = false;

    public function _initialize() {
        $this->initUserInfo();
        if ($this->isNeedLogin) $this->initLogin();
    }

    public function initUserInfo() {
        $this->_importUserInfoFromSession();
    }

    private function _importUserInfoFromSession() {
        $userId = session('user_id');
        if (!empty($userId)) {
            $this->userInfo = UserModel::instance()->getById($userId, array('user_name', 'nick_name', 'identity'));
            $this->userInfo['user_id'] = $userId;
            return true;
        } else {
            return false;
        }
    }

    public function initLogin() {
        if ($this->isLogin())
            return true;
        if (IS_GET) {
            header('HTTP/1.0 403 Forbidden');
            $this->alertError('您未登陆!', U('Admin/User/login'));
            exit();
        }
        else {
            header('HTTP/1.0 403 Forbidden');
            echo "please login first!";
            exit();
        }
    }

    public function isLogin() {
        return !empty($this->userInfo['user_id']);
    }

    protected function alertError($errMsg, $url = '') {
        $url = empty($url) ? "window.history.back();" : "location.href=\"{$url}\";";
        echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
        echo "<script>function myTips(){alert('{$errMsg}');{$url}}</script>";
        echo "</head><body onload='myTips()'></body></html>";
        exit;
    }

    protected function auto_display($view = null, $layout = true) {
        layout($layout);
        $this->display($view);
    }

    protected function addWidgets($widgets) {
        foreach ($widgets as $name => $data) {
            $this->assign($name, $data);
        }
    }

    public function _empty() {
        http_response_code(404);
        $this->alertError("404", U('Admin/Manager/student'));
    }

    protected function ajaxCodeReturn($code, $message, $data = array()) {
        $return = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
        $this->ajaxReturn($return, "JSON");
    }
}