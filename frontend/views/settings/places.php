<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Settings $model */

$this->title = Yii::t('app', 'Өзгерту: Баптаулар');
?>
<div class="settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first')->textInput() ?>

    <?= $form->field($model, 'second')->textInput() ?>

    <?= $form->field($model, 'third')->textInput() ?>

    <?= $form->field($model, 'fourth')->textInput() ?>

    <?= $form->field($model, 'fifth')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақтау'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
