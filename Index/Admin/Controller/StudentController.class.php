<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 10, 2018 09:02
 */


namespace Admin\Controller;


use Admin\Business\StudentBusiness;
use Admin\Model\UserAccountModel;
use Admin\Model\UserModel;
use Basic\Log;

class StudentController extends TemplateMustLoginController
{
    public function index() {
        return $this->listAll();
    }

    private function listAll() {
        $where = array(
            'identity' => 0,
            'status' => 0,
        );
        $field = array(
            'id',
            'class',
            'nick_name',
            'is_update',
            'is_show',
        );
        $studentInfo = UserModel::instance()->queryAll($where, $field);
        $this->assign('student_info', $studentInfo);
        $this->assign('title', 'Student Management');
        $this->auto_display('list');
    }

    public function edit() {
        if (IS_POST) {
            $supportOj = C('SUPPORT_OJ');
            $studentInfo['id'] = I('post.id', 0);
            $studentInfo['nick_name'] = I('post.nick_name');
            $studentInfo['class'] = I('post.class');
            $studentInfo['is_show'] = I('post.is_show', 0);
            $studentInfo['is_update'] = I('post.is_update', 0);
            foreach ($supportOj as $item) {
                if (I('post.' . $item, null)) {
                    $studentInfo[$item] = I('post.' . $item);
                }
            }Log::debug('',$studentInfo);
            $res = StudentBusiness::instance()->save($studentInfo);

            if (!$res->isSuccess()) {
                //header('HTTP/1.0 400 Bad Request');
                echo $res->getMessage();
                Log::info('user: {}, request: save, status: fail, more info: {}, post: {}',
                    $this->userInfo['user_name'], $res->getMessage(), I('post.'));
            } else {
                echo 'success';
            }

        } else {
            $id = I('get.id');
            $supportOj = C('SUPPORT_OJ');
            $where = array(
                'identity' => 0,
                'status' => 0,
                'id' => $id,
            );
            $field = array(
                'id',
                'nick_name',
                'class',
                'is_update',
                'is_show',
            );
            $studentInfo = UserModel::instance()->queryOne($where, $field);

            $account = UserAccountModel::instance()->queryAll(
                array('user_id' => $studentInfo['id']),
                array('origin_oj', 'origin_id'));

            foreach ($account as $value) {
                if (in_array($value['origin_oj'], $supportOj)) {
                    $studentInfo[$value['origin_oj']] = $value['origin_id'];
                }
            }
            $this->assign('info', $studentInfo);
            $this->assign('title', 'Student Info Edit');
            $this->auto_display('edit', 'edit_layout');
        }


    }

    public function delete() {
        if (IS_POST) {
            $id = I('post.id');
            $res = StudentBusiness::instance()->delete($id);
            if (!$res->isSuccess()) {
                //header('HTTP/1.0 400 Bad Request');
                echo $res->getMessage();
                Log::info('user: {}, request: save, status: fail, more info: {}, post: {}',
                    $this->userInfo['user_name'], $res->getMessage(), I('post.'));
            } else {
                echo 'success';
            }
        }
    }

}