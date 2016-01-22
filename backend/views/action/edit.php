<?php
/**
 * Created by PhpStorm.
 * User: congsheng
 * Date: 2015/12/30
 * Time: 13:13
 */
?>
<?php $this->beginBlock('content'); ?>
    <div class="main-title cf">
        <h2>查看行为日志</h2>
    </div>

    <!-- 标签页导航 -->
    <div class="tab-wrap">
        <div class="tab-content">
            <!-- 表单 -->
            <form id="form" method="post" class="form-horizontal doc-modal-form">
                <!-- 基础 -->
                <div id="tab1" class="tab-pane in tab1">
                    <div class="form-item cf">
                        <label class="item-label">行为名称</label>
                        <div class="controls">
                            <span><?=get_action($info['action_id'],'title')?></span>
                        </div>
                    </div>
                    <div class="form-item cf">
                        <label class="item-label">执行者</label>
                        <div class="controls">
                            <span><?=get_nickname($info['user_id'])?></span>
                        </div>
                    </div>
                    <div class="form-item cf">
                        <label class="item-label">执行IP</label>
                        <div class="controls">
                            <span><?=long2ip($info['action_ip'])?></span>
                        </div>
                    </div>
                    <div class="form-item cf">
                        <label class="item-label">执行时间</label>
                        <div class="controls">
                            <span><?=date('Y-m-d H:i:s',$info['create_time'])?></span>
                        </div>
                    </div>
                    <div class="form-item cf">
                        <label class="item-label">备注</label>
                        <div class="controls">
                            <label class="textarea input-large">
                                <textarea readonly="readonly"><?=$info['remark']?></textarea>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- 按钮 -->
                <div class="form-item cf">
                    <label class="item-label"></label>
                    <div class="controls edit_sort_btn">
                        <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $this->endBlock();?>
<?php $this->beginBlock('script'); ?>

<?php $this->endBlock();?>