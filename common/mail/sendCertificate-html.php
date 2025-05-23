<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var $participant */

?>
<div class="verify-email">
    <p><?= Yii::t('app', 'Саламатсызба, {name}.', ['name' => Html::encode($participant->name)]) ?></p>

    <p><?= Yii::t('app', 'Құттықтаймыз! Сіздің марапатыңыз:') ?></p>
</div>
