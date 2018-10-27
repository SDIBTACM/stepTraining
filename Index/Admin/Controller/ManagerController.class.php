<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-24 下午1:51
 */

namespace Admin\Controller;


use Admin\Business\StudentBusiness;
use Admin\Model\CategoryModel;
use Admin\Model\ProblemModel;
use Admin\Model\UserAccountModel;
use Admin\Model\UserModel;
use Basic\Log;
use Basic\Result;

class ManagerController extends TemplateMustLoginController
{
    public function student() {
        if (IS_POST) {
            $action = I('post.action');

            switch($action) {
                case 'save': {
                    $supportOj = C('SUPPORT_OJ');
                    $studentInfo['id'] = I('post.id', 0);
                    $studentInfo['nick_name'] = I('post.nick_name');
                    $studentInfo['is_show'] = I('post.is_show', 0);
                    $studentInfo['is_update'] = I('post.is_update', 0);
                    foreach ($supportOj as $item) {
                        if (I('post.' . $item, null)) {
                            $studentInfo[$item] = I('post.' . $item);
                        }
                    }
                    $res = StudentBusiness::instance()->save($studentInfo);

                    if (!$res->isSuccess()) {
                        header('HTTP/1.0 400 Bad Request');
                        echo 'fail';
                        Log::info('user: {}, request: save, status: fail, more info: {}, post: {}',
                            $this->userInfo['user_name'], $res->getMessage(), I('post.'));
                    } else {
                        echo $res->getMessage();
                    }
                    break ;

                }

                case 'delete' : {
                    $id = I('post.id');
                    $res = false;
                    if (UserModel::instance()->countNumber(array('id' => $id, 'identity' => '0'))) {
                        $res = UserModel::instance()->updateById($id, array('status' => -1));
                    }
                    if (false === $res) {
                        header('HTTP/1.0 400 Bad Request');
                        echo 'fail';
                        Log::info('user: {}, request: delete, status: fail, more info: {}',
                            $this->userInfo['user_name'], I('post.'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                default : {
                    log::info('User: {}, ip :{} give a wrong action: {}', $this->userInfo['user_name'], curIp(), $action);
                    echo 'fail';
                    break;
                }
            }
            return ;

        } else {
            $where = array(
                'identity' => 0,
                'status' => 0,
            );
            $field = array(
                'id',
                'nick_name',
                'is_update',
                'is_show',
            );
            $supportOj = C('SUPPORT_OJ');

            $studentResult = UserModel::instance()->queryAll($where, $field);
            $studentInfo = array();
            foreach ($studentResult as $item) {
                $studentInfo[$item['id']] = $item;
                $account = UserAccountModel::instance()->queryAll(
                    array('user_id' => $item['id']),
                    array('origin_oj', 'origin_id'));

                foreach ($account as $value) {
                    if (in_array($value['origin_oj'], $supportOj)) {
                        $studentInfo[$item['id']][$value['origin_oj']] = $value['origin_id'];
                    }
                }
            }
            Log::debug("",$studentInfo);
            $this->assign('student_info', $studentInfo);
            $this->assign('title', 'Student Management');
            $this->auto_display('student');
        }
    }

    public function problem() {
        if (IS_POST) {
            $action = I('post.action');
            switch($action) {
                case 'save': {

                }
                case 'delete' : {
                    $id = I('post.id');
                    $res = ProblemModel::instance()->updateById($id, array('status' => -1));
                    if (false === $res) {
                        echo 'fail';
                        Log::info('user: {}, request: delete, status: fail, more info: {}',
                            $this->userInfo['username'], I('post'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                default : {
                    log::info('User: {}, ip :{} give a wrong action: {}', $this->userInfo['user_name'], curIp(), $action);
                    echo 'fail';
                    break;
                }
            }
            return ;
        } else {
            $where = array(
                'status' => 0,
            );
            $result = ProblemModel::instance()->queryAll($where);
            $categoryList = CategoryModel::instance()->queryAll($where);
            log::debug('', $categoryList);

            foreach ($result as &$item) {
                $item['category_name'] = $categoryList[$item['category_id']]['name'];
            }
            $this->assign('title', 'Problem Management');
            $this->assign('problem_list', $result);
            log::debug('',$result);
            $this->auto_display('problem');

        }
    }

    public function category() {
        if (IS_POST) {
            $action = I('post.action');
            switch($action) {
                case 'save': {
                    break;
                }
                case 'delete' : {
                    $id = I('post.id');
                    $res = ProblemModel::instance()->updateById($id, array('status' => -1));
                    if (false === $res) {
                        echo 'fail';
                        Log::info('user: {}, request: delete, status: fail, more info: {}',
                            $this->userInfo['username'], I('post'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                default : {
                    log::info('User: {}, ip :{} give a wrong action: {}', $this->userInfo['user_name'], curIp(), $action);
                    echo 'fail';
                    break;
                }
            }
        } else {
            $where = array(
                'status' => '0',
            );
            $result = CategoryModel::instance()->queryAll($where);
            $this->assign('title', 'Category Management');
            $this->assign('category_list', $result);

        }
    }

    public function user() {
        if (IS_POST) {
            $action = I('post.action');
            switch($action) {
                case 'add': {

                    break ;
                }
                case 'update' : {

                    break;
                }
                case 'delete' : {
                    $id = I('post.id');
                    $res = false;
                    if (UserModel::instance()->countNumber(array('id' => $id, 'identity' => '0'))) {
                        $res = UserModel::instance()->updateById($id, array('status' => -1));
                    }
                    if (false === $res) {
                        echo 'fail';
                        Log::info('user: {}, request: delete, status: fail, more info: {}',
                            $this->userInfo['username'], I('post'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                default : {
                    log::info('User: {}, ip :{} give a wrong action: {}', $this->userInfo['user_name'], curIp(), $action);
                    echo 'fail';
                    break;
                }
            }
        } else {
            $where = array(
                'identity' => 1,
                'status' => array('NEQ', -1),
            );
            $filed = array(
                'id',
                'user_name',
                'nick_name',
                'status',
            );
            $result = UserModel::instance()->queryAll($where, $filed);
            $this->assign('title', 'User Manafement');
            log::debug('',$result);
            $this->assign('user_list', $result);
        }
    }
}