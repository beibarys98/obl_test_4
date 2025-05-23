<?php

use common\models\Answer;
use common\models\File;
use common\models\Participant;
use common\models\Question;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Test $model */
/** @var $mode */
/** @var $dataProvider */
/** @var $searchModel */
/** @var $receipts */

$this->title = 'test_id_' . $model->id;

\yii\web\YiiAsset::register($this);
?>
<div class="test-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <hr>

    <div>
        <?= Html::a('жаңа',
            ['test/new', 'id' => $model->id],
            ['class' => $model->status == 'new' ? 'btn btn-primary' : 'btn btn-outline-primary']) ?>
        <?= Html::a('дайын',
            ['test/ready', 'id' => $model->id],
            ['class' => $model->status == 'ready' ? 'btn btn-primary' : 'btn btn-outline-primary']) ?>
        <?= Html::a('жариялау',
            ['test/publish', 'id' => $model->id],
            ['class' => $model->status == 'public' ? 'btn btn-primary' : 'btn btn-outline-primary']) ?>
        <?= Html::a('аяқтау',
            ['test/end', 'id' => $model->id],
            ['class' => $model->status == 'finished' ? 'btn btn-primary' : 'btn btn-outline-primary']) ?>
        <?= Html::a('марапаттау',
            ['test/certificate', 'id' => $model->id],
            ['class' => $model->status == 'certificated' ? 'btn btn-primary' : 'btn btn-outline-primary']) ?>
    </div>

    <hr>

    <div>
        <?= Html::a('тест',
            ['test/view', 'id' => $model->id, 'mode' => 'test'],
            ['class' => $mode == 'test' ? 'btn btn-secondary' : 'btn btn-outline-secondary']) ?>
        <?= Html::a('қатысушылар',
            ['test/view', 'id' => $model->id, 'mode' => 'participants'],
            ['class' => $mode == 'participants' ? 'btn btn-secondary' : 'btn btn-outline-secondary']) ?>
        <?= Html::a('түбіртектер',
            ['test/receipts', 'id' => $model->id, 'mode' => $mode],
            ['class' => $mode == 'receipts' ? 'btn btn-secondary' : 'btn btn-outline-secondary']) ?>
    </div>

    <hr>

    <div>
        <?= Html::a('нәтиже',
            ['test/result', 'id' => $model->id],
            ['class' => 'btn btn-outline-danger']) ?>
        <?= Html::a('журнал',
            ['test/journal', 'id' => $model->id],
            ['class' => 'btn btn-outline-danger']) ?>
    </div>

    <hr>

    <?php if($mode == 'test'): ?>
        <div style="font-size: 20px;">
            <?php
            $questions = Question::find()->andWhere(['test_id' => $model->id])->all();

            foreach ($questions as $index => $question) {
                echo Html::a('_/',
                        ['question/update', 'id' => $question->id],
                        ['class' => 'btn btn-sm btn-outline-primary']) . ' ';
                echo Html::a('Х',
                        ['question/delete', 'id' => $question->id],
                        [
                            'class' => 'btn btn-sm btn-outline-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Сенімдісіз бе?'),
                                'method' => 'post',
                            ],
                        ]) . ' ';
                echo $index + 1 . '. ';
                if($question->img_path){
                    echo Html::img(Yii::getAlias('@web/') . $question->img_path, ['style' => 'max-width: 80%; padding: 10px;']) . '<br>';
                }else{
                    echo $question->question . '<br>';
                }
                $answers = Answer::find()->andWhere(['question_id' => $question->id])->all();
                $alphabet = range('A', 'Z');
                foreach ($answers as $index2 => $answer) {
                    if($question->answer == $answer->id){
                        echo '<span style="margin: 15px;"></span>'
                            . Html::a('_/',
                                ['answer/update', 'id' => $answer->id],
                                ['class' => 'btn btn-sm btn-outline-primary']) . ' ';
                        echo Html::a('Х',
                                ['answer/delete', 'id' => $answer->id],
                                [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Сенімдісіз бе?'),
                                        'method' => 'post',
                                    ],
                                ]) . ' ';
                        echo '<strong>' . $alphabet[$index2] . '. ' .'</strong>';
                        if($answer->img_path){
                            echo Html::img(Yii::getAlias('@web/') . $answer->img_path, ['style' => 'max-width: 80%; padding: 10px;']) . '<br>';
                        }else{
                            echo '<strong>' . $answer->answer . '<br>' .'</strong>';
                        }
                    }else{
                        echo '<span style="margin: 15px;"></span>'
                            . Html::a('_/',
                                ['answer/update', 'id' => $answer->id],
                                ['class' => 'btn btn-sm btn-outline-primary']) . ' ';
                        echo Html::a('Х',
                                ['answer/delete', 'id' => $answer->id],
                                [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Сенімдісіз бе?'),
                                        'method' => 'post',
                                    ],
                                ]) . ' ';
                        echo $alphabet[$index2] . '. ';
                        if($answer->img_path){
                            echo Html::img(Yii::getAlias('@web/') . $answer->img_path, ['style' => 'max-width: 80%; padding: 10px;']) . '<br>';
                        }else{
                            echo $answer->answer . '<br>';
                        }
                    }
                }
                echo '<span style="margin: 15px;"></span>'
                    . Html::a('+ жауап',
                        ['answer/create', 'id' => $question->id],
                        ['class' => 'btn btn-sm btn-outline-primary']) . '<br>';

            }
            echo Html::a('+ сұрақ',
                    ['question/create', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-outline-primary']) . '<br>';
            ?>
        </div>
    <?php elseif($mode == 'receipts'): ?>
        <div class="row">
            <?php foreach ($receipts as $file): ?>
                <div class="col-12 col-sm-6 col-md-2 mb-4">
                    <div class="card shadow-sm h-100">
                        <iframe
                                src="<?= Yii::getAlias('@web') . '/' . ltrim($file->file_path, '/') ?>#toolbar=0"
                                style="width: 100%; height: 300px; border: none;">
                        </iframe>
                        <div class="card-body text-center">
                            <p class="card-text"><?= Html::encode($file->participant->name ?? 'Аты жоқ қатысушы') ?></p>
                            <p class="card-text"><?= Html::encode($file->participant->user->username ?? 'Аты жоқ қатысушы') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['width' => '5%'],
                ],
                [
                    'attribute' => 'username',
                    'value' => 'user.username',
                ],
                'name',
                [
                    'label' => 'Times',
                    'attribute' => 'start_time',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $paymentTime = $model->payment_time ?? '---';
                        $startTime = $model->start_time ?? '---';
                        $endTime = $model->end_time ?? '---';

                        return $paymentTime . '<br>' . $startTime . '<br>' . $endTime;
                    }
                ],
                [
                    'attribute' => 'result',
                    'headerOptions' => ['width' => '5%'],
                ],
                [
                    'label' => 'Files',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $receipt = File::find()
                            ->andWhere(['participant_id' => $model->id, 'type' => 'receipt'])
                            ->orderBy(['id' => SORT_DESC])
                            ->one();

                        $report = File::find()
                            ->andWhere(['participant_id' => $model->id, 'type' => 'report'])
                            ->orderBy(['id' => SORT_DESC])
                            ->one();

                        $certificate = File::find()
                            ->andWhere(['participant_id' => $model->id, 'type' => 'certificate'])
                            ->orderBy(['id' => SORT_DESC])
                            ->one();


                        $receiptLink = $receipt->file_path ? Html::a('Квитанция', [$receipt->file_path], ['target' => '_blank', 'data-pjax' => '0']) : '---';
                        $reportLink = $report ? Html::a('Репорт', [$report->file_path], ['target' => '_blank', 'data-pjax' => '0']) : '---';
                        $certificateLink = $certificate ? Html::a('Марапат', [$certificate->file_path], ['target' => '_blank', 'data-pjax' => '0']) : '---';

                        return $receiptLink . '<br>' . $reportLink . '<br>' . $certificateLink;
                    }
                ],
                [
                    'class' => ActionColumn::className(),
                    'template' => '{view} {update} {delete} <br> {custom}',
                    'urlCreator' => function ($action, Participant $model, $key, $index, $column) {
                        return Url::toRoute(['participant/' . $action, 'id' => $model->id]);
                    },
                    'buttons' => [
                        'custom' => function ($url, $model, $key) {
                            return Html::a(
                                '<i class="fa-solid fa-file"></i>',
                                ['test/single-certificate', 'id' => $model->id],
                            );
                        },
                    ],
                ]
            ],
        ]); ?>
    <?php endif; ?>

</div>
