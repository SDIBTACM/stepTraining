<?php
/**
 * Dreaming, fixed later
 * I am not sure why this works but it fixes the problem.
 * User: Boxjan
 * Datetime: Nov 10, 2018 09:01
 */


namespace Admin\Controller;


use Admin\Business\PlanBusiness;
use Admin\Business\PlanProblemBusiness;
use Admin\Model\CategoryModel;
use Admin\Model\PlanModel;
use Admin\Model\PlanProblemModel;
use Admin\Model\ProblemModel;
use Basic\Log;

class PlanController extends TemplateMustLoginController
{
    public function index() {
        if (IS_POST) {
            return $this->post();
        } else {
            return $this->listAll();
        }
    }

    private function listAll() {
        $where = array(
            'status' => 0,
        );
        $field = array(
            'id',
            'name'
        );
        $planInfo = PlanModel::instance()->queryAll($where, $field);
        $this->assign('plan_info', $planInfo);
        $this->assign('title', 'Plan Management');
        $this->auto_display('list');
    }

    public function problem() {
        $planId = I('get.id', 0, 'intval');
        if ($planId == 0 || 0 == ProblemModel::instance()->countNumber(array('id' => $planId, 'status' => 0)))
            $this->alertError('no plan id');

        if(IS_POST) {
            $action = I('post.action', null);
            $problemId = I('post.pid', null, 'intval');
            if ($problemId == 0) {
                echo 'problem id is null';
                exit();
            }

            switch ($action) {
                case 'add': {
                    $res = PlanProblemBusiness::instance()->add($planId, $problemId);

                    if (!$res->isSuccess()) {
                        echo $res->getMessage();
                        Log::info('user: {}, request: add, status: fail, more info: {}, post: {}',
                            $this->userInfo['user_name'], $res->getMessage() ,I('post'));
                    } else {
                        echo 'success';
                    }
                    break;

                }
                case 'del': {
                    $res = PlanProblemBusiness::instance()->del($planId, $problemId);

                    if (!$res->isSuccess()) {
                        echo $res->getMessage();
                        Log::info('user: {}, request: delete, status: fail, more info: {}, post: {}',
                            $this->userInfo['user_name'], $res->getMessage(), I('post'));
                    } else {
                        echo 'success';
                    }
                    break;
                }
                default: {
                    log::info('User: {}, ip :{} give a wrong action: {}', $this->userInfo['user_name'], curIp(), $action);
                    header('HTTP/1.0 400 Bad Request');
                    echo 'fail';
                    break;
                }
            }

        } else {
            $supportOj  = C('SUPPORT_GET_AC_INFO_OJ');
            $oj = I('get.oj', null);
            if ($oj && !in_array($oj, $supportOj)) $this->alertError('Can find Oj');

            $categoryId = I('get.cate', null, 'intval');
            if ($categoryId && !CategoryModel::instance()->countNumber(array('id' => $categoryId, 'status' => '0')))
                $this->alertError('Can find category');

            $where = array(
                'status' => '0',
            );
            $categoryResult = CategoryModel::instance()->queryAll($where, array('id', 'name'));
            $categoryList = array(); foreach ($categoryResult as $item) $categoryList[$item['id']] = $item['name'];

            $problemList = PlanProblemBusiness::instance()->getProblemList($oj, $categoryId);
            $problemSelected = PlanProblemBusiness::instance()->getProblemSelected($oj, $categoryId, $planId);

            Log::debug('', $problemList, $problemSelected);

            $this->assign('problem_list', $problemList);
            $this->assign('problem_selected', $problemSelected);
            $this->assign('oj_list', $supportOj);
            $this->assign('category_list', $categoryList);
            $this->assign('title', 'Plan Problem Edit');
            $this->assign('selected', array('oj' => $oj,  'cate_id' => $categoryId));
            $this->auto_display('problem', 'edit_layout');
        }
    }

    private function post() {
        $action = I('post.action');
        switch($action) {
            case 'save': {
                $planInfo = array(
                    'id' => I('post.id', 0),
                    'name' => I('post.name'),
                );
                $res = PlanBusiness::instance()->save($planInfo);

                if (!$res->isSuccess()) {
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
                $res = PlanBusiness::instance()->delete($id);

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
                header('HTTP/1.0 400 Bad Request');
                echo 'fail';
                break;
            }
        }
        return ;
    }
}