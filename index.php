<?php

$pdo = new PDO('sqlite:'.dirname(__FILE__).'/cp1.db');
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$chumash = $pdo->query('SELECT * FROM torah WHERE chumash = 1 AND perek IN( 1,2)') ;
$rashi = $pdo->query('SELECT * FROM rashi WHERE chumash = 1 AND perek = 1') ;

?><!doctype html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>


    <style>
        @font-face {
            font-family: 'rashi';
            src: url(Noto_Rashi_Hebrew/static/NotoRashiHebrew-Regular.ttf) ;
        }
        @font-face {
            font-family: 'TaameyFrankCLM';
            src: url(TaameyFrankCLM-Medium.ttf) ;
        }
        #main{ width: 1200px; margin: 0 auto;}
        span{ font-family: TaameyFrankCLM ; font-size: 35px}

    </style>


</head>
<body dir="rtl">

<div id="main">
    <?php foreach ($chumash as $p){ ?>

        <span><?= $p['text'] ; ?></span>

    <?php } ?>
</div>
</body>
</html>
