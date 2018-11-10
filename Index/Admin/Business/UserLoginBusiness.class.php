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

        $userInfo = UserModel::instance()->queryOne(array("user_name" => $username));

        if (is_null($userInfo) || $userInfo === false || $userInfo['status'] == '1') {
            Log::info('ip: {} try to login as user: {}, but it does not exist', curIp(), $username);
            return Result::returnFailed('The user does not exist');
        }

        if ($userInfo['status'] == '1' || $userInfo['identity'] == '0') {
            return Result::returnFailed("You are not allow to login, please connect with admin");
        }

        if (true === password_verify($password, $userInfo['password'])) {
            $this->_updatePasswordAfterLoginSuccess($userInfo['id'], $password);
            session('training.user_id', $userInfo['id']);
            return Result::returnSuccess();
        } else {
            log::info('ip: {} try to login as user: {} with a wrong password', curIp(), $password);
            return Result::returnFailed('The password is incorrect');
        }

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
}