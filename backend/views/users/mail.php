<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2016/1/4
 * Time: 16:46
 */
$this->title='邮件类容';
?>
<?php $this->beginBlock('content'); ?>
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>已发送列表</h2>
    </div>
    <div class="cf">
        <div class="fl">
            <a class="btn" href="<?=U('users/sendemail')?>">发送邮件</a>
            <button class="btn ajax-post confirm" url="<?=U('users/delemail')?>" target-form="ids">删 除</button>
        </div>

    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
        <table class="">
            <thead>
            <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="">ID</th>
                <th class="">主题</th>
                <th class="">最后更新时间</th>
                <th class="">操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list)){?>
               <?php foreach($list as $vo){?>
                    <tr>
                        <td><input class="ids" type="checkbox" name="ids[]" value="<?=$vo['id']?>"/></td>
                        <td><?=$vo['id']?></td>
                        <td><?=$vo['subject']?></td>
                        <td><?=$vo['update_time']?></td>
                        <td>
                            <a title="编辑" href="<?=U('users/emailedit?id='.$vo['id'].'')?>">编辑</a>
                            <a class="confirm ajax-get" title="删除" href="<?=U('users/emaildel?='.$vo['id'].'')?>">删除</a>
                        </td>
                    </tr>
                <?php }?>
                <?php }else{?>
                <td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td>
            <?php }?>
            </tbody>
        </table>
    </div>
    <div class="page">
<!--        {$_page}-->
    </div>
    <div id="dialog" style="width: 300px;padding:10px;display: none">
        <input type="text" id="subject" placeholder="请输入邮件主题" class="form-control">
        <select class="selectCompose span2" id="emailcontent">

            <volist name="emailTitile" id="title"><option value="{$title.id}">{$title.title}</option></volist>
            <input class="btn" id="btn_send" type="button" value="发送">
        </select>
    </div>
<?php $this->endBlock();?>
<?php $this->beginBlock('script');?>

<?php $this->endBlock();?>