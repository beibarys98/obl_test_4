<?php

use common\models\Settings;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\search\SettingsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Баптаулар');
?>
<div class="settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            'purpose',
            'cost',
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'urlCreator' => function ($action, Settings $model, $key, $index, $column) {
                    return Url::toRoute(['settings/purpose', 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            'first',
            'second',
            'third',
            'fourth',
            'fifth',
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'urlCreator' => function ($action, Settings $model, $key, $index, $column) {
                    return Url::toRoute(['settings/places', 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            'acw',
            'cx',
            'name_y',
            'number_x',
            'number_y',
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'urlCreator' => function ($action, Settings $model, $key, $index, $column) {
                    return Url::toRoute(['settings/image', 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
