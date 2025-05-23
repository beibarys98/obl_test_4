<?php

namespace frontend\controllers;

use common\models\Admin;
use common\models\Answer;
use common\models\File;
use common\models\Participant;
use common\models\ParticipantAnswer;
use common\models\Question;
use common\models\search\ParticipantSearch;
use common\models\Test;
use DateTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\SignupForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['site/login']);
        }

        if(Admin::findOne(['user_id' => Yii::$app->user->id])){
            return $this->redirect(['participant/index']);
        }

        //setup
        $participant = Participant::findOne(['user_id' => Yii::$app->user->id]);

        //participant info
        $participantSM = new ParticipantSearch();
        $queryParams = $this->request->queryParams;
        $queryParams['user_id'] = Yii::$app->user->id;
        $participantDP = $participantSM->search($queryParams);

        //receipt info
        $receiptDP = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['participant_id' => $participant->id])
                ->andWhere(['type' => 'receipt'])
                ->orderBy(['id' => SORT_DESC])
                ->limit(1),
        ]);

        //test info
        if(!$participant->test_id){
            $tests = Test::find()
                ->andWhere(['status' => 'public'])
                ->andWhere(['subject_id' => $participant->subject_id])
                ->andWhere(['language' => $participant->language])
                ->all();

            if (!empty($tests)) {
                $participant->test_id = $tests[array_rand($tests)]->id;
                $participant->save(false);
            }
        }
        $testDP = new ActiveDataProvider([
            'query' => Test::find()
                ->andWhere(['status' => 'public'])
                ->andWhere(['id' => $participant->test_id]),
        ]);

        //report info
        $reportDP = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['participant_id' => $participant->id])
                ->andWhere(['type' => 'report'])
                ->orderBy(['id' => SORT_DESC])
                ->limit(1),
            'pagination' => false
        ]);

        //certificates info
        $certificateDP = new ActiveDataProvider([
            'query' => File::find()
                ->andWhere(['participant_id' => $participant->id])
                ->andWhere(['type' => 'certificate'])
                ->orderBy(['id' => SORT_DESC])
                ->limit(1),
            'pagination' => false
        ]);

        //receipt upload
        $receipt = File::findOne(['participant_id' => $participant->id, 'type' => 'receipt']);
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstance($receipt, 'file');

            if ($file) {

                $filePath = 'receipts/'
                    . Yii::$app->security->generateRandomString(8) . '.'
                    . $file->extension;

                if ($file->saveAs($filePath)) {
                    $receipt->file_path = $filePath;
                    $receipt->save(false);

                    $participant->payment_time = date('Y-m-d H:i:s');
                    $participant->save(false);

                    return $this->redirect(['site/index']);
                }
            }
        }

        return $this->render('index', [
            'participantDP' => $participantDP,
            'receiptDP' => $receiptDP,
            'testDP' => $testDP,
            'reportDP' => $reportDP,
            'certificateDP' => $certificateDP,
            'receipt' => $receipt,
        ]);
    }

    public function actionDownload($path)
    {
        $filePath = Yii::getAlias('@webroot/') . $path;

        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath);
        } else {
            throw new NotFoundHttpException('The requested file does not exist.');
        }
    }

    public function actionTest($id){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        $question = Question::findOne($id);
        $test = Test::findOne($question->test_id);
        $participant = Participant::findone(['user_id' => Yii::$app->user->id]);

        if(!$participant->start_time){
            $receipt = File::findOne(['participant_id' => $participant->id, 'type' => 'receipt']);
            $receipt->test_id = $test->id;
            $receipt->save(false);

            $participant->start_time = date('Y-m-d H:i:s');
            $participant->save(false);
        }

        return $this->render('/site/test', [
            'test' => $test,
            'question' => $question,
            'participant' => $participant,
        ]);
    }

    public function actionSubmit()
    {
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        $answerId = Yii::$app->request->get('answer_id');
        $questionId = Yii::$app->request->get('question_id');
        $participantId = Participant::findOne(['user_id' => Yii::$app->user->id])->id;
        $participantAnswer = ParticipantAnswer::findOne([
            'participant_id' => $participantId,
            'question_id' => $questionId,
        ]);
        if (!$participantAnswer) {
            $participantAnswer = new ParticipantAnswer();
            $participantAnswer->participant_id = $participantId;
            $participantAnswer->question_id = $questionId;
        }
        $participantAnswer->answer_id = $answerId;
        $participantAnswer->save(false);

        $nextQuestion = Question::find()
            ->andWhere(['test_id' => Question::findOne($questionId)->test_id])
            ->andWhere(['>', 'id', $questionId])
            ->orderBy(['id' => SORT_ASC])
            ->one();
        if (!$nextQuestion) {
            $nextQuestion = Question::findOne(['test_id' => Question::findOne($questionId)->test_id]);
        }

        return $this->redirect(['site/test', 'id' => $nextQuestion->id]);
    }

    public function actionEnd($id){
        if(Yii::$app->user->isGuest){
            return $this->redirect(['/site/login']);
        }

        $test = Test::findOne(Question::findOne($id)->test_id);
        $participant = Participant::findOne(['user_id' => Yii::$app->user->id]);

        //unanswered questions? return to test
        $now = new DateTime();
        $startTime = new DateTime($participant->start_time);
        $testDuration = new DateTime($test->duration);
        $h = (int)$testDuration->format('H') * 3600;
        $i = (int)$testDuration->format('i') * 60;
        $s = (int)$testDuration->format('s');
        $durationInSeconds = $h + $i + $s;
        $timeElapsed = $now->getTimestamp() - $startTime->getTimestamp();
        if ($timeElapsed < $durationInSeconds) {
            $totalQuestions = Question::find()
                ->andWhere(['test_id' => $test->id])
                ->count();
            $answeredQuestions = ParticipantAnswer::find()
                ->joinWith('question')
                ->andWhere(['participant_answer.participant_id' => $participant->id])
                ->andWhere(['question.test_id' => $test->id])
                ->andWhere(['IS NOT', 'participant_answer.answer_id', null])
                ->count();
            if ($answeredQuestions != $totalQuestions) {
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Барлық сұрақтарға жауап беріңіз!'));
                return $this->redirect(['site/test', 'id' => $id]);
            }
        }

        //save end time
        $participant->end_time = (new \DateTime())->format('Y-m-d H:i:s');
        $participant->save(false);

        //save results in db
        $questions = Question::find()->andWhere(['test_id' => $test->id])->all();
        $score = 0;
        foreach ($questions as $q) {
            $participantAnswer = ParticipantAnswer::findOne([
                'participant_id' => $participant->id,
                'question_id' => $q->id]);

            if ($participantAnswer !== null) {;
                if ($participantAnswer->answer_id == $q->answer) {
                    $score++;
                }
            }
        }
        $participant->result = $score;
        $participant->save(false);

        //create report
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Cұрақ');
        $sheet->setCellValue('B1', 'Дұрыс жауабы');
        $sheet->setCellValue('C1', 'Мұғалім жауабы');
        $row = 2;
        foreach ($questions as $question) {
            $sheet->setCellValue('A' . $row, $question->question);
            $answer = Answer::findOne($question->answer)->answer;
            $sheet->setCellValue('B' . $row, $answer);
            $participantAnswer = ParticipantAnswer::find()
                ->andWhere(['participant_id' => $participant->id])
                ->andWhere(['question_id' => $question->id])
                ->one();
            $participantAnswerText = $participantAnswer && $participantAnswer->answer
                ? $participantAnswer->answer->answer
                : '---';
            $sheet->setCellValue('C' . $row, $participantAnswerText);
            $row++;
        }
        $filePath = 'reports/' . Yii::$app->security->generateRandomString(8) . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        $report = new File();
        $report->participant_id = $participant->id;
        $report->test_id = $test->id;
        $report->type = 'report';
        $report->file_path = $filePath;
        $report->save(false);

        return $this->redirect(['/site/index']);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
