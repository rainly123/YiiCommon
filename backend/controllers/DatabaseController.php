<?php
namespace backend\controllers;
use common\help\CommonHelper;
use system\models\Database;
use system\models\DatabaseDB;

/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/16
 * Time: 11:14
 * @author xiaocongsheng <[email address]>
 */
class DatabaseController extends AdminController
{
    function actionIndex()
    {
    	$type=$this->getValue('type');
    	switch ($type) {
    		case 'import':
    			break;
            case 'export':
                $sql="SHOW TABLE STATUS";
                $connection=\Yii::$app->db;
                $command=$connection->createCommand($sql);
                $result=$command->queryAll();
                return $this->render('export',['list'=>$result]);
                break;
    	}

    }

    /**
     * 备份数据库
     * @param  String  $tables 表名
     * @param  Integer $id     表ID
     * @param  Integer $start  起始行数
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
     function actionExport(){
         $tables=$this->getValue('tables');
         $id=$this->getValue('id');
         $start=$this->getValue('start');
        if(IS_POST&&!empty($tables) && is_array($tables)){ //初始化
            //读取备份配置
            $config = array(
                'path'     => realpath(CommonHelper::C('DATA_BACKUP_PATH')) . DIRECTORY_SEPARATOR,
                'part'     =>CommonHelper::C('DATA_BACKUP_PART_SIZE'),
                'compress' => CommonHelper::C('DATA_BACKUP_COMPRESS'),
                'level'    =>CommonHelper::C('DATA_BACKUP_COMPRESS_LEVEL'),
            );
            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if(is_file($lock)){
                $this->error('检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                //创建锁文件
                file_put_contents($lock, CommonHelper::CurrentTime());
            }
            //检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录不存在或不可写，请检查后重试！');
            CommonHelper::setSession('backup_config', $config);
            //生成备份文件信息
            $file = array(
                'name' => date('Ymd-His', CommonHelper::CurrentTime()),
                'part' => 1,
            );
            CommonHelper::setSession('backup_file', $file);
            //缓存要备份的表
            CommonHelper::setSession('backup_tables', $tables);
            //创建备份文件
            $Database = new Database($file, $config);
            if(false !== $Database->create()){
                $tab = array('id' => 0, 'start' => 0);
                $this->success('初始化成功！', '', array('tables' => $tables, 'tab' => $tab));
            } else {
                $this->error('初始化失败，备份文件创建失败！');
            }
        } elseif (IS_GET&&is_numeric($id) && is_numeric($start)) { //备份数据
            $tables = CommonHelper::getSession('backup_tables');
            //备份指定表
            $Database = new Database(CommonHelper::getSession('backup_file'), CommonHelper::getSession('backup_config'));
            $start  = $Database->backup($tables[$id], $start);
            if(false === $start){ //出错
                $this->error('备份出错！');
            } elseif (0 === $start) { //下一表
                if(isset($tables[++$id])){
                    $tab = array('id' => $id, 'start' => 0);
                    $this->success('备份完成！', '', array('tab' => $tab));
                } else { //备份完成，清空缓存
                    unlink(CommonHelper::getSession('backup_config')['path'] . 'backup.lock');
                    CommonHelper::setSession('backup_tables', null);
                    CommonHelper::setSession('backup_file', null);
                    CommonHelper::setSession('backup_config', null);
                    $this->success('备份完成！');
                }
            } else {
                $tab  = array('id' => $id, 'start' => $start[0]);
                $rate = floor(100 * ($start[0] / $start[1]));
                $this->success("正在备份...({$rate}%)", '', array('tab' => $tab));
            }

        } else { //出错
            $this->error('参数错误！');
        }
    }
    //优化表
    function actionOptimize()
    {
        $database=new DatabaseDB();
        $tables=$this->getValue('tables');
        $database->optimize($tables);
    }
    //修复表
    function actionRepair()
    {
        $database=new DatabaseDB();
        $tables=$this->getValue('tables');
        $database->repair($tables);
    }
}