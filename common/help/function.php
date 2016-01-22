<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/9
 * Time: 10:07
 */

/**
 * @param $value
 * @param $array
 * @return bool
 * 不区分大小写的inarray
 */
function in_array_case($value,$array){
    return in_array(strtolower($value),array_map('strtolower',$array));
}

/**
 *从配置文件中读取配置信息（区别于CommonHelper中的C方法）
 */
function C($name=null)
{
    if(!isset(Yii::$app->params[$name]))
    {
        return null;
    }
    return  Yii::$app->params[$name];
}

/**
 * @param null $uid
 * @return bool
 * 检测是否超管
 */
function is_administrator($uid = null)
{
    $uid = is_null($uid) ? isLogin() : $uid;
    return $uid && (intval($uid) === C('USER_ADMINISTRATOR'));
}


/**
 * @return 用户id
 * 判断用户是否登录
 */
function isLogin()
{
    $user=\common\help\CommonHelper::getSession('user_auth');
    if(!empty($user))
    {
        return $user['id'];
    }
    else
    {
        return 0;
    }
}

/**
 * @return null
 * 获取当前用户名
 */
function username()
{
    $user=\common\help\CommonHelper::getSession('user_auth');
    if(!empty($user))
    {
        return $user['username'];
    }
    else
    {
        return null;
    }
}
/**
 * 时间戳格式化(写在这而可以被回调函数访问)
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL,$format='Y-m-d H:i'){
    $time = $time === NULL ? NOW_TIME : intval($time);
    return date($format, $time);
}

// 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string) {
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}

//路径生成方法
function U($url='')
{
    if($url=='')
    {
        return Yii::$app->homeUrl.Yii::$app->controller->id.'/'.Yii::$app->controller->action->id;   //获取当前web路径
    }
    else
    {
        return Yii::$app->homeUrl.$url;
    }

}

/**
 * 获取对应状态的文字信息
 * @param int $status
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_status_title($status = null){
    if(!isset($status)){
        return false;
    }
    switch ($status){
        case -1 : return    '已删除';   break;
        case 0  : return    '禁用';     break;
        case 1  : return    '正常';     break;
        case 2  : return    '待审核';   break;
        default : return    false;      break;
    }
}

function show_status_op($status) {
    switch ($status){
        case 0  : return    '启用';     break;
        case 1  : return    '禁用';     break;
        case 2  : return    '审核';		break;
        default : return    false;      break;
    }
}

/**
 * 获取文档的类型文字
 * @param string $type
 * @return string 状态文字 ，false 未获取到
 * @author huajie <banhuajie@163.com>
 */
function get_document_type($type = null){
    if(!isset($type)){
        return false;
    }
    switch ($type){
        case 1  : return    '目录'; break;
        case 2  : return    '主题'; break;
        case 3  : return    '段落'; break;
        default : return    false;  break;
    }
}

/**
 * @param null $cate_id
 * @return \document\logic\获取文档类型
 */
