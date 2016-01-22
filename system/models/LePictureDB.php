<?php
namespace system\models;
use common\help\CommonHelper;
use common\help\DBHelper;
use common\help\Upload;
use upload\Driver\Services_JSON;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/21
 * Time: 9:35
 */
class LePictureDB extends  DBHelper
{

    /**
     * 文件上传
     * @param  array  $files   要上传的文件列表（通常是$_FILES数组）
     * @param  array  $setting 文件上传配置
     * @param  string $driver  上传驱动名称
     * @param  array  $config  上传驱动配置
     * @return array           文件上传成功后的信息
     */
    public function upload($files, $setting, $driver = 'Local', $config = null){
        /* 上传文件 */
        $setting['callback'] = array($this, 'isFile');
        $setting['removeTrash'] = array($this, 'removeTrash');
        $Upload = new Upload($setting, $driver, $config);
        $info   = $Upload->upload($files);
        if($info){ //文件上传成功，记录文件信息
            foreach ($info as $key => &$value) {
                /* 已经存在文件记录 */
                if(isset($value['id']) && is_numeric($value['id'])){
                    continue;
                }
                /* 记录文件信息 */
                $value['path'] = substr($setting['rootPath'], 1).$value['savepath'].$value['savename'];	//在模板里的url路径
                $value['path']=str_replace('./..','',$value['path']);
                $picture=new LePicture();
                if(!isset($value['id']))
                {
                    $picture->path=$value['path'];
                    $picture->md5=$value['md5'];
                    $picture->sha1=$value['sha1'];
                    $picture->status=1;
                    $picture->create_time=CommonHelper::CurrentTime();
                }
                else
                {
                    $picture=LePicture::findOne($value['id']);
                    $picture->path=$value['path'];
                    $picture->md5=$value['md5'];
                    $picture->sha1=$value['sha1'];
                    $picture->status=1;
                    $picture->create_time=CommonHelper::CurrentTime();
                }
                $picture->save();
                $value['id']=\Yii::$app->db->getLastInsertID();
//                if($this->create($value) && ($id = $this->add())){
//                    $value['id'] = $id;
//                } else {
//                    //TODO: 文件上传成功，但是记录文件信息失败，需记录日志
//                    unset($info[$key]);
//                }
            }
            return $info; //文件上传成功
        } else {
            $this->error = $Upload->getError();
            return false;
        }
    }

