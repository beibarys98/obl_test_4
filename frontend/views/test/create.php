<?php

use common\models\Subject;
use kartik\select2\Select2;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Test $model */

$this->title = Yii::t('app', 'Тест қосу');

?>
<div class="test-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <?php
    $subjectField = (Yii::$app->language === 'kz') ? 'title_kz' : 'title_ru';
    $subjects = ArrayHelper::map(Subject::find()->all(), 'id', $subjectField);
    ?>

    <?= $form->field($model, 'subject_id')
        ->widget(Select2::classname(),
            [
                'data' => $subjects,
                'options' => [
                    'placeholder' => '',
                    'style' => ['width' => '100%'],
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]
        ); ?>

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

    <?= $form->field($model, 'version')->textInput([
        'type' => 'number',
        'min' => 1,
        'step' => 1,
    ]) ?>

    <?= $form->field($model, 'duration')->input('time', ['step' => 1])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Сақтау'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
