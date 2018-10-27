<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-20 下午3:59
 */

namespace Admin\Controller;


use Admin\Business\UserLoginBusiness;

class UserController extends TemplateController
{

    public function index() {
        $this->redirect('Admin');
    }

    public function login() {
        if ($this->isLogin()) {
            $this->alertError('您已经登陆!', U('/Admin'));
        }
        if (IS_POST) {
            return $this->doLogin();
        } else {
            $this->assign('title', 'Step training login');
            $this->display('login');
            return true;
        }

    }

    private function doLogin() {
        $username = I('post.username');
        $password = I('post.password');
        $result = UserLoginBusiness::instance()->checkUserPassword($username, $password);
        if (!$result->success) {
            $this->alertError($result->getMessage());
        } else {
            redirect(U('/Admin'));
        }
    }

    public function logout() {
        $this->isLogin();
        return $this->doLogout();
    }

    private function doLogout() {
        session('user_id', null);
        session('[destroy]');
        $this->success('', U('Home/Index/index'));
    }
}