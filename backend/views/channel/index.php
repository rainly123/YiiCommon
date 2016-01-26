<?php
use common\help\HTMLHelper;
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/15
 * Time: 9:19
 */
$this->title='导航管理';
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title">
        <h2>导航管理</h2>
    </div>

    <div class="cf">
        <a class="btn" href="<?=U('channel/add','pid='.$pid)?>">新 增</a>
        <a  class="btn ajax-post confirm" url="<?=U('channel/del')?>" target-form="ids">删 除</a>
        <button class="btn list_sort" url="{:U('sort',array('pid'=>I('get.pid',0)),'')}">排序</button>
    </div>

    <div class="data-table table-striped">
        <table>
            <thead>
            <tr>
                <th class="row-selected">
                    <input class="checkbox check-all" type="checkbox">
                </th>
                <th>ID</th>
                <th>导航名称</th>
                <th>导航地址</th>
                <th>排序</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($list)){ ?>
                <?php foreach($list as $channel){ ?>
                    <tr>
                        <td><input class="ids row-selected" type="checkbox" name="id[]" value="<?=$channel['id']?>"></td>
                        <td><?=$channel['id']?></td>
                        <td><a href="<?=U('channel/index?pid='.$channel['id'])?>"><?=$channel['title']?></a></td>
                        <td><?=$channel['url']?></td>
                        <td><?=$channel['sort']?></td>
                        <td>
                            <a title="编辑" href="<?=U('channel/edit?id='.$channel['id'].'&pid='.$pid)?>">编辑</a>
                            <a href="<?=U('channel/setstatus?id='.$channel['id'].'&status='.abs(1-$channel['status']))?>" class="ajax-get"><?=show_status_op($channel['status'])?></a>
                            <a class="confirm ajax-get" title="删除" href="<?=U('channel/del?id='.$channel['id'])?>">删除</a>
                        </td>
                    </tr>
                <?php }?>
                <?php }else {?>
                <td colspan="6" class="text-center"> aOh! 暂时还没有内容! </td>
            <?php }?>
            </tbody>
        </table>
    </div>
<?php $this->endBlock(); ?>
<?php $this->beginBlock('script'); ?>
    <script type="text/javascript">
        $(function() {
            //点击排序
            $('.list_sort').click(function(){
                var url = $(this).attr('url');
                var ids = $('.ids:checked');
                var param = '';
                if(ids.length > 0){
                    var str = new Array();
                    ids.each(function(){
                        str.push($(this).val());
                    });
                    param = str.join(',');
                }

                if(url != undefined && url != ''){
                    window.location.href = url + '/ids/' + param;
                }
            });
        });
    </script>
<?php $this->endBlock();?>