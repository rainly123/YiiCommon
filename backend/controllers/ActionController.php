<?php
namespace backend\controllers;
use common\help\CommonHelper;
use system\logic\LgLeActionLog;
use system\models\LeActionLog;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/30
 * Time: 11:11
 */
class ActionController extends AdminController
{
    function actionActionlog()
    {
        $ActionLog=new LgLeActionLog();
        $list=$ActionLog->getList();
        return $this->render('actionlog',['list'=>$list]);
    }

    function actionEdit()
    {
        $id=$this->getValue('id');
        $ActionLog=new LgLeActionLog();
        $info=$ActionLog->GetInfo($id);
        return $this->render('edit',['info'=>$info]);
    }

    //删除
    function actionRemove()
    {
        $ids=$this->getValue('ids');
        $ActionLog=new LgLeActionLog();
        $ActionLog->remove($ids);
    }

    function actionClear()
    {
        $ActionLog=new LgLeActionLog();
        $ActionLog->Clear();
    }

}