function get_cate($cate_id = null)
{
    $Document=new \document\logic\LgLeDocument();
    $result=$Document->GetCate($cate_id);
    return $result;
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author congsheng <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 获取文档封面图片
 * @param int $cover_id
 * @param string $field
 * @return 完整的数据  或者  指定的$field字段值
 * @author huajie <banhuajie@163.com>
 */
function get_cover($cover_id, $field = null){
    if(empty($cover_id)){
        return false;
    }
    $picture = \system\models\LePicture::find()->where(array('status'=>1))->one();// M('Picture')->where(array('status'=>1))->getById($cover_id);
    return empty($field) ? $picture :strtolower($picture[$field]);
}

/**
 * @param $array
 * @return string
 * 生成树
 */
function Tree($array)
{
    $ul='';
    if(!empty($array)) {
        foreach ($array as $list) {
            $ul.= ' <dl class="cate-item">
        <dt class="cf">
        <form action="' . U('category/edit') . '" method="post">
            <div class="btn-toolbar opt-btn cf">
                <a title="编辑" href="' . U('category/edit?id=' . $list['id'] . '&pid=' . $list['pid']) . '">编辑</a>
                <a title="' . show_status_op($list['status']) . '" href="' . U('category/setstatus?ids=' . $list['id'] . '&status=' . abs(1 - $list['status'])) . '" class="ajax-get">' . show_status_op($list['status']) . '</a>
<a title="删除" href="' . U('category/remove?id=' . $list['id'] . '') . '" class="confirm ajax-get">删除</a>
<a title="移动" href="' . U('category/operate?type=move&from=' . $list['id']) . '">移动</a>
</div>
<div class="fold"><i></i></div>
<div class="order"><input type="text" name="sort" class="text input-mini" value="' . $list['sort'] . '"></div>
<div class="order">'.StatusToString($list['allow_publish']).'</div>
<div class="name">
    <span class="tab-sign"></span>
    <input type="hidden" name="id" value="' . $list['id'] . '">
    <input type="text" name="title" class="text" value="' . $list['title'] . '">
    <a class="add-sub-cate" title="添加子分类" href="' . U('category/add?pid=' . $list['id']) . '">
        <i class="icon-add"></i>
    </a>
    <span class="help-inline msg"></span>
</div>
</form>
</dt>';
            $ul.='<dd>';
            if(!empty($list['_']))
            {
                $ul.=Tree($list['_']);
            }
            $ul.='</dd>';
            $ul.='</dl>';
        }
    }
    return $ul;
}

/**
 * @param $status
 * @return string
 * 状态转字符
 */
function StatusToString($status)
{
    $string=$status?"是":"否";
    return $string;
}

/**
 * @param null $action
 * @param null $model
 * @param null $record_id
 * @param null $user_id
 * @return \system\logic\记录行为日志
 */
function action_log($action = null, $model = null, $record_id = null, $user_id = null)
{
    $LgAction=new \system\logic\LgLeAction();
    $result=$LgAction->action_log($action, $model , $record_id, $user_id);
    return $result;
}

/**
 * @param int $id
 * @return \document\logic\获取子文档数
 */
function get_subdocument_count($id=0)
{
    $Document=new \document\logic\LgLeDocument();
    $result=$Document->get_subdocument_count($id);
    return $result;
}

/**
 * @param $name
 * @return array|获取请求参数
 */
function I($name){
    $request = \Yii::$app -> request;
    $value = $request -> post($name);
    return empty($value) ? $request -> get($name) : $value;
}

/**
 * 获取文档模型信息
 * @param  integer $id    模型ID
 * @param  string  $field 模型字段
 * @return array
 */
function get_document_model($id = null, $field = null){
    static $list;

    /* 非法分类ID */
    if(!(is_numeric($id) || is_null($id))){
        return '';
    }

    /* 获取模型名称 */
    if(empty($list)){
        $map   = array('status' => 1, 'extend' => 1);
        $model =\system\models\LeModel::find()->where($map)->asArray()->all();  // M('Model')->where($map)->field(true)->select();
        foreach ($model as $value) {
            $list[$value['id']] = $value;
        }
    }

    /* 根据条件返回数据 */
    if(is_null($id)){
        return $list;
    } elseif(is_null($field)){
        return $list[$id];
    } else {
        return $list[$id][$field];
    }
}


/**
 * 获取属性信息并缓存
 * @param  integer $id    属性ID
 * @param  string  $field 要获取的字段名
 * @return string         属性信息
 */
function get_model_attribute($model_id, $group = true){
    static $list;

    /* 非法ID */
    if(empty($model_id) || !is_numeric($model_id)){
        return '';
    }
    /* 获取属性 */
    if(!isset($list[$model_id])){
        $map = array('model_id'=>$model_id);
        $extend = \system\models\LeModel::find()->where(array('id'=>$model_id))->asArray()->one()['extend'];//M('Model')->getFieldById($model_id,'extend');
        if($extend){
            $map = implode(',',array($model_id,$extend));   //array('model_id'=> array("in", array($model_id, $extend)));
        }
        $info = \system\models\LeAttribute::find()->where('model_id in ('.$map.')')->asArray()->all();   //M('Attribute')->where($map)->select();
        $list[$model_id] = $info;
        //S('attribute_list', $list); //更新缓存
    }

    $attr = array();
    foreach ($list[$model_id] as $value) {
        $attr[$value['id']] = $value;
    }

    if($group){
        $sort  =\system\models\LeModel::find()->where(array('id'=>$model_id))->asArray()->one()['field_sort'];      //M('Model')->getFieldById($model_id,'field_sort');

        if(empty($sort)){	//未排序
            $group = array(1=>array_merge($attr));
        }else{
            $group = json_decode($sort, true);

            $keys  = array_keys($group);
            foreach ($group as &$value) {
                foreach ($value as $key => $val) {
                    $value[$key] = $attr[$val];
                    unset($attr[$val]);
                }
            }

            if(!empty($attr)){
                $group[$keys[0]] = array_merge($group[$keys[0]], $attr);
            }
        }
        $attr = $group;
    }
    return $attr;
}

function get_type_bycate($id = null){
    if(empty($id)){
        return false;
    }
    $type_list  =  \common\help\CommonHelper::C('DOCUMENT_MODEL_TYPE');
    $model_type = \menu\models\LeCategory::find()->where(array('id'=>$id))->asArray()->one()['type'];      //M('Category')->getFieldById($id, 'type');
    $model_type =   explode(',', $model_type);
    foreach ($type_list as $key=>$value){
        if(!in_array($key, $model_type)){
            unset($type_list[$key]);
        }
    }
    return $type_list;
}

// 分析枚举类型字段值 格式 a:名称1,b:名称2
// 暂时和 parse_config_attr功能相同
// 但请不要互相使用，后期会调整
function parse_field_attr($string) {
    if(0 === strpos($string,':')){
        // 采用函数定义
        return   eval(substr($string,1).';');
    }
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}

/**
 * 检查$pos(推荐位的值)是否包含指定推荐位$contain
 * @param number $pos 推荐位的值
 * @param number $contain 指定推荐位
 * @return boolean true 包含 ， false 不包含
 * @author huajie <banhuajie@163.com>
 */
function check_document_position($pos = 0, $contain = 0){
    if(empty($pos) || empty($contain)){
        return false;
    }

    //将两个参数进行按位与运算，不为0则表示$contain属于$pos
    $res = $pos & $contain;
    if($res !== 0){
        return true;
    }else{
        return false;
    }
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function yii_encrypt($data, $key = '', $expire = 0) {
    $key  = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char = '';

    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char .= substr($key, $x, 1);
        $x++;
    }

    $str = sprintf('%010d', $expire ? $expire + time():0);

    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1)))%256);
    }
    return str_replace(array('+','/','='),array('-','_',''),base64_encode($str));
}

