<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-20 下午4:40
 */

namespace Admin\Business;

use Admin\Model\UserModel;
use Basic\Result;
use Basic\Log;

class UserLoginBusiness
{
    public static function instance() {
        return new self;
    }

    public function checkUserPassword($username, $password) {
        if (is_null($username) || is_null($password)) {
            return Result::returnFailed("The username or password should not be empty!");
        }

        $userInfo = $this->getUserInfo($username);

        if (is_null($userInfo) || $userInfo === false) {
            Log::info('ip: {} try to login as user: {}, but it does not exist', curIp(), $username);
            return Result::returnFailed('The user does not exist');
        }

        if (!$this->checkAccountValid($userInfo)) {
            return Result::returnFailed("Your account is not valid, please connect with admin");
        }

        if (true === password_verify($password, $userInfo['password'])) {
            $this->_updatePasswordAfterLoginSuccess($userInfo['id'], $password);
            $this->initSessionInfo($userInfo);
            return Result::returnSuccess();
        } else {
            log::info('ip: {} try to login as user: {} with a wrong password', curIp(), $password);
            return Result::returnFailed('The password is incorrect');
        }
    }

    public function initSessionInfo($userInfo) {
        if (empty($userInfo['id'])) {
            return;
        }
        session('training.user_id', $userInfo['id']);
    }

    public function destroySessionInfo() {
        session('training.user_id', null);
        session('[destroy]');
    }

    private function _updatePasswordAfterLoginSuccess($user_id, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $res = UserModel::instance()->updateById($user_id, array('password' => $hash));
        if ($res === 0 || $res === false) {
            log::error("update user id: {} password fail!", $user_id);
            return false;
        } else {
            return true;
        }
    }

    private function getUserInfo($username) {
        return UserModel::instance()->queryOne(array("user_name" => $username));
    }

    private function checkAccountValid($userInfo) {
        if ($userInfo['status'] == '1' || $userInfo['identity'] == '0') {
            return false;
        }
        return true;
    }
}
