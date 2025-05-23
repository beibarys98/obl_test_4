<?php

use common\models\Answer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Question $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'question')->textarea(['rows' => 6]) ?>

    <?php
    $answers = Answer::find()
        ->andWhere(['question_id' => $model->id])
        ->select(['id', 'answer'])
        ->asArray()
        ->all();

    $answerItems = ArrayHelper::map($answers, 'id', 'answer');
    ?>
    <?= $form->field($model, 'answer')->dropDownList($answerItems) ?>


    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақтау'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
