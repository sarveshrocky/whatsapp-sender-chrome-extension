<?php
/**
 * @var Message $model
 * @var array $phones
 */
?>

<?php $this->load->view('header', ['title' => 'Создание сообщения']); ?>

<div class="container-fluid">
    <h3>Написать сообщение</h3>
    <a class="pull-left" href="<?= base_url('whatsapp') ?>">Список номеров WhatsApp</a>
    <a class="pull-right " href="<?= base_url('messages/queue') ?>">Очередь сообщений</a>
    <div class="clear"></div>
    <?= form_open($model->isNew() ? base_url('messages/create') : base_url("messages/update/{$model->id}"), [
        'method' => 'post'])
    ?>
        <div class="row">
            <div class="col-sm-5">

                <div class="form-group <?= form_error('phone') ? 'has-error' : '' ?>">
                    <label for="phone">Телефон:</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                           placeholder="+00000000000"
                           value="<?= set_value('phone', $model->phone) ?>"/>
                    <?= form_error('phone') ?>
                </div>

                <div class="form-group <?= form_error('messenger') ? 'has-error' : '' ?>">
                    <label class="radio-inline">
                        <input type="radio" name="messenger" value="WhatsApp" checked/>WhatsApp
                    </label>
                    <?php /* <label class="radio-inline">
                        <input type="radio" name="optradio"
                               value="Telegram" <?php if ($message['method'] == 'Telegram'): ?> checked <?php endif; ?>/>Telegram</label>
                    */ ?>
                    <?= form_error('messenger', $model->messenger) ?>
                    <hr style="margin-top: 5px; margin-bottom: 5px; border-top-style: dashed">

                    <div>
<!--                        <div class="checkbox">-->
<!--                            <label for="usePhoneBind">-->
<!--                                <input type="checkbox" id="usePhoneBind" name="use_phone_bind"-->
<!--                                       value="--><?//= set_value('use_phone_bind') ?><!--"> Привязать к номеру-->
<!--                            </label>-->
<!--                        </div>-->
                        <?php foreach ($phones as $idx_ => $pd_): ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="phone_sender"
                                        <?php
                                        $_ps = set_value('phone_sender');
                                        if (!empty($_ps)) {
                                            echo $_ps === $pd_['value'] ? 'checked' : '';
                                        } else {
                                            echo $model->isNew()
                                                ? $idx_ === 0 ? 'checked' : ''
                                                : $pd_['value'] === $model->phone_sender ? 'checked' : '';
                                        } ?>
                                        value="<?= $pd_['value'] ?>">
                                    <?= $pd_['text'] ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="form-group <?= form_error('time_formatted') ? 'has-error' : '' ?>">
                    <label for="video">Дата и время отправки</label>
                    <div class="clear"></div>
                    <?php if ($model->isNew()): ?>
                        <label class="radio-inline">
                            <input type="radio" name="time_radio" value="today"
                                <?php $tr__ = set_value('time_radio') ?>
                                <?= ($tr__ === 'today' || empty($tr__)) ? 'checked' : '' ?> />Сейчас
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="watch-me" name="time_radio" value="other_date"
                                <?= set_value('time_radio') === 'other_date' ? 'checked' : '' ?> />Задать дату
                        </label>
                    <?php else: ?>
                        <label class="radio-inline">
                            <input type="radio" name="time_radio" value="today" />Сейчас
                        </label>
                        <label class="radio-inline">
                            <input type="radio" id="watch-me" name="time_radio" value="other_date" checked />Задать дату
                        </label>
                    <?php endif ?>
                    <div class="date-box" id="show-me"
                        <?php if ($model->isNew() && set_value('time_radio') !== 'other_date'): ?> style="display: none" <?php endif; ?>>
                        <div class='input-group date' id='datetimepicker2'>
                            <input type='text' class="form-control" name="time_formatted"
                                   value="<?= set_value('time_formatted', date('d.m.Y H:i', $model->isNew() ? time() : $model->time)) ?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <?= form_error('time_formatted') ?>
                </div>
            </div>
            <div class="col-sm-7">
                <div
                    class="form-group comment <?= form_error('text') ? 'has-error' : '' ?>">
                    <label for="text">Текст сообщения:</label>
                    <textarea class="form-control" rows="5" id="text"
                              name="text"><?= set_value('text', $model->text) ?></textarea>
                    <?= form_error('text') ?>
                </div>
                <div class="col-sm-12 but-mar text-right">
                    <input type="reset" class="btn btn-md btn-danger"
                           value="Сбросить">
                    <input type="submit" name="submit"
                           class="btn btn-md btn-success"
                           value="Отправить">
                </div>
            </div>
        </div>
    <?= form_close() ?>
</div>

<script>
  jQuery(function ($) {
    <?php /*
    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function () {
      var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready(function () {
      $(':file').on('fileselect', function (event, numFiles, label) {

        var input = $(this).parents('.input-group').find(':text'),
          log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
          input.val(log);
        } else {
          if (log) alert(log);
        }

      });
    });

    */ ?>

    $(function () {
      $('#datetimepicker2').datetimepicker({
        locale: 'ru'
      });
    })

    $('input[name="time_radio"]').click(function () {
      if (this.id === "watch-me") {
        $("#show-me").show('fast');
      } else {
        $("#show-me").hide('fast');
      }
    })

    $("#phone").mask("+999999999?999");
    $("#phone").on("blur", function () {
      var last = $(this).val().substr($(this).val().indexOf("-") + 1);

      if (last.length == 3) {
        var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
        var lastfour = move + last;

        var first = $(this).val().substr(0, 9);

        $(this).val(first + '-' + lastfour);
      }
    })

  });
</script>

<?php $this->load->view('footer'); ?>
