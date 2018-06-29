<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use backend\widgets\AndNav;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use backend\models\Page;
use backend\models\StaticTextItem;
use backend\models\UserRole;
use backend\models\Base;
use backend\models\PageItem;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <?= Html::csrfMetaTags() ?>


        <link href="https://fonts.googleapis.com/css?family=Shrikhand" rel="stylesheet">
    </head>

    <?

    $isAbout = \Yii::$app->request->url == $this->params[Page::PAGE_PREFIX . Page::ABOUT_COMPANY]['linkOut'];
    $isContacts = \Yii::$app->request->url == $this->params[Page::PAGE_PREFIX . Page::CONTACTS_PAGE]['linkOut'];
    $isDelivery = \Yii::$app->request->url == $this->params[Page::PAGE_PREFIX . Page::DELIVERY]['linkOut'];
    $isMain = \Yii::$app->controller->id == 'site';
    $isCategory = \Yii::$app->controller->id == 'category';
    $isDesign = \Yii::$app->controller->id == 'design-collection';
    $isReview = \Yii::$app->controller->id == 'review';
    $isError = \Yii::$app->controller->action->id  == 'error';
    //$isProduct = \Yii::$app->controller->id == 'product';
    //$isView = \Yii::$app->controller->action->id == 'view';
    ?>

    <body>

    <?php $this->beginBody() ?>


    <!-- HEADER -->

    <div class="header">
        <ul class="nav">
            <li>
                <a href="#">НОВОСТИ</a>
            </li>
            <li>
                <a href="#">СТАТЬИ</a>
            </li>
            <li>
                <a href="#">ВИДЕО</a>
            </li>
            <li>
                <a href="#">ОБЗОРЫ</a>
            </li>
            <li>
                <a href="#">ПРЕВЬЮ</a>
            </li>
        </ul>
    </div>

    <!-- BODY -->

    <div class="wrapper">

        <?= $content ?>

    </div>

    <!-- FOOTER -->

    <div class="footer_wrapper" style="width: 1248px; margin: 0 auto">
        <div class="left">
            <p>© Copyright @Junaed 2016, All rights reserved.</p>
        </div>
        <div class="right">
            <span class="icon">
                <img src="https://png.icons8.com/metro/50/000000/facebook.png"  style="width: 25px ; height: 25px" alt="">
            </span>
            <span class="icon">
                <img src="https://png.icons8.com/metro/50/000000/linkedin.png" style="width: 25px ; height: 25px" alt="">
            </span>
            <span class="icon">
                <img src="https://png.icons8.com/metro/50/000000/gmail-login.png" style="height: 25px ; width: 25px" alt="">
            </span>
            <span class="icon">
                <img src="https://png.icons8.com/metro/50/000000/twitter.png" style="height: 25px ; width: 25px" alt="">
            </span>
        </div>
    </div>
    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>