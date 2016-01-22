<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/11/18
 * Time: 15:54
 */
$this->title = '用户信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content'); ?>
    <!-- 标题栏 -->
    <div class="main-title">
        <h2>用户列表</h2>
    </div>
    <div class="cf">
        <div class="fl">
            <a class="btn" href="<?=Yii::$app->homeUrl.'users/add'?>">新 增</a>
            <button class="btn" id="sendEmail" href="">发送邮件</button>
            <button class="btn ajax-post" url="<?=Yii::$app->homeUrl.'users/changestatu?method=resumeUser'?>" target-form="ids">启 用</button>
            <button class="btn ajax-post" url="<?=Yii::$app->homeUrl.'users/changestatu?method=forbidUser'?>" target-form="ids">禁 用</button>
            <button class="btn ajax-post confirm" url="<?=Yii::$app->homeUrl.'users/changestatu?method=deleteUser'?>" target-form="ids">删 除</button>
        </div>

        <!-- 高级搜索 -->
        <div class="search-form fr cf">
            <div class="sleft">
                <input type="text" name="nickname" class="search-input" value="<?=Yii::$app->request->get('nickname')?>" placeholder="请输入用户昵称">
                <a class="sch-btn" href="javascript:;" id="search" url="<?=Yii::$app->homeUrl.'users/index'?>"><i class="btn-search"></i></a>
            </div>
        </div>
    </div>
    <!-- 数据列表 -->
    <div class="data-table table-striped">
        <table class="">
            <thead>
            <tr>
                <th class="row-selected row-selected"><input class="check-all" type="checkbox"/></th>
                <th class="">UID</th>
                <th class="">昵称</th>
                <th class="">邮箱</th>
                <th class="">积分</th>
                <th class="">登录次数</th>
                <th class="">最后登录时间</th>
                <th class="">最后登录IP</th>
                <th class="">状态</th>
                <th class="">操作</th>
            </tr>
            </thead>
            <tbody>

            <?php if(!empty($_Member['list'])){ ?>
                <?php foreach($_Member['list'] as $val){ ?>
                    <tr>
                        <td><input class="ids" type="checkbox" name="id[]" value="<?=$val['uid']?>" email="<?=$val['email']?>"/></td>
                        <td><?=$val['uid']?></td>
                        <td><?=$val['nickname']?></td>
                        <td><?=$val['email']?></td>
                        <td><?=$val['score']?></td>
                        <td><?=$val['login']?></td>
                        <td><span><?=date('Y-m-d H:i:s',$val['last_login_time'])?></span></td>
                        <td><span><?=long2ip($val['last_login_ip'])?></span></td>
                        <td><?=$val['status_text']?></td>
                        <td><?php if($val['status']==1){ ?>
                                <a href="<?=Yii::$app->homeUrl.'users/changestatu?method=forbidUser&id='.$val['uid'].''?>" class="ajax-get">禁用</a>
                            <?php }else{ ?>
                                <a href="<?=Yii::$app->homeUrl.'users/changestatu?method=resumeUser&id='.$val['uid'].''?>" class="ajax-get">启用</a>
                            <?php } ?>
                            <a href="<?=Yii::$app->homeUrl.'users/changestatu?method=deleteUser&id='.$val['uid'].''?>" class="confirm ajax-get">删除</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php }else{ ?>
                <td colspan="9" class="text-center"> aOh! 暂时还没有内容! </td>
            <?php } ?>
        </table>
    </div>
    <div class="page">
        <!--分页-->
        <?= \yii\widgets\LinkPager::widget(['pagination' =>$_Member['pagination']]); ?>
        <!--/分页-->
    </div>
    <div id="dialog" style="width: 300px;padding:10px;display: none">
        <input type="text" id="title_subject" placeholder="请输入邮件主题" value="" class="form-control">
        <select class="selectCompose span2" id="emailcontent" name="subject">
            <?php foreach($email as $val){?>
                <option value="<?=$val['id']?>"><?=$val['subject']?></option>
            <?php }?>
            <input class="btn" id="btn_send" type="button" value="发送">
        </select>
    </div>
<?php $this->endBlock();?>
<?php $this->beginBlock('script');?>
    <script src="<?=Yii::$app->homeUrl?>js/thinkbox/jquery.thinkbox.js"></script>
    <script type="text/javascript">
        $("#emailcontent").change(function(){
            var title=$(this).find("option:selected").text();
            $("#title_subject").val(title);
        });
        setValue('#title_subject',$("#emailcontent").find("option:selected").text());
        /*弹出窗口*/
        $("#sendEmail").click(function(){
            var emailCount=<?=count($email);?>;
            if(emailCount==0)
            {
                var result= confirm('邮件模板为空，是否添加邮件？');
            }
            $.thinkbox(
                "#dialog",
                {'title':'选择邮件类容'}
            );
        });
        $("#btn_send").click(function(){
            $(this).attr('disabled',true);
            var str_email="";
            $(".ids").each(function(index,element){
                if($(this).is(':checked'))
                {
                    str_email+=$(this).attr('email')+",";
                }
            })
            if(str_email!="")
            {
                var email_id=$("#emailcontent").val();//获取邮件id
                var email_subject=$("#title_subject").val();//获取邮件主题
                str_email=str_email.substring(0,str_email.length-1);
                ajaxSend("<?=U('users/dosend')?>",str_email,email_id,email_subject);
            }
            else
            {
                alert("请选择要发送的人！")
            }

        })
        //搜索功能
        $("#search").click(function(){
            var url = $(this).attr('url');
            var query  = $('.search-form').find('input').serialize();
            query = query.replace(/(&|^)(\w*?\d*?\-*?_*?)*?=?((?=&)|(?=$))/g,'');
            query = query.replace(/^&/g,'');
            if( url.indexOf('?')>0 ){
                url += '&' + query;
            }else{
                url += '?' + query;
            }
            window.location.href = url;
        });
        //回车搜索
        $(".search-input").keyup(function(e){
            if(e.keyCode === 13){
                $("#search").click();
                return false;
            }
        });

        var ajaxSend=function(url,data,email_id,subject)
        {
            $.ajax({
                Type:'Post',
                url:url,
                data:{str_email:data,email_id:email_id,subject:subject},
                success:function(data){
                    console.log(data);
//                    alert(data.info);
                }
            })
        }
        //导航高亮
        highlight_subnav('<?=U('users/index')?>');
    </script>


<?php $this->endBlock(); ?>