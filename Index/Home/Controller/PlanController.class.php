<?php
/**
 * drunk , fix later
 * Created by Magic.
 * User: jiaying
 * Datetime: 22/03/2017 19:37
 */

namespace Home\Controller;

class PlanController extends TemplateController
{
    public function index() {
        $planType = I('get.type', 1);
        $this->auto_display();
    }
}