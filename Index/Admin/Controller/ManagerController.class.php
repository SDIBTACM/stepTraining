<?php
/**
 *
 * Created by Dream.
 * User: Boxjan
 * Datetime: 18-10-24 下午1:51
 */

namespace Admin\Controller;

use Admin\Business\CategoryBusiness;
use Admin\Business\ProblemBusiness;
use Admin\Business\StudentBusiness;
use Admin\Business\UserBusiness;
use Admin\Model\CategoryModel;
use Admin\Model\ProblemModel;
use Admin\Model\UserAccountModel;
use Admin\Model\UserModel;
use Basic\Log;


class ManagerController extends TemplateMustLoginController
{
    public function problem() {
        if (IS_POST) {
            $action = I('post.action');
            switch($action) {
                case 'save': {
                    $problemInfo = array(
                        'id' => I('post.id', 0),
                        'origin_id' => I('post.origin_id'),
                        'origin_oj' => I('post.origin_oj'),
                        'description' => I('post.description'),
                        'category_id' => I('post.category_id', 1),
                    );
                    $res = ProblemBusiness::instance()->save($problemInfo);
                    if (!$res->isSuccess()) {
                        //header('HTTP/1.0 400 Bad Request');
                        echo $res->getMessage();
                        Log::info('user: {}, request: save, status: fail, more info: {}, post: {}',
                            $this->userInfo['user_name'], $res->getMessage(), I('post.'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                case 'delete' : {
                    $id = I('post.id');
                    $res = ProblemBusiness::instance()->delete($id);

                    if (false === $res) {
                        //header('HTTP/1.0 400 Bad Request');
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
                    header('HTTP/1.0 400 Bad Request');
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
            $categoryResult = CategoryModel::instance()->queryAll($where, array('id', 'name'));
            $categoryList = array(); foreach ($categoryResult as $item) $categoryList[$item['id']] = $item['name'];

            $this->assign('title', 'Problem Management');
            $this->assign('category_list', $categoryList);
            $this->assign('category_list_json', json_encode($categoryList));
            $this->assign('problem_info', $result);
            $this->auto_display('problem');

        }
    }

    public function category() {
        if (IS_POST) {
            $action = I('post.action');
            switch($action) {
                case 'save': {
                    $categoryInfo['id'] = I('post.id');
                    $categoryInfo['name'] = I('post.name');
                    $res = CategoryBusiness::instance()->save($categoryInfo);

                    if (!$res->isSuccess()) {
                        //header('HTTP/1.0 400 Bad Request');
                        echo $res->getMessage();
                        Log::info('user: {}, request: save, status: fail, more info: {}, post: {}',
                            $this->userInfo['user_name'], $res->getMessage(), I('post.'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                case 'delete' : {
                    $id = I('post.id');
                    $res = CategoryBusiness::instance()->delete($id);

                    if (!$res->isSuccess()) {
                        //header('HTTP/1.0 400 Bad Request');
                        echo $res->getMessage();
                        Log::info('user: {}, request: save, status: fail, more info: {}, post: {}',
                            $this->userInfo['user_name'], $res->getMessage(), I('post.'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                default : {
                    header('HTTP/1.0 400 Bad Request');
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
            $this->assign('category_info', $result);
            $this->auto_display('category');
        }
    }

    public function user() {
        if (IS_POST) {
            $action = I('post.action');
            switch($action) {
                case 'save' : {
                    $userInfo['id'] = I('post.id', 0);
                    if (I('post.id', 0) == 0) $userInfo['user_name'] = I('post.user_name', null);
                    $userInfo['nick_name'] = I('post.nick_name', null);
                    if(I('post.password', null) != '') $userInfo['password'] = password_hash(
                        I('post.password', null), PASSWORD_DEFAULT);
                    $userInfo['status'] = I('post.status', 0);

                    $res = UserBusiness::instance()->save($userInfo);

                    if (!$res->isSuccess()) {
                        //header('HTTP/1.0 400 Bad Request');
                        echo $res->getMessage();;
                        Log::info('user: {}, request: save, status: fail, more info: {}, post: {}',
                            $this->userInfo['user_name'], $res->getMessage(), I('post.'));
                    } else {
                        echo 'success';
                    }

                    break;
                }
                case 'delete' : {
                    $id = I('post.id');
                    $res = UserBusiness::instance()->delete($id);

                    if (false === $res) {
                        //header('HTTP/1.0 400 Bad Request');
                        echo $res->getMessage();;
                        Log::info('user: {}, request: delete, status: fail, more info: {}',
                            $this->userInfo['username'], I('post.'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                default : {
                    log::info('User: {}, ip :{} give a wrong action: {}', $this->userInfo['user_name'], curIp(), $action);
                    header('HTTP/1.0 400 Bad Request');
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
            $this->assign('title', 'User Management');
            $this->assign('user_info', $result);
            $this->auto_display('user');
        }
    }

}