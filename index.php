<?php

//use backend\models\StaticTextItem;
//use yii\helpers\Url;
//use backend\models\Page;

/* @var $this yii\web\View */

$this->title = Yii::$app->name;

?>
<div class="top">
    <div class="left">
        <h1>LOREM IPSUM</h1>
        <p> <?= $staticText[1]['text'] ?> </p>

    </div>
    <div class="right">
        <div class="rectangle">
            <img src="rectangle-4-copy.png" alt="">

        </div>
    </div>
</div>

<div class="news" style="justify-items: center;">
    <? foreach ($news as $new):?>
    <? /* @var $new \backend\models\News*/ ?>
    <div style="display: grid; grid-row-gap: 15px; justify-items: center; width: 310px; height: 270px">
        <img src="<?= $new->getSRCPhoto(['suffix'=>'_sm']) ?> " style="margin: 5px">
        <h3><?= $new->name ?></h3>
    </div>
    <? endforeach;?>
</div>

<div class="feedback">


    <div class="border"></div>
    <div class="user-form"></div>

</div>