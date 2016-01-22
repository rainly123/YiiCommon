<?php
namespace member\models;
use common\help\CommonHelper;
use common\help\DBHelper;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/4
 * Time: 17:07
 */
class LeEmailDB extends DBHelper
{
    /**
     * @return 获取邮件列表
     */
    function getList()
    {
        return LeEmail::find()->where(array('marks'=>0))->asArray()->all();
    }

    /**
     * @return 邮件数量
     */
    function getCount()
    {
        return LeEmail::find()->where(array('marks'=>0))->count();
    }

    /**
     * 发送邮件
     */
    function doSend($param)
    {
        if(empty($param['str_email']))
        {
           $this->error('参数错误,请联系管理员！');
        }
        $email=explode(',',$param['str_email']);
        $body=$this->getInfo($param['email_id'])['body'];
        $result=sendEmail($email,$param['subject'],$body);
        if($result)
        {
            $this->success('发送成功！');
        }
        else
        {
            $this->success('发送失败');
        }
    }
    //获取邮件详情
    function getInfo($id=0)
    {
        if($id==0)
        {
            $this->error('参数错误');
        }
        else
        {
            return LeEmail::find()->where(array('marks'=>0,'id'=>$id))->asArray()->one();
        }
    }


    /**
     * @param $param
     * 邮件信息写入
     */
    function Write($param)
    {
        if(empty($param['id']))
        {
            $Model=new LeEmail();
            $param['create_time']=CommonHelper::CurrentTime();
            $param['update_time']=CommonHelper::CurrentTime();
            $param['marks']=0;
        }
        else
        {
            $Model=LeEmail::findOne($param['id']);
            $param['update_time']=CommonHelper::CurrentTime();
        }
        $Model->attributes=$param;
        if($Model->validate()&&$Model->save())
        {
            $this->success('保存成功！','mail');
        }
        else
        {
            $this->error($Model->errors);
        }
    }
    //删除邮件
    function DelEmail($ids)
    {
       $update=array('marks'=>1);
       $modle=new LeEmail();
       $this->DelById($ids,$update,$modle,'mail') ;
    }
}
