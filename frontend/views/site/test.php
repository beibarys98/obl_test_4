<?php

use common\models\Answer;
use common\models\ParticipantAnswer;
use common\models\Question;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\web\YiiAsset;

/** @var $this */
/** @var $test */
/** @var $question */
/** @var $participant */

$this->title = 'Тест';

YiiAsset::register($this);

$durationArray = explode(':', $test->duration);
$totalDurationInSeconds = ($durationArray[0] * 3600) + ($durationArray[1] * 60) + $durationArray[2];
$totalDurationInSeconds = max($totalDurationInSeconds, 0);

$startTime = new DateTime($participant->start_time);
$currentTime = new DateTime('now');
$elapsedTimeInSeconds = $currentTime->getTimestamp() - $startTime->getTimestamp();
$remainingTimeInSeconds = $totalDurationInSeconds - $elapsedTimeInSeconds;
$remainingTimeInSeconds = max($remainingTimeInSeconds, 0);

$this->registerJs("
    function startTimer(duration, display) {
        var timer = duration, hours, minutes, seconds;
        
        var interval = setInterval(function () {
        
            hours = parseInt(timer / 3600, 10); // Calculate hours
            minutes = parseInt((timer % 3600) / 60, 10); // Calculate minutes
            seconds = parseInt(timer % 60, 10); // Calculate seconds
            
            hours = hours < 10 ? '0' + hours : hours;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            display.textContent = hours + ':' + minutes + ':' + seconds;
            
            if (--timer < 0) {
                timer = 0;
                clearInterval(interval);
                window.location = \"" . Url::to(['site/end', 'id' => $question->id]) . "\";
            }
        }, 1000);
    }

    window.onload = function () {
        var duration = $remainingTimeInSeconds; // Countdown duration in seconds
        var display = document.querySelector('#clock'); // Timer display element
        startTimer(duration, display);
    };
", View::POS_END);
?>

<div class="test-view">

    <?= Alert::widget() ?>

    <div class="d-flex">
        <div style="width: 70%;">
            <div style="font-size: 24px;
    user-select: none; -webkit-user-select: none; -moz-user-select: none;
    -ms-user-select: none;">
                <?php if ($question->img_path): ?>
                    <?= Html::img(Url::to('@web/' . $question->img_path), ['style' => 'max-width: 70%;']) ?>
                <?php else: ?>
                    <?= $question->question; ?>
                <?php endif; ?>

                <br>

                <?php
                $answers = Answer::find()
                    ->andWhere(['question_id' => $question->id])
                    ->orderBy('RAND()')
                    ->all();
                ?>

                <form class="mt-5" id="answerForm" action="<?= Url::to(['site/submit']) ?>" method="get">
                    <?php
                    $participantAnswer = ParticipantAnswer::find()
                        ->andWhere(['participant_id' => $participant->id, 'question_id' => $question->id])
                        ->one();
                    $selectedAnswerId = $participantAnswer ? $participantAnswer->answer_id : null; ?>

                    <?php foreach ($answers as $a): ?>
                        <input type="radio" name="answer_id" value="<?= $a->id ?>"
                               class="form-check-input me-1"
                            <?= $selectedAnswerId == $a->id ? 'checked' : '' ?>>
                        <?php if ($a->img_path): ?>
                            <?= Html::img(Url::to('@web/' . $a->img_path), ['style' => 'max-width: 30%;']) ?><br>
                        <?php else: ?>
                            <?= $a->answer; ?><br>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <input type="hidden" name="question_id" value="<?= $question->id ?>">

                    <button type="submit" class="btn btn-primary mt-5" data-pjax="false">
                        <?= Yii::t('app', 'Сақтау') ?>
                    </button>
                </form>
            </div>
        </div>

        <?php
        $questions = Question::find()->andWhere(['test_id' => $test->id])->all();
        ?>

        <div style="width: 30%;">
            <div class="card shadow-sm p-3">
                <div style="display: flex; flex-wrap: wrap; justify-content: center;">
                    <?php $index = 1; ?>
                    <?php foreach ($questions as $q): ?>
                        <?php
                        $participantAnswer = ParticipantAnswer::find()
                            ->andWhere(['participant_id' => $participant->id, 'question_id' => $q->id])->one();
                        $backgroundColor = $participantAnswer && $participantAnswer->answer_id ? '#157347' : '#BB2D3B';
                        $borderStyle = ($q->id == $question->id) ? '5px solid #0B5ED7' : 'none'; ?>

                        <a href="<?= Url::to(['test', 'id' => $q->id]) ?>" style="text-decoration: none;">
                            <div style="width: 40px; height: 40px; display: flex; align-items: center;
                                    justify-content: center; border: <?= $borderStyle ?>;
                                    background-color: <?= $backgroundColor ?>;
                                    color: white; font-size: 14px; margin: 2px; border-radius: 5px;">
                                <?= $index++ ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="jumbotron" style="text-align: center;">

                    <a href="<?= Url::to(['site/end', 'id' => $question->id]) ?>" class="btn btn-danger mt-5">
                        <?= Yii::t('app', 'Аяқтау') ?>
                    </a>

                    <div id="clock" class="card shadow-sm p-1 mt-3" style="font-size: 24px;">
                        hh:mm:ss
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>