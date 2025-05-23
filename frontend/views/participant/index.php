<?php

use common\models\File;
use common\models\Participant;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\ParticipantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Қатысушылар');

?>
<div class="participant-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Қосу'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            'result',
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
                'urlCreator' => function ($action, Participant $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
