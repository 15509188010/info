<?php


namespace app\controller;


use app\BaseController;

class Miss extends BaseController
{

    public function index()
    {
        parent::buildJson('404',[],'not found router');
    }
}