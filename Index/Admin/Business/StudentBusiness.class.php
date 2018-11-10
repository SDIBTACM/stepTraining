<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-27 上午6:05
 */

namespace Admin\Business;


use Admin\Model\UserAccountModel;
use Admin\Model\UserModel;
use Basic\Log;
use Basic\Result;

class StudentBusiness
{
    public static function instance() {
        return new self;
    }

    public function save($studentInfo) {
        $supportOj = C('SUPPORT_OJ');

        if ($studentInfo['id']) { // update
            $studentId = $studentInfo['id'];

            if (0 == UserModel::instance()->countNumber(array('id' => $studentId, 'identity' => '0', 'status' => 0))) {
                return Result::returnFailed('can not find user');
            }

            if (false === UserModel::instance()->updateById($studentId, $studentInfo)) {
                return Result::returnFailed('update failed');
            }

            foreach ($supportOj as $item) {
                if (!isset($studentInfo[$item])) continue;

                $res = UserAccountModel::instance()->queryOne(array(
                    'user_id' => $studentId,
                    'origin_oj' => $item,
                ), array('id'));

                $id = $res['id'];

                if ($id) {
                    $res = UserAccountModel::instance()->updateById($id,
                        array('origin_id' => $studentInfo[$item]));
                } else {
                    $res = UserAccountModel::instance()->insertData(array(
                        'user_id' => $studentId,
                        'origin_id' => $studentInfo[$item],
                        'origin_oj' => $item,
                    ));
                }

                if ($res === false) {
                    return Result::returnFailed('add user account fail');
                }
            }
            return Result::returnSuccess(json_encode($studentInfo));

        } else { // new
            $inputStuInfo = $studentInfo;
            $studentInfo['password'] = password_hash(
                hash_hmac('sha256', time(), mt_rand(1538634, 9684236)), PASSWORD_DEFAULT);
            $studentInfo['user_name'] = time();
            $studentInfo['register_time'] = date("Y-m-d H:i:s");

            $res = UserModel::instance()->insertData($studentInfo);
            if($res === false) return Result::returnFailed('new user fail');
            $studentId = $res;

            foreach ($supportOj as $item) {
                if(!isset($studentInfo[$item])) continue;
                $res = UserAccountModel::instance()->insertData(array(
                    'user_id' => $studentId,
                    'origin_id' => $studentInfo[$item],
                    'origin_oj' => $item,
                ));
                if ($res === false) {
                    return Result::returnFailed('add new user account fail');
                }
            }

            $inputStuInfo['id'] = $studentId;
            return Result::returnSuccess(json_encode($inputStuInfo));
        }
    }

    public function delete($id) {
        Log::debug('', $id);
        if (0 === UserModel::instance()->countNumber(array('id' => $id, 'identity' => '0'))) {
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