<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 15:54
 */
$this->title = '基本设置';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>网站设置</h2>
    </div>
    <div class="tab-wrap">
        <ul class="tab-nav nav">

            <?php foreach($type as $key=>$val){ ?>
                <li <?php if($key==$id) echo 'class="current"' ?>><a href="<?=Yii::$app->homeUrl.'config/group?id='.$key?>"><?=$val?>配置</a></li>
            <?php } ?>
        </ul>
        <div class="tab-content">
            <form action="<?=Yii::$app->homeUrl.'config/save'?>" method="post" class="form-horizontal">
                <volist name="list" id="config">
                    <?php foreach($list as $config){?>
                        <div class="form-item">
                            <label class="item-label"><?=$config['title']?><span class="check-tips">（<?=$config['remark']?>）</span> </label>
                            <div class="controls">
                                <?php switch($config["type"]){ case "0": ?>
                                    <input type="text" class="text input-small" name="<?=$config["name"]; ?>" value="<?=$config["value"]; ?>">
                                    <?php break;?>
                                <?php case "1": ?>
                                    <input type="text" class="text input-large" name="<?=$config["name"]; ?>" value="<?=$config["value"]; ?>">
                                    <?php break;?>
                                <?php case "2": ?>
                                    <label class="textarea input-large">
                                        <textarea name="<?=$config["name"]; ?>"><?=$config["value"]; ?></textarea>
                                    </label>
                                    <?php break;?>
                                <?php case "3": ?>
                                    <label class="textarea input-large">
                                        <textarea name="<?=$config["name"]; ?>"><?=$config["value"]; ?></textarea>
                                    </label>
                                    <?php break;?>
                                <?php case "4": ?>
                                    <select name="<?=$config["name"]; ?>">
                                        <?php $_result=parse_config_attr($config['extra']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                            <option value="<?=$key; ?>" <?php if(($config["value"]) == $key): ?>selected<?php endif; ?>><?=$vo; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    <?php break; }?>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-item">
                        <label class="item-label"></label>
                        <div class="controls">
                            <?php if(empty($list)){?><button type="submit" disabled class="btn submit-btn disabled" target-form="form-horizontal">确 定</button><?php }else{ ?><button type="submit" class="btn submit-btn ajax-post" target-form="form-horizontal">确 定</button><?php } ?>

                            <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script'); ?>
    <script type="text/javascript">
        highlight_subnav('<?=Yii::$app->homeUrl.'config/group'?>');
    </script>
<?php $this->endBlock();?>