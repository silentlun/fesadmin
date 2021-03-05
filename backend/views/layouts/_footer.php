<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<!--ajax模拟框加载-->
<div class="modal fade" id="ajaxModal" aria-hidden="true" role="dialog" aria-labelledby="ajaxModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <?= Html::img('@web/statics/images/loading.gif', ['class' => 'loading']) ?>
                <span>加载中... </span>
            </div>
        </div>
    </div>
</div>
<!--ajax大模拟框加载-->
<div class="modal fade" id="ajaxModalLg" aria-hidden="true" role="dialog" aria-labelledby="ajaxModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <?= Html::img('@web/statics/images/loading.gif', ['class' => 'loading']) ?>
                <span>加载中... </span>
            </div>
        </div>
    </div>
</div>
<!--ajax小模拟框加载-->
<div class="modal fade" id="ajaxModalMin" aria-hidden="true" role="dialog" aria-labelledby="ajaxModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <?= Html::img('@web/statics/images/loading.gif', ['class' => 'loading']) ?>
                <span>加载中... </span>
            </div>
        </div>
    </div>
</div>
<!--初始化模拟框-->
<div id="rfModalBody" class="hide">
    <div class="modal-body">
        <?= Html::img('@web/statics/images/loading.gif', ['class' => 'loading']) ?>
        <span>加载中... </span>
    </div>
</div>
<script>
    // 小模拟框清除
    $('#ajaxModal').on('hide.bs.modal', function (e) {
        if (e.target == this) {
            $(this).removeData("bs.modal");
            $('#ajaxModal').find('.modal-content').html($('#rfModalBody').html());
        }
    });
    // 大模拟框清除
    $('#ajaxModalLg').on('hide.bs.modal', function (e) {
        if (e.target == this) {
            $(this).removeData("bs.modal");
            $('#ajaxModalLg').find('.modal-content').html($('#rfModalBody').html());
        }
    });
    // 小模拟框清除
    $('#ajaxModalMin').on('hide.bs.modal', function (e) {
        if (e.target == this) {
            $(this).removeData("bs.modal");
            $('#ajaxModalMax').find('.modal-content').html($('#rfModalBody').html());
        }
    });

</script>