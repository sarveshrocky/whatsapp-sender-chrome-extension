<?php
/**
 * @var string $title
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= isset($title) ? $title . ' - ' : '' ?>Система отправки сообщений</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <link href="<?= vendors('bootstrap/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= vendors('bootstrap/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= assets('css/style.css') ?>" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?= vendors('jquery/jquery-2.2.4.min.js') ?>"></script>
    <script type="text/javascript" src="<?= vendors('momentjs/moment.js_2.9.0.js') ?>"></script>
    <script type="text/javascript" src="<?= vendors('bootstrap/bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?= vendors('bootstrap/bootstrap-datetimepicker.min.js') ?>"></script>
    <script type="text/javascript" src="<?= vendors('jquery/jquery.maskedinput.js') ?>"></script>
</head>
<body>
