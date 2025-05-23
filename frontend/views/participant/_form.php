<?php

use common\models\Subject;
use common\models\Test;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Participant $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="participant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'subject_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Subject::find()->all(), 'id', 'title_kz'),
        'options' => ['placeholder' => ''],
        'pluginOptions' => ['allowClear' => true],
    ]) ?>

    <?= $form->field($model, 'test_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Test::find()->all(), 'id', 'id'),
        'options' => ['placeholder' => ''],
        'pluginOptions' => ['allowClear' => true],
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'school')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'result')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақтау'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
