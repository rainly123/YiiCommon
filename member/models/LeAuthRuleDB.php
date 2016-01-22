<?php
namespace member\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use menu\models\LeMenu;
use yii\data\Pagination;

/**
 * Created by PhpStorm.
 * User: congsheng
 * for:权限管理
 * Date: 2015/11/26
 * Time: 11:40
 */
class LeAuthRuleDB extends DBHelper
{
    /**
     * 返回后台节点数据
     * @param boolean $tree    是否返回多维数组结构(生成菜单时用到),为false返回一维数组(生成权限节点时用到)
     * @retrun array
     *
     * 注意,返回的主菜单节点数组中有'controller'元素,以供区分子节点和主节点
     *
     * @author 朱亚杰 <xcoolcc@gmail.com>
     */
    final protected function returnNodes($tree = true){
        static $tree_nodes = array();
        if ( $tree && !empty($tree_nodes[(int)$tree]) ) {
            return $tree_nodes[$tree];
        }
        if((int)$tree){
//            $list =\Yii::$container->get('M_LeMenu')->getList();
            $list=LeMenu::find()->orderBy('sort asc')->asArray()->all();
            foreach ($list as $key => $value) {  //TODO 根据平台不同 是否考虑去掉admin
                if( stripos($value['url'],'admin')!==0 ){
                    $list[$key]['url'] = 'Admin'.'/'.$value['url'];
                }
            }
            $nodes = CommonHelper::list_to_tree($list,$pk='id',$pid='pid',$child='operator',$root=0);
            foreach ($nodes as $key => $value) {
                if(!empty($value['operator'])){
                    $nodes[$key]['child'] = $value['operator'];
                    unset($nodes[$key]['operator']);
                }
            }
        }else{
            $nodes = \Yii::$container->get('M_LeMenu')->getList();;
            foreach ($nodes as $key => $value) {
                if( stripos($value['url'],'admin')!==0 ){ //TODO 根据平台不同 是否考虑去掉admin
                    $nodes[$key]['url'] = 'Admin'.'/'.$value['url'];
                }
            }
        }
        $tree_nodes[(int)$tree]   = $nodes;
        return $nodes;
    }
    /**
     * 后台节点配置的url作为规则存入auth_rule
     * 执行新节点的插入,已有节点的更新,无效规则的删除三项任务
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function updateRules(){
        //需要新增的节点必然位于$nodes
        $nodes    = $this->returnNodes(false);

        $AuthRule = new LeAuthRule();
        $map      ="module='admin' and type in (1,2)";// array('module'=>'admin','type'=>array('in','1,2'));//status全部取出,以进行更新
        //需要更新和删除的节点必然位于$rules
        $rules=$AuthRule->find()->where($map)->orderBy('name')->asArray()->all();

        //构建insert数据
        $data     = array();//保存需要插入和更新的新节点
        foreach ($nodes as $value){
            $temp['name']   = $value['url'];
            $temp['title']  = $value['title'];
            $temp['module'] = 'admin';
            if($value['pid'] >0){
                $temp['type'] = LeAuthRule::RULE_URL;
            }else{
                $temp['type'] = LeAuthRule::RULE_MAIN;
            }
            $temp['status']   = 1;
            $data[strtolower($temp['name'].$temp['module'].$temp['type'])] = $temp;//去除重复项
        }
        $update = array();//保存需要更新的节点
        $ids    = array();//保存需要删除的节点的id
        foreach ($rules as $index=>$rule){
            $key = strtolower($rule['name'].$rule['module'].$rule['type']);
            if ( isset($data[$key]) ) {//如果数据库中的规则与配置的节点匹配,说明是需要更新的节点
                $data[$key]['id'] = $rule['id'];//为需要更新的节点补充id值
                $update[] = $data[$key];
                unset($data[$key]);
                unset($rules[$index]);
                unset($rule['condition']);
                $diff[$rule['id']]=$rule;
            }elseif($rule['status']==1){
                $ids[] = $rule['id'];
            }
        }
        if ( count($update) ) {
            foreach ($update as $k=>$row){
                if ( $row!=$diff[$row['id']] ) {
//                    $AuthRule->where(array('id'=>$row['id']))->save($row);
//                    $sqlstr="UPDATE le_auth_rule SET ";
                }
            }
        }
        if ( count($ids) ) {

            $updates=array('status'=>-1);
            $sqlstr= LeAuthRule::updateAll($updates,'id in ('.implode(',',$ids).')');      //"UPDATE le_auth_rule SET status=-1 WHERE id IN (".implode(',',$ids).")";
            $this->sqlUpdate($sqlstr);
            //删除规则是否需要从每个用户组的访问授权表中移除该规则?
        }
        if( count($data) ){
            foreach($data as $val)
            {
                $Auth=new LeAuthRule();
                $Auth->module=strtolower(C('MODULE_NAME'));
                $Auth->type=$val['type'];
                $Auth->name=$val['name'];
                $Auth->title=$val['title'];
                $Auth->status=1;
                $Auth->save();
            }
//            print_r($data);
//            die();
            //TODO 将data插入到数据库
        }
//        TODO 插入成功返回true,插入失败返回false
        return true;
    }

    /**
     * @param $group_id
     * @return array
     * 获取权限列表
     */
    function getRules($group_id)
    {
        $this->updateRules();
        $auth_group=$this->getGroupList();
        $node_list   = $this->returnNodes();
        $map         = array('module'=>'admin','type'=>LeAuthRule::RULE_MAIN);
        $main_rules  =LeAuthRule::find()->where($map)->asArray()->all();
        $main_rule=array();
        foreach($main_rules as $val)
        {
            $main_rule[''.$val['name'].'']=$val['id'];
        }
        $map         = array('module'=>'admin','type'=>LeAuthRule::RULE_URL);
        $child_rules =LeAuthRule::find()->where($map)->asArray()->all();
        $child_rule=array();
        foreach($child_rules as $val)
        {
            $child_rule[''.$val['name'].'']=$val['id'];
        }
        return array('main_rules'=>$main_rule,
                      'auth_rules'=>$child_rule,
                      'node_list'=>$node_list,
                      'auth_group'=>$auth_group,
                      'this_group'=>$auth_group[(int)$group_id]
                     );
    }
    /**
     * @param $data
     * 权限信息写入
     */
    function WriteGroup($data)
    {
        if(empty($data['id']))//添加权限组
        {
            if(empty($data['title']))
            {
                $this->error("权限组不能为空");
            }
            $AuthGroup=new LeAuthGroup();
            $AuthGroup->title=$data['title'];
            $AuthGroup->description=$data['description'];
            $AuthGroup->module='admin';
            $AuthGroup->type=LeAuthGroup::TYPE_ADMIN;
            if($AuthGroup->validate())
            {
                if($AuthGroup->save())
                {
                    $this->success('保存成功！','index');
                }
            }
            else
            {
                $this->error($this->errors);
            }
        }
        else
        {
            $AuthGroup=LeAuthGroup::findOne($data['id']);
            if(!empty($data['title']))
            {
                $AuthGroup->title=$data['title'];
            }
            if(!empty($data['description']))
            {
                $AuthGroup->description=$data['description'];
            }
            if(!empty($data['rules']))
            {
                sort($data['rules']);
                $data['rules'] = implode( ',' , array_unique($data['rules']));
                $AuthGroup->rules=$data['rules'];
            }
            if($AuthGroup->save())
            {
                $this->success("保存成功",'index');
            }
        }
    }

    /**
     * @param $group_id
     * @param int $page_size
     * @return array
     * 获取权限组用户
     */
    function getUserGroup($group_id,$page_size=10)
    {
        $sql = 'SELECT * FROM le_member a,le_auth_group_access b WHERE a.uid=b.uid and b.group_id='.$group_id;
        $connection = \Yii::$app->db;
        $command = $connection -> createCommand($sql);
        $data = $command -> queryAll();
        $pages = new Pagination([
            'defaultPageSize' => $page_size,
            'totalCount'=>count($data),
        ]);
        $list = \Yii::$app->db->createCommand($sql." limit ".$pages->limit." offset ".$pages->offset."")->queryAll();
        $list=$this->int_to_string($list);
        return array(
                    'user_list'=>$list,
                    'pages'=>$pages,
                     );

    }

    /**
     * @return array
     * 获取权限组列表
     */
    function getGroupList()
    {
        $auth_groups=LeAuthGroup::find()->where("status>=0 AND module='admin' AND type=".LeAuthGroup::TYPE_ADMIN)->asArray()->all();
        $auth_group=array();
        foreach($auth_groups as $val)
        {
            $auth_group[$val['id']]=$val;
        }
        return $auth_group;
    }








}