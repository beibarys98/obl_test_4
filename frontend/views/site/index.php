<?php

/** @var yii\web\View $this */
/** @var $participantDP */
/** @var $receiptDP */
/** @var $testDP */
/** @var $reportDP */
/** @var $certificateDP */
/** @var $receipt */

use common\models\Participant;
use common\models\Question;
use common\models\Settings;
use yii\bootstrap5\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::$app->name;

$participant = Participant::findOne(['user_id' => Yii::$app->user->id]);
$settings = Settings::findOne(1);
?>

<div class="site-index">

    <div class="card p-3 shadow">
        <h1><?= Yii::t('app', 'Қатысушы') ?></h1>

        <?= GridView::widget([
            'dataProvider' => $participantDP,
            'tableOptions' => ['class' => 'table table-hover'],
            'summary' => false,
            'columns' => [
                [
                    'label' => Yii::t('app', 'ЖСН'),
                    'attribute' => 'username',
                    'value' => 'user.username',
                    'enableSorting' => false,
                ],
                [
                    'label' => Yii::t('app', 'Толық аты-жөні'),
                    'attribute' => 'name',
                    'enableSorting' => false,
                ],
                [
                    'label' => Yii::t('app', 'Мекеме'),
                    'attribute' => 'school',
                    'enableSorting' => false,
                ],
                [
                    'label' => Yii::t('app', 'Пән'),
                    'attribute' => Yii::$app->language === 'kz' ? 'subject.title_kz' : 'subject.title_ru',
                    'enableSorting' => false,
                ],
                [
                    'label' => Yii::t('app', 'Тест тапсыру тілі'),
                    'attribute' => 'language',
                    'value' => function ($model) {
                        return $model->language === 'kz' ? Yii::t('app', 'қазақша') : Yii::t('app', 'орысша') ;
                    },
                    'headerOptions' => ['style' => 'width: 5%;'],
                    'enableSorting' => false,
                ],
            ],
        ]); ?>
    </div>

    <br>

    <div class="card p-3 shadow">
        <h1><?= Yii::t('app', 'Төлем') ?></h1>

        <?= GridView::widget([
            'dataProvider' => $receiptDP,
            'tableOptions' => ['class' => 'table table-hover'],
            'showHeader' => false,
            'summary' => false,
            'columns' => [
                [
                    'attribute' => 'file_path',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return empty($model->file_path)
                            ? Yii::t('app', 'Түбіртек жүктеңіз!')
                            : Html::a(Yii::t('app', 'Түбіртек') . '.pdf', [$model->file_path], ['target' => '_blank']);
                    },
                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->participant->payment_time
                            ? date('H:i:s d/m/Y', strtotime($model->participant->payment_time))
                            : '';
                    },

                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::tag('div',
                            Html::button(Yii::t('app', 'Жүктеу'), [
                                'class' => 'btn btn-primary',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#exampleModal',
                            ]),
                            ['style' => 'text-align: right;']
                        );
                    },
                ],
            ],
        ]); ?>
    </div>

    <br>

    <div class="card p-3 shadow">
        <h1><?= Yii::t('app', 'Тест') ?></h1>

        <?= GridView::widget([
            'dataProvider' => $testDP,
            'tableOptions' => ['class' => 'table table-hover'],
            'showHeader' => false,
            'summary' => false,
            'emptyText' => Yii::t('app', 'Тест жарияланбады!'),
            'columns' => [
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Yii::$app->language == 'kz' ? $model->subject->title_kz : $model->subject->title_ru ;
                    }
                ],
                [
                    'attribute' => 'language',
                ],
                [
                    'attribute' => 'duration',
                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) use ($participant) {
                        $isActive = ($participant->payment_time && !$participant->end_time) ? 'active' : 'disabled';

                        $firstQuestion = Question::find()->andWhere(['test_id' => $model->id])->one();
                        $firstQuestionId = $firstQuestion ? $firstQuestion->id : null;

                        return Html::tag('div',
                            Html::a(Yii::t('app', 'Бастау'),
                                ['site/test', 'id' => $firstQuestionId],
                                [
                                    'class' => 'btn btn-primary ' . $isActive,
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Сенімдісіз бе?'),
                                    ],
                                ]),
                            ['style' => 'text-align: right;']
                        );
                    },
                ],
            ],
        ]); ?>
    </div>

    <br>

    <div class="card shadow p-3">
        <h1><?= Yii::t('app', 'Қатемен жұмыс') ?></h1>

        <?= GridView::widget([
            'dataProvider' => $reportDP,
            'tableOptions' => ['class' => 'table table-hover'],
            'showHeader' => false,
            'summary' => false,
            'emptyText' => Yii::t('app', 'Тестті аяқтаңыз!'),
            'columns' => [
                [
                    'attribute' => 'file_path',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return 'Қатемен жұмыс.xlsx';
                    }
                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::tag('div',
                            Html::a(Yii::t('app', 'Жүктеп алу'),
                                ['download', 'path' => $model->file_path],
                                ['class' => 'btn btn-primary']),
                            ['style' => 'text-align: right;']
                        );
                    }
                ]
            ],
        ]); ?>
    </div>

    <br>

    <div class="card p-3 shadow">
        <h1><?= Yii::t('app', 'Сертификат') ?></h1>

        <?= GridView::widget([
            'dataProvider' => $certificateDP,
            'tableOptions' => ['class' => 'table table-hover'],
            'showHeader' => false,
            'summary' => false,
            'emptyText' => Yii::t('app', 'Марапатты күтіңіз!'),
            'columns' => [
                [
                    'attribute' => 'file_path',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return empty($model->file_path)
                            ?: Html::a('Сертификат.jpg', [$model->file_path], ['target' => '_blank']);
                    }
                ],
                [
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::tag('div',
                            Html::a(Yii::t('app', 'Жүктеп алу'),
                                ['download', 'path' => $model->file_path],
                                ['class' => 'btn btn-primary']),
                            ['style' => 'text-align: right;']
                        );
                    }
                ]
            ],
        ]); ?>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="/images/qr.jpg" alt="" width="200px"
                     class="card shadow-sm"
                     style="display: block; margin: 0 auto;">

                <div class="card shadow-sm p-3 mt-1">
                    <label for="student-name"><?= Yii::t('app', 'ФИО учащегося') ?></label>
                    <input id="student-name" type="text" value="<?= $participant->name ?>" class="form-control" disabled>
                    <label class="mt-1" for="payment-purpose"><?= Yii::t('app', 'Назначение платежа') ?></label>
                    <input id="payment-purpose" type="text" value="<?= $settings->purpose ?>" class="form-control" disabled>
                    <label class="mt-1" for="payment-amount"><?= Yii::t('app', 'Сумма') ?></label>
                    <input id="payment-amount" type="text" value="<?= $settings->cost ?> ₸" class="form-control" disabled>
                </div>

                <div class="card shadow-sm p-3 mt-1">
                    <?php
                    $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data'],
                    ]); ?>

                    <div class="text-center">
                        <?= $form->field($receipt, 'file')->fileInput()->label(false) ?>
                        <?= Html::submitButton(Yii::t('app', 'Жүктеу'), ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>