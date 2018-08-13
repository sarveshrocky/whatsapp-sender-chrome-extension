<?php
/**
 * @var PhoneNumber[] $items
 */
?>

<?php $this->load->view('header', ['title' => 'Добавление номера WhatsApp']); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Список номеров WhatsApp</h3>

            <div class="row">
                <div class="col-md-6 col-md-offset-6 text-right">
                    <a href="<?= base_url('messages/create') ?>">На главную</a>
                </div>
            </div>


            <div><?php alert() ?></div>

            <table class="table table-striped">
            <thead>
            <tr>
                <th>Номер</th>
                <th>Название</th>
                <th>Последняя активность</th>
                <th>Показывать на главной</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($items as $item): ?>
            <form action="<?= base_url('whatsapp/update') ?>" method="post">
            <input type="hidden" name="id" value="<?= $item->id ?>">
            <tr>
                <td style="vertical-align: middle">
                    <?= formatPhone($item->phone, 'WA', 'fetch') ?>
                </td>
                <td>
                  <input type="text" name="name" value="<?= $item->name ?>" class="form-control input-sm">
                </td>
                <td style="vertical-align: middle">
                    <?= date('d.m.Y H:i:s', $item->last_activity) ?>
                </td>
                <td style="vertical-align: middle">
                  <input type="checkbox" name="is_visible" <?= $item->is_visible ? 'checked' : '' ?> >
                </td>
                <td>
                    <input type="submit" class="btn btn-success btn-sm" name="submit" value="Сохранить">
                </td>
            </tr>
            </form>
            <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>


