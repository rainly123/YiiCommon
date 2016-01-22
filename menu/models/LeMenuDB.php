<?php
namespace menu\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use common\help\MODELHelper;
use member\models\LeAuthRule;
use member\models\LeMember;
/**
 * Created by PhpStorm.
 * User: congsheng
 * for:菜单数据库操作类
 * Date: 2015/11/17
 * Time: 16:27
 */
class LeMenuDB extends DBHelper
{

    /**
     * @param $param  菜单写入
     */
    function write($param)
    {
        if(!empty($param['id']))
        {
            $Menu = LeMenu::findOne($param['id']);
        }
        else
        {
            $Menu=new LeMenu();
        }
        $Menu->title=$param['title'];
        $Menu->sort=$param['sort'];
        $Menu->pid=$param['pid'];
        $Menu->url=$param['url'];
        $Menu->hide=$param['hide'];
        $Menu->is_dev=$param['is_dev'];
        $Menu->tip=$param['tip'];
        $Menu->group=$param['group'];
        if($Menu->validate()&& $Menu->save())
        {
            $this->success('保存成功','index');
        }
        else
        {
            $this->error($Menu->errors);
        }
    }


    /**
     * @return 获取树形菜单
     */
    function getTreeMenu()
    {
        $menus=LeMenu::find()->where('status=0')->asArray()->all();
        $TreeModel=new MODELHelper();
        $menus=$TreeModel->toFormatTree($menus);
        $menus = array_merge(array(0=>array('id'=>0,'title_show'=>'顶级菜单')), $menus);
        return $menus;
    }
    /**
     * @return array|\yii\db\ActiveRecord[]
     * 获取列表信息
     */
    function getList()
    {
        $map=array('status'=>0);
        $list=LeMenu::find()->where($map)->orderBy('sort asc')->asArray()->all();
        return $list;
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     * 获取排序数据
     */
    function getSortList($id='',$pid='')
    {
        if(is_array($id))
        {
            $id=array_unique($id);
            $id=is_array($id)?implode(',',$id):$id;
        }
        $map['status']=0;
        if(!empty($ids))
        {
            $map['id']='in ('.$ids.')';
        }
        else
        {
            if($pid !== '')
            {
                $map['pid'] = $pid;
            }
        }
        $list=LeMenu::find()->where($map)->orderBy('sort asc,id asc')->asArray()->all();
        return $list;
    }

    /**
     * @param string $ids
     * 排序
     */
   function Sort($ids='')
   {
       $ids=explode(',',$ids);
       foreach ($ids as $key=>$value){
           $Menu=LeMenu::findOne($value);
           $Menu->sort=$key+1;
           $res=$Menu->save();
       }
       if($res !== false){
           $this->success('排序成功！','index');
       }else{
           $this->error('排序失败！','index');
       }
   }
    /**
     * @param int $pid
     * @return object 根据pid获取菜单列表
     */
    function getListByPid($id=0,$title='')
    {
        $Model=new LeMenu();
        $map['status']=0;
        $all_menus=$Model->find()->asArray()->all();
        if(!empty($all_menus))
        {
            foreach($all_menus as $val)
            {
                $all_menu[$val['id']]=$val['title'];
            }
        }
        $map="status=0 AND pid=".$id;
        if($title!='')
        {
            $map.=" AND title like '%".$title."%' ";
        }
        $list=$Model->find()->where($map)->orderBy('sort asc,id asc')->asArray()->all();//菜单列表信息
        $this->int_to_string($list,array('hide'=>array(1=>'是',0=>'否'),'is_dev'=>array(1=>'是',0=>'否')));
        if($list) {
            foreach($list as &$key){
                if($key['pid']){
                    $key['up_title'] = $all_menu[$key['pid']];
                }
            }
        }
        $info_map=array('id'=>$id,'status'=>0);
        $info=$Model->find()->where($info_map)->asArray()->one();//菜单详情
        return array('list'=>$list,'data'=>$info);
    }

    /**
     * @param $id
     * @return 根据id获取菜单信息
     */
    function getInfoById($id)
    {
        $map['status']=0;
        $map['id']=$id;
        $info=LeMenu::find()->where($map)->asArray()->one();
        return $info;
    }

    /**
     * @param $id
     * 删除菜单信息信息
     */
    function Del($id)
    {
        $Model=new LeMenu();
        $update=array('status'=>1);
        $this->DelById($id,$update,$Model);
    }

    /**
     * @param $id
     * 修改状态
     */
    function editRow($id,$update)
    {
        $Model=new LeMenu();
        $this->ChangeById($id,$update,$Model);
    }
    /**
     * @param string $CurrentPath
     * @return mixed
     * 根据权限获取目录
     */
    function getMenus($CurrentPath='')
    {
        if(empty($menus)){
            // 获取主菜单
            $where['pid']   =   0;
            $where['hide']  =   0;
            $where['status']=0;
             if(!CommonHelper::C('DEVELOP_MODE')){ // 是否开发者模式
                 $where['is_dev']    =   0;
             }
            $menus['main']  = LeMenu::find()->where($where)->orderBy('sort asc')->asArray()->all();
            //若果是类容菜单，则调另一个方法
            $menus['child'] = array(); //设置子节点
            //高亮主菜单
            $current=LeMenu::find()->where("url like '%".$CurrentPath."%'")->asArray()->one();
            if($current){
                $nav = $this->getPath($current['id']);
                $nav_first_title = $nav[0]['title'];
                foreach ($menus['main'] as $key => $item) {
                    if (!is_array($item) || empty($item['title']) || empty($item['url']) ) {
                        $this->error('控制器基类$menus属性元素配置有误');
                    }
                    if( stripos($item['url'],MODULE_NAME)!==0 ){
                        $item['url'] = MODULE_NAME.'/'.$item['url'];
                    }
                    // 判断主菜单权限
                    if ( !IS_ROOT && !CommonHelper::checkRule($item['url'],UID,'='.LeAuthRule::RULE_MAIN) ) {
                        unset($menus['main'][$key]);
                        continue;//继续循环
                    }

                    // 获取当前主菜单的子菜单项
                    if($item['title'] == $nav_first_title){
                        $menus['main'][$key]['class']='current';
                        //生成child树
                        $groups=LeMenu::find()->where("pid = ".$item['id']."") ->distinct(true)->asArray()->all();
                        if($groups){
                            $groups = array_column($groups, 'group');
                        }else{
                            $groups =   array();
                        }

                        //获取二级分类的合法url
                        $where          =   array();
                        $where['pid']   =   $item['id'];
                        $where['hide']  =   0;
                         if(!CommonHelper::C('DEVELOP_MODE')){ // 是否开发者模式
                             $where['is_dev']    =   0;
                         }
                        $second_urls=LeMenu::find()->where($where)->asArray()->all();
                        $second_url=array();
                        if(!empty($second_urls))
                        {
                            foreach($second_urls as $val)
                            {
                                $second_url[$val['id']]=$val['url'];
                            }
                        }

                        if(!IS_ROOT){
                            // 检测菜单权限
                            $to_check_urls = array();
                            foreach ($second_url as $key=>$to_check_url) {
                                if( stripos($to_check_url,MODULE_NAME)!==0 ){
                                    $rule = MODULE_NAME.'/'.$to_check_url;
                                }else{
                                    $rule = $to_check_url;
                                }
                                if(CommonHelper::checkRule($rule,UID))
                                    $to_check_urls[] = $to_check_url;
                            }
                        }
                        // 按照分组生成子菜单树
                        foreach ($groups as $g) {
                            $map ="`group`='".$g."' ";// array('group'=>$g);
                            if(isset($to_check_urls)){
                                if(empty($to_check_urls)){
                                    // 没有任何权限
                                    continue;
                                }else{
                                    $map.=" AND url in ('".implode('\',\'',$to_check_urls)."') ";
                                }
                            }
                            $map.=" AND pid=".$item['id']." " ; //   $item['id'];
                            $map.= " AND hide=0 ";
                            $map.=" AND status=0 ";
                             if(!CommonHelper::C('DEVELOP_MODE')){ // 是否开发者模式
                                $map.= " AND is_dev=0 ";//   0;
                            }
                            $model=new LeMenu();
                            $menuList=$model::find()->where($map)->orderBy('sort asc')->asArray()->all();
                            $menus['child'][$g] =CommonHelper::list_to_tree($menuList, 'id', 'pid', 'operater', $item['id']);
                        }
                        if($menus['child'] === array()){
                            //$this->error('主菜单下缺少子菜单，请去系统=》后台菜单管理里添加');
                        }
                    }
                }
            }
            // session('ADMIN_MENU_LIST'.$controller,$menus);
        }
        return $menus;
    }

    /**
     * 当用户点击类容时获取菜单
     */
    public function getMenu($getcate_id=0)
    {
        //获取动态分类
//        $cate_auth  =   AuthGroupModel::getAuthCategories(UID);	//获取当前用户所有的内容权限节点
//        $cate_auth  =   $cate_auth == null ? array() : $cate_auth;
//        $cate       =   M('Category')->where(array('status'=>1))->field('id,title,pid,allow_publish')->order('pid,sort')->select();
        $cate=LeCategory::find()->where(array('status'=>1))->orderBy('pid,sort')->asArray()->all();
        //没有权限的分类则不显示
//        if(!IS_ROOT){
//            foreach ($cate as $key=>$value){
//                if(!in_array($value['id'], $cate_auth)){
//                    unset($cate[$key]);
//                }
//            }
//        }

        $cate           =   CommonHelper::list_to_tree($cate);	//生成分类树
        //获取分类id
        $cate_id  =   $getcate_id;
        //是否展开分类
        $hide_cate = false;
        if(ACTION_NAME != 'recycle' && ACTION_NAME != 'draftbox' && ACTION_NAME != 'mydocument'){
            $hide_cate  =   true;
        }

        //生成每个分类的url
        foreach ($cate as $key=>&$value){
            $value['url']   =   'article/index?cate_id='.$value['id'];
            if($cate_id == $value['id'] && $hide_cate){
                $value['current'] = true;
            }else{
                $value['current'] = false;
            }
            if(!empty($value['_child'])){
                $is_child = false;
                foreach ($value['_child'] as $ka=>&$va){
                    $va['url']      =   'article/index?cate_id='.$va['id'];
                    if(!empty($va['_child'])){
                        foreach ($va['_child'] as $k=>&$v){
                            $v['url']   =   'article/index?cate_id='.$v['id'];
                            $v['pid']   =   $va['id'];
                            $is_child = $v['id'] == $cate_id ? true : false;
                        }
                    }
                    //展开子分类的父分类
                    if($va['id'] == $cate_id || $is_child){
                        $is_child = false;
                        if($hide_cate){
                            $value['current']   =   true;
                            $va['current']      =   true;
                        }else{
                            $value['current'] 	= 	false;
                            $va['current']      =   false;
                        }
                    }else{
                        $va['current']      =   false;
                    }
                }
            }
        }
        return array('nodes'=>$cate,'cate_id'=>$cate_id);
        //TODO 回收站
    }


    //获取树的根到子节点的路径
    public function getPath($id){
        $path = array();
        $nav=LeMenu::find()->where('id='.$id.'')->asArray()->one();
        $path[] = $nav;
        if($nav['pid'] >1){
            $path = array_merge($this->getPath($nav['pid']),$path);
        }
        return $path;
    }

}