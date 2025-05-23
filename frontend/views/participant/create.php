<?php

use common\models\Subject;
use common\models\Test;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Participant $model */

$this->title = Yii::t('app', 'Тіркелген қосу');

?>
<div class="participant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'email')->input('email', [
        'placeholder' => '',
    ]) ?>

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

    <?php
    $languages = [
        'kz' => Yii::t('app', 'қазақша'),
        'ru' => Yii::t('app', 'орысша'),
    ];

    echo $form->field($model, 'language')->widget(Select2::classname(), [
        'data' => $languages,
        'options' => [
            'placeholder' => '',
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақтау'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
