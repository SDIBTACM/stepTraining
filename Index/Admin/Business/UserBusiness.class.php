<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-29 下午5:59
 */

namespace Admin\Business;


use Admin\Model\UserModel;
use Basic\Result;

class UserBusiness
{
    public static function instance() {
        return new self;
    }

    public function save($userInfo) {
        if ($userInfo['id']) {
            return $this->update($userInfo);
        } else {
            return $this->add($userInfo);
        }
    }

    private function add($userInfo) {
        if(0 != UserModel::instance()->countNumber(array('user_name' => $userInfo['user_name'], 'identity' => '1')))
            return Result::returnFailed('Duplicate username');

        $userInfo['identity'] = 1;

        if (!isset($userInfo['password'])) return Result::returnFailed('Empty Password');

        $res = UserModel::instance()->insertData($userInfo);
        if ($res === false) {
            return Result::returnFailed('insert new fail!');
        } else {
            return Result::returnSuccess();
        }
    }

    private function update($userInfo) {
        if (0 == UserModel::instance()->countNumber(array('id' => $userInfo['id'], 'identity' => '1'))) {
            return Result::returnFailed('can not find user');
        }

        if (false === UserModel::instance()->updateById($userInfo['id'], $userInfo)) {
            return Result::returnFailed('update failed');
        }

        return Result::returnSuccess();
    }

    public function delete($id) {
        if (0 === UserModel::instance()->countNumber(array('id' => $id, 'identity' => '1'))) {
            return Result::returnFailed('can not find user');
        }

        $res = UserModel::instance()->updateById($id, array('status' => -1));
        if ($res === false) {
            return Result::returnFailed('delete fail');
        } else {
            return Result::returnSuccess();
        }
    }
}