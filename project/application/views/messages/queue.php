<?php
/**
 * @var Message[] $queue
 */
?>
<div class="container-fluid">
    <h3>Очередь сообщений</h3>
    <a class="pull-right" href="<?= base_url('messages/create') ?>">На главную</a>
    <div class="clear"></div>
    <div class="row box-com">
        <?php foreach ($queue as $one): ?>
            <div class="panel panel-default
            <?= $one->status === Message::STATUS_REJECTED ? 'panel-danger' : '' ?>
            <?= $one->status === Message::STATUS_SENT ? 'panel-success' : '' ?>
            <?= $one->status === Message::STATUS_CANCELED ? 'panel-danger' : '' ?>
            ">
                <div class="panel-heading"><?= $one->phone_sender ?> <i class="glyphicon glyphicon-arrow-right"></i>
                    <?= $one->phone?> (<?= $one->messenger ?>)
                    <span style="float: right;">
                        <?php if ($one->status === 'new'): ?>
                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <?php elseif ($one->status === Message::STATUS_CANCELED): ?>
                            <span aria-hidden="true" class="text-danger glyphicon glyphicon-remove"></span>
                        <?php elseif ($one->status === Message::STATUS_SENT): ?>
                            <span aria-hidden="true" class="green glyphicon glyphicon-ok"></span>
                        <?php elseif ($one->status === Message::STATUS_REJECTED): ?>
                            <span aria-hidden="true" class="text-danger glyphicon glyphicon glyphicon-exclamation-sign"></span>
                        <?php endif ?>
                        <?= date('d.m.Y H:i', $one->time) ?>
                    </span>
                </div>
                <div class="panel-body">
                    <p align="justify"><?= nl2br($one->text) ?></p>
                </div>
                <div class="panel-footer text-right" style="background-color: white">
                    <?php if($one->media) echo  '<a href="#">Медиа</a>' ?>
                    <?php if ($one->status == 'new'): ?>
                        <span>
                                <a class="alert-dangers" href="<?= base_url("messages/cancel/{$one->id}") ?>">Отменить</a>
                                / <a class="alert-yellos" href="<?= base_url("messages/update/{$one->id}") ?>">Изменить</a></span>
                    <?php elseif ($one->status === Message::STATUS_CANCELED): ?>
                        <span class="text-danger">Отменено</span>
                    <?php elseif ($one->status === Message::STATUS_SENT): ?>
                        <span class="green"> Отправлено <?= date('d.m.Y в H:i', $one->time_sent) ?></span>
                    <?php elseif ($one->status === Message::STATUS_PENDING): ?>
                        <span class="text-info"><i>Отправлено на обработку</i></span>
                    <?php elseif ($one->status === Message::STATUS_REJECTED): ?>
                        <span class="text-danger"><i><?= $one->reason ?></i></span>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (count($queue) === 0): ?>
        <div class="alert alert-info">Очередь пуста</div>
        <?php endif ?>
    </div>
</div>