/**
 * 根据条件字段获取指定表的数据
 * @param mixed $value 条件，可用常量或者数组
 * @param string $condition 条件字段
 * @param string $field 需要返回的字段，不传则返回整个数据
 * @param string $table 需要查询的表
 * @author huajie <banhuajie@163.com>
 */
function get_table_field($value = null, $condition = 'id', $field = null, $table = null){
    if(empty($value) || empty($table)){
        return false;
    }

    //拼接参数
    $map[$condition] = $value;
    $table=C('TABLEPREFIX').ucfirst($table);
    $query=new \yii\db\Query();
    // M(ucfirst($table))->where($map);
    if(empty($field)){
        $info =$query->select('*') ->from($table)->where($map);
    }else{
        $info =$query->select($field) ->from($table)->where($map);
    }
    return $info;
}


/**
 * 获取行为类型
 * @param intger $type 类型
 * @param bool $all 是否返回全部类型
 * @author huajie <banhuajie@163.com>
 */
function get_action_type($type, $all = false){
    $list = array(
        1=>'系统',
        2=>'用户',
    );
    if($all){
        return $list;
    }
    return $list[$type];
}

/**
 * 获取行为数据
 * @param string $id 行为id
 * @param string $field 需要获取的字段
 * @author huajie <banhuajie@163.com>
 */
function get_action($id = null, $field = null){
    if(empty($id) && !is_numeric($id)){
        return false;
    }
    if(empty($list[$id])){
        $map =" status<>-1 AND id=$id ";   //     array('status'=>array('gt', -1), 'id'=>$id);
        $list[$id] =\system\models\LeAction::find()->where($map)->asArray()->one();    // M('Action')->where($map)->field(true)->find();
    }
    return empty($field) ? $list[$id] : $list[$id][$field];
}

/**
 * @param int $uid
 * 根据id获取用户名
 */
function get_nickname($uid=0)
{
    if($uid==0)
    {
        return false;
    }
    $map=array('id'=>$uid);
    $userinfo=\member\models\LeUcenterMember::find()->where($map)->asArray()->one();
    return $userinfo['username'];
}

/**
 * @param  string|array $to 邮件接受者
 * @param string $subject 邮件主题
 * @param html $body 邮件内容
 * @return bool 返回参数
 */
function sendEmail($to,$subject,$body)
{
    $mail=Yii::$app->mailer->compose();
    $mail->setTo($to);
    $mail->setSubject($subject);
    $mail->setHtmlBody($body);
    if($mail->send())
    {
        return true;
    }
    else
    {
        return false;
    }
}

/**
 * @return 获取mysql版本信息
 */
function getMysqlVersion()
{
    $connection=\Yii::$app->db;
    $command=$connection->createCommand("select VERSION() as version");
    $result=$command->queryAll();
    return $result[0]['version'];
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}