    //文件批量上传
    function mutilUpload($type)
    {
        $php_path = dirname(__FILE__) . '/';
        $php_url = dirname($_SERVER['PHP_SELF']) . '/';
        //文件保存目录路径
        $save_path =  $_SERVER['DOCUMENT_ROOT'].'/uploads/'; //$php_path . '../attached/';
        //文件保存目录URL
        $save_url =   $_SERVER['DOCUMENT_ROOT'].'/uploads/'; // $php_url . '../attached/';
        //定义允许上传的文件扩展名
        $ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
        );
        //最大文件大小
        $max_size = 1000000;
        $save_path = realpath($save_path) . '/';
        //PHP上传失败
        if (!empty($_FILES['imgFile']['error'])) {
            switch($_FILES['imgFile']['error']){
                case '1':
                    $error = '超过php.ini允许的大小。';
                    break;
                case '2':
                    $error = '超过表单允许的大小。';
                    break;
                case '3':
                    $error = '图片只有部分被上传。';
                    break;
                case '4':
                    $error = '请选择图片。';
                    break;
                case '6':
                    $error = '找不到临时目录。';
                    break;
                case '7':
                    $error = '写文件到硬盘出错。';
                    break;
                case '8':
                    $error = 'File upload stopped by extension。';
                    break;
                case '999':
                default:
                    $error = '未知错误。';
            }
            alert($error);
        }
        //有上传文件时
        if (empty($_FILES) === false) {
            //原文件名
            $file_name = $_FILES['imgFile']['name'];
            //服务器上临时文件名
            $tmp_name = $_FILES['imgFile']['tmp_name'];
            //文件大小
            $file_size = $_FILES['imgFile']['size'];
            //检查文件名
            if (!$file_name) {
                alert("请选择文件。");
            }
            //检查目录
            if (@is_dir($save_path) === false) {
                alert("上传目录不存在。");
            }
            //检查目录写权限
            if (@is_writable($save_path) === false) {
                alert("上传目录没有写权限。");
            }
            //检查是否已上传
            if (@is_uploaded_file($tmp_name) === false) {
                alert("上传失败。");
            }
            //检查文件大小
            if ($file_size > $max_size) {
                alert("上传文件大小超过限制。");
            }
            //检查目录名
            $dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
            if (empty($ext_arr[$dir_name])) {
                alert("目录名不正确。");
            }
            //获得文件扩展名
            $temp_arr = explode(".", $file_name);
            $file_ext = array_pop($temp_arr);
            $file_ext = trim($file_ext);
            $file_ext = strtolower($file_ext);
            //检查扩展名
            if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
                alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
            }
            //创建文件夹
            $typename='';
            if ($dir_name !== '') {
                if($type!=0)
                {
                    $typename=$this->getTypeName($type);
                    $save_path .= $dir_name . "/".$typename."/";
                    $save_url .= $dir_name . "/".$typename."/";
                }
                else
                {
                    $save_path .= $dir_name . "/others/";
                    $save_url .= $dir_name . "/others/";
                }
                if (!file_exists($save_path)) {
                    mkdir($save_path);
                }
            }
            $ymd = date("Y-m-d");
            $save_path .= $ymd . "/";
            $save_url .= $ymd . "/";
            if (!file_exists($save_path)) {
                mkdir($save_path);
            }
            //新文件名
            $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
            //移动文件
            $file_path = $save_path . $new_file_name;
            $save_path= $save_url.$new_file_name;
            if (move_uploaded_file($tmp_name, $file_path) === false) {
                alert("上传文件失败。");
            }
            @chmod($file_path, 0644);
            header('Content-type: text/html; charset=UTF-8');
            $json = new Services_JSON();
            if(!empty($typename))
            {
                $returnUrl='/uploads/image/'.$typename.'/'.$ymd.'/'.$new_file_name;
            }
            else
            {
                $returnUrl='/uploads/image/others/'.$ymd.'/'.$new_file_name;
            }
            $this->insert($returnUrl,md5_file($save_path),sha1_file($save_path),$type);
            echo $json->encode(array('error' => 0, 'url' => $returnUrl));
            exit;
        }
    }

    function alert($msg) {
        header('Content-type: text/html; charset=UTF-8');
        $json = new Services_JSON();
        echo $json->encode(array('error' => 1, 'message' => $msg));
        exit;
    }
    //图片信息茶如数据库
    function insert($path,$md5,$sha1,$type=0)
    {
        $Model=new LePicture();
        $Model->path=$path;
        $Model->md5=$md5;
        $Model->sha1=$sha1;
        $Model->type=$type;
        $Model->status=1;
        $Model->marks=0;
        $Model->create_time=CommonHelper::CurrentTime();
        $Model->update_time=CommonHelper::CurrentTime();
        if(!$Model->validate()||!$Model->save())
        {
            $this->error($Model->errors);
        }
    }

    /**
     * @param int $id
     * @return 根据id获取图片信息
     */
    function PicInfo($id=0)
    {
        if($id==0)
        {
            $this->success('参数错误');
        }
        return LePicture::find()->where(array('id'=>$id))->asArray()->one();
    }

    function Write($param)
    {
        if(empty($param['id']))
        {
            $Model=new LePicture();
            $param['create_time']=CommonHelper::CurrentTime();
            $param['update_time']=CommonHelper::CurrentTime();
            $param['status']=1;
        }
        else
        {
            $Model=LePicture::findOne($param['id']);
            $param['update_time']=CommonHelper::CurrentTime();
            $param['status']=1;
        }
        $Model->attributes=$param;
        if($Model->validate()&&$Model->save())
        {
            $this->success("保存成功！");
        }
        else
        {
            $this->error($Model->errors);
        }
    }
    /**
     * @param $id
     * @return 根据id获取分类名称
     */
    function getTypeName($id)
    {
        $info=LePictureType::find()->where(array('id'=>$id))->asArray()->one();
        return $info['type_name'];
    }

    /**
     * @param int $type
     * @return 获取图片列表
     */
    function getList($type=0)
    {
        $map['marks']=0;
        if(!empty($type))
        {
            $map['type']=$type;
        }
        $model=new LePicture();
        $list=$this->_list($model,$map,'create_time','',14);
        return $list;
    }
    /**
     * 下载指定文件
     * @param  number  $root 文件存储根目录
     * @param  integer $id   文件ID
     * @param  string   $args     回调函数参数
     * @return boolean       false-下载失败，否则输出下载文件
     */
    public function download($root, $id, $callback = null, $args = null){
        /* 获取下载文件信息 */
        $file = $this->find($id);
        if(!$file){
            $this->error = '不存在该文件！';
            return false;
        }

        /* 下载文件 */
        switch ($file['location']) {
            case 0: //下载本地文件
                $file['rootpath'] = $root;
                return $this->downLocalFile($file, $callback, $args);
            case 1: //TODO: 下载远程FTP文件
                break;
            default:
                $this->error = '不支持的文件存储类型！';
                return false;

        }

    }


    /**
     * 检测当前上传的文件是否已经存在
     * @param  array   $file 文件上传数组
     * @return boolean       文件信息， false - 不存在该文件
     */
    public function isFile($file){
        if(empty($file['md5'])){
            throw new \Exception('缺少参数:md5');
        }
        /* 查找文件 */
        $map = array('md5' => $file['md5'],'sha1'=>$file['sha1'],);
        $result=LePicture::find()->where($map)->one();
        return $result;
    }

    /**
     * 下载本地文件
     * @param  array    $file     文件信息数组
     * @param  callable $callback 下载回调函数，一般用于增加下载次数
     * @param  string   $args     回调函数参数
     * @return boolean            下载失败返回false
     */
    private function downLocalFile($file, $callback = null, $args = null){
        if(is_file($file['rootpath'].$file['savepath'].$file['savename'])){
            /* 调用回调函数新增下载数 */
            is_callable($callback) && call_user_func($callback, $args);

            /* 执行下载 */ //TODO: 大文件断点续传
            header("Content-Description: File Transfer");
            header('Content-type: ' . $file['type']);
            header('Content-Length:' . $file['size']);
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($file['name']) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $file['name'] . '"');
            }
            readfile($file['rootpath'].$file['savepath'].$file['savename']);
            exit;
        } else {
            $this->error = '文件已被删除！';
            return false;
        }
    }

    /**
     * 清除数据库存在但本地不存在的数据
     * @param $data
     */
     function removeTrash($data){
        $Picture=LePicture::findOne($data['id']);
        $Picture->delete();
    }


}