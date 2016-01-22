<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/28
 * Time: 15:49
 */
?>

<?php $this->beginBlock('leftNav');?>
    <h3>
        <i class="icon icon-unfold" ></i>
        个人中心
    </h3>
    <ul class="side-sub-menu" >
        <li><a href="<?=U('article/mydocument')?>" class="item">我的文档</a></li>
        <li><a href="<?=U('article/draftbox')?>" class="item">草稿箱</a></li>
        <li><a href="<?=U('article/examine')?>" class="item">待审核</a></li>
    </ul>
    <!-- 子导航 -->
<?php foreach($MENU['nodes'] as $Akeys=>$Aval){ ?>
    <h3>
        <i class="icon icon icon-unfold"></i>
        <?= $Aval['title'] ?>
    </h3>
    <ul class="side-sub-menu" >
        <?php foreach($Aval['_child'] as $val){ ?>
            <li><a href="<?=U($val['url'])?>" class="item"><?=$val['title']?></a></li>
        <?php } ?>
    </ul>
<?php } ?>
    <!-- /子导航 -->
    <!-- 回收站 -->
    <h3>
        <em class="recycle"></em>
        <a href="<?=U('article/recycle')?>">回收站</a>
    </h3>
<?php $this->endBlock();?>

<?php $this->beginBlock('content'); ?>
    <div class="main-title cf">
        <h2>
            文档排序 [ <a href="#" onclick="javascript:history.back(-1);return false;">返回列表</a> ]
        </h2>
    </div>
    <div class="sort">
        <form action="<?=U()?>" method="post">
            <div class="sort_center">
                <div class="sort_option">
                    <select value="" size="8">
                        <?php foreach($list as $vo){?>
                            <option class="ids" title="<?=$vo['title']?>" value="<?=$vo['id']?>"><?=$vo['title']?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="sort_btn">
                    <button class="top btn" type="button">第 一</button>
                    <button class="up btn" type="button">上 移</button>
                    <button class="down btn" type="button">下 移</button>
                    <button class="bottom btn" type="button">最 后</button>
                </div>
            </div>
            <div class="sort_bottom">
                <input type="hidden" name="ids">
                <button class="sort_confirm btn submit-btn" type="button">确 定</button>
                <button class="sort_cancel btn btn-return" type="button" onclick="javascript:history.back(-1);return false;" >返 回</button>
            </div>
        </form>
    </div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script'); ?>
    <script type="text/javascript">
        $(function(){
            sort();
            $(".top").click(function(){
                rest();
                $("option:selected").prependTo("select");
                sort();
            })
            $(".bottom").click(function(){
                rest();
                $("option:selected").appendTo("select");
                sort();
            })
            $(".up").click(function(){
                rest();
                $("option:selected").after($("option:selected").prev());
                sort();
            })
            $(".down").click(function(){
                rest();
                $("option:selected").before($("option:selected").next());
                sort();
            })
            $(".search").click(function(){
                var v = $("input").val();
                $("option:contains("+v+")").attr('selected','selected');
            })
            function sort(){
                $('option').text(function(){return ($(this).index()+1)+'.'+$(this).text()});
            }

            //重置所有option文字。
            function rest(){
                $('option').text(function(){
                    return $(this).text().split('.')[1]
                });
            }
            $('.sort_confirm').click(function(){
                var arr = new Array();
                $('.ids').each(function(){
                    arr.push($(this).val());
                });
                $.ajax({
                    url:'<?=U()?>',
                    data:{ids:arr.join(',')},
                    type:'Post',
                    async:false,
                    dataType:'json',
                    success:function(data)
                    {
                        console.log(data);
                        if (data.status) {
                            updateAlert(data.info + ' 页面即将自动跳转~','alert-success');
                        }else{
                            updateAlert(data.info,'alert-success');
                        }
                        setTimeout(function(){
                            location.href= history.back(-1);  //data.url;
                        },1500);
                    },
                    error:function(XMLHttpRequest,erros)
                    {
                        alert(erros);
                    }
                })
            });
            //点击取消按钮
            $('.sort_cancel').click(function(){
                window.location.href = $(this).attr('url');
            });
        })
    </script>
<?php $this->endBlock(); ?>