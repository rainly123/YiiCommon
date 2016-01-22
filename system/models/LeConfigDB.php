<?php
namespace system\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/2
 * Time: 11:17
 */
class LeConfigDB extends DBHelper
{
    /**
     * @param null $name
     * @return null
     * 获取系统配置
     */
    function C($name=null)
    {
        if(!empty($name))
        {
            $query=new Query();
            $result= $query->select('value')->from('le_config')->where("name='".$name."'")->createCommand()->queryAll()[0];
            $result= explode(':',$result['value']);
            $lasturl=null;
            if(count($result)>1)
            {
                foreach($result as $key=>$val)
                {
                    if($key>0)
                    {
                        $val=CommonHelper::json_encode($val);
                        $arr=explode('\r\n',$val);
                        $url=$arr[0];
                        $url= str_replace('"','',$url);
                        $url=str_replace('\\','',$url);
                        $lasturl[$key]=$url;
                    }
                }
            }
            else
            {
                $lasturl=$result[0];
            }
            return $lasturl;
        }
        else
        {
            return null;
        }

    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * 通过id获取配置信息
     */
    function getInfo($id)
    {
        $map=array('id'=>$id);
        $info=LeConfig::find()->where($map)->asArray()->one();
        return $info;
    }

    /**
     * @param null $group
     * @return array|\yii\db\ActiveRecord[]
     * 获取配置信息列表
     */
    function getList($group=null)
    {
        $map=' `status`=1 ';
        if(!empty($group))
        {
            $map.=' AND `group`='.$group;
        }
        $list=LeConfig::find()->where($map)->orderBy('sort')->asArray()->all();
        return $list;
    }

    /**
     * @param string $ids
     * 排序
     */
    function Sort($ids='')
    {
        $ids=explode(',',$ids);
        $res=false;
        foreach ($ids as $key=>$value){
            $config=LeConfig::findOne($value);
            $config->sort=$key+1;
            $res=$config->save();
        }
        if($res !== false){
            $this->success('排序成功！','index');
        }else{
            $this->error('排序失败！','index');
        }
    }
    /**
     * @param null $group
     * @return object
     * 分页列表
     */
    function getListPage($group=null,$search='',$ids='')
    {
        $map=" `status`=1 ";
        if(!empty($group))
        {
            $map.=" AND `group`=".$group;
        }
        if($ids!='')
        {
            $map.=" AND id in (".$ids.") ";
        }
        if($search!='')
        {
            $map.=" AND name like '%".$search."%' OR title like '%".$search."%'";
        }

        $model=new LeConfig();
        $list=$this->_list($model,$map,'sort');
        return $list;
    }

    /**
     * @param $param
     * 配置添加更新操作
     */
    function write($param)
    {
        if(!empty($param['id']))
        {
            $config=LeConfig::findOne($param['id']);

        }
        else
        {
            $config=new LeConfig();
            $config->create_time=CommonHelper::CurrentTime(1);
        }
        $config->name=$param['name'];
        $config->title=$param['title'];
        $config->sort=$param['sort'];
        $config->group=$param['group'];
        $config->value=$param['value'];
        $config->extra=$param['extra'];
        $config->remark=$param['remark'];
        $config->status=1;
        $config->update_time=CommonHelper::CurrentTime(1);
        if($config->validate()&& $config->save())
        {
            $this->success('保存成功','index');
        }
        else
        {
            $this->error($config->errors);
        }
    }

    /**
     * @param $id
     * 删除配置信息
     */
    function Del($id)
    {
        $Model=new LeConfig();
        $update=array('status'=>0);
        $this->DelById($id,$update,$Model);
    }

    /**
     * @param $config
     * 修改网站设置
     */
    function Save($config)
    {
        if($config && is_array($config)){
            foreach ($config as $name => $value) {
                $map=array('name'=>$name);
                $Model =LeConfig::find()->where($map)->one();
                $Model->value=$value;
                $Model->save();
            }
        }
        $this->success('保存成功！','group');
    }
}