<?php
namespace common\help;
use yii\base\Model;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/17
 * Time: 17:43
 */
class DBHelper extends Model
{
    /**
     * @param $model 数据模型
     * @param string $condition 条件
     * @param string $order 排序
     * @return object/false 对象数组/null
     * 分页公业方法
     */
    function _list($model,$condition='',$order='',$group='',$page_size=10){
        $arrList = $model::find()->Where($condition);
        //数据分页
        $pagination = new Pagination([
            'defaultPageSize' => $page_size,
            'totalCount' => $arrList->count(),
        ]);
        $result = $arrList->orderBy($order)->groupBy($group)->offset($pagination->offset)->limit($pagination->limit) ->asArray()->all();
        $result=$this->int_to_string($result);
        $data = ['list' => $result, 'pagination' => $pagination];
        return $data;
    }

    /**
     * @param $id
     * 删除公共方法
     */
    function DelById($id,$update,$modle,$url='index')
    {
        if(empty($id))
        {
            $this->error('请选择要删除的项');
        }
        if(is_array($id))
        {
            $id=array_unique($id);
            $id=is_array($id)?implode(',',$id):$id;
        }
        $result=$modle::updateAll($update,'id in ('.$id.')');
        if($result)
        {
            $this->success('删除成功',$url);
        }
    }

    /**
     * @param $id
     * @param $update
     * @param $modle
     * 修改状态公共方法
     */
    function ChangeById($id,$update,$modle,$url='index',$msg=array('状态修改成功','状态修改失败'))
    {
        if(empty($id))
        {
            $this->error('请选择要修改的项');
        }
        if(is_array($id))
        {
            $id=array_unique($id);
            $id=is_array($id)?implode(',',$id):$id;
        }
        $result=$modle::updateAll($update,'id in ('.$id.')');
        if($result)
        {
            $this->success($msg[0],$url);
        }
        else
        {
            $this->success($msg[1],$url);
        }
    }
    /**
     * @param $data
     * @param array $map
     * @return array
     * 将查询出的数组进行映射转换
     */
    function int_to_string(&$data,$map=array('status'=>array(1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿'))) {
        if($data === false || $data === null ){
            return $data;
        }
        $data = (array)$data;
        foreach ($data as $key => $row){
            foreach ($map as $col=>$pair){
                if(isset($row[$col]) && isset($pair[$row[$col]])){
                    $data[$key][$col.'_text'] = $pair[$row[$col]];
                }
            }
        }
        return $data;
    }

    /**
     * @return array|string
     * @param string $msg 返回信息
     * @param bool $json 是否json数据
     * 成功返回方法
     */
    function success($msg='',$url='',$data='')
    {
        $message=array(
            'status'=>1,
            'data'=>$data,
            'url'=>$url,
            'info'=>$msg,
        );
        if(IS_AJAX)
        {
            echo json_encode($message);
            die();
        }
        else
        {
            return $message;
        }
    }


    /**
     * @return array|string
     * @param string $msg 返回信息
     * @param bool $json 是否json数据
     * 失败返回方法
     */
    function error($msg='',$url='',$json=true)
    {
        if(is_array($msg))
        {
            foreach($msg as $val)
            {
                $msg=$val[0];
                break;
            }
        }
        $message=array(
            'status'=>0,
            'info'=>$msg,
            'url'=>$url,
        );
        if($json)
        {
            echo json_encode($message);
            die();
        }
        else
        {
            return $message;
        }
    }


    /**
     * @param string $sql
     * 原生sql执行——添加
     */
    function sqlAdd($sql='')
    {
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        return $command->execute();
    }

    /**
     * @param string $sql
     * @return array
     * 原生sql执行——编辑
     */
    function sqlUpdate($sql='')
    {
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        return $command->execute();
    }
    /**
     * @param string $sql
     * @return array
     * 原生sql执行——删除
     */
    function sqlDelete($sql='')
    {
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        return $command->execute();
    }

    /**
     * @return 获取当前插入数据的id
     */
    function CurrentInsertId()
    {
        return \Yii::$app->db->getLastInsertID();
    }

    /**
     * @param $model 模型
     * @param string|array $map
     * @return 物理真删除
     */
    function RelDelete($model,$map)
    {
        $result= $model->deleteAll($map);
        return $result;
    }

    /**
     * @param string $sql
     * @return sql查询
     */
    function sqlSelect($sql='')
    {
        $connection=\Yii::$app->db;
        $command=$connection->createCommand($sql);
        $result=$command->queryAll();
        return $result;
    }

    /**
     * @param $ids
     * @param $model
     * 排序公共方法
     */
    function Sorts($ids,$model)
    {
        if(empty($ids))
        {
            $this->error('参数错误！');
        }
        $ids=explode(',',$ids);
        foreach ($ids as $key=>$value){
            $result=$model::findOne($value);
            $result->sort=$key+1;
            $res=$result->save();
        }
        if($res !== false){
            $this->success('排序成功！','index');
        }else{
            $this->error('排序失败！','index');
        }
    }

}