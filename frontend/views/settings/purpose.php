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

    <?= $form->field($model, 'purpose')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақтау'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
