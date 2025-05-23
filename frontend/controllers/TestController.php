<?php

namespace frontend\controllers;

use common\models\Answer;
use common\models\File;
use common\models\Participant;
use common\models\ParticipantTest;
use common\models\Question;
use common\models\search\ParticipantSearch;
use common\models\search\ParticipantTestSearch;
use common\models\Settings;
use common\models\Test;
use common\models\search\TestSearch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use ZipArchive;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id, $mode = 'participants')
    {
        $searchModel = new ParticipantSearch();
        $queryParams = $this->request->queryParams;
        $queryParams['test_id'] = $id;
        $dataProvider = $searchModel->search($queryParams);

        $receipts = File::find()
            ->andWhere(['test_id' => $id])
            ->andWhere(['type' => 'receipt'])
            ->all()
        ;

        return $this->render('view', [
            'model' => $this->findModel($id),
            'mode' => $mode,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'receipts' => $receipts,
        ]);
    }

    private function parse($filePath, $test_id)
    {
        $zip = new \ZipArchive();
        if ($zip->open($filePath) === true) {
            $xmlContent = $zip->getFromName('word/document.xml');
            $zip->close();

            // Remove MathML (entire <m:oMath> blocks)
            $xmlContent = preg_replace('/<m:oMath[^>]*>.*?<\/m:oMath>/s', '', $xmlContent);

            // Load the corrected XML into DOMDocument
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true); // Prevent warnings
            $dom->loadXML($xmlContent);
            libxml_clear_errors();

            // Extract text (ignoring formulas and images)
            $paragraphs = $dom->getElementsByTagName('p');
            $text = '';
            foreach ($paragraphs as $p) {
                $text .= trim($p->textContent) . "\n";
            }

            // Call function to process extracted text
            $this->processText($text, $test_id);
        } else {
            throw new \Exception('Failed to open the .docx file.');
        }
    }

    private function processText($text, $test_id)
    {
        $lines = explode("\n", $text);
        $currentQuestionText = '';
        $answers = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // Check if the line is an answer
            if (preg_match('/^[\p{Latin}\p{Cyrillic}]\s*[.)]\s*(.*)/u', $line, $match)) {
                $answers[] = trim($match[1]);
            }
            // Check if the line is a question number
            elseif (preg_match('/^\s*\d+\s*[.)]\s*(.*)/', $line, $match)) {
                if ($currentQuestionText !== '' && !empty($answers)) {
                    $this->saveQuestion($currentQuestionText, $answers, $test_id);
                }
                // Start a new question
                $currentQuestionText = $match[1];
                $answers = [];
            }
            // Otherwise, it's part of the question text
            else {
                $currentQuestionText .= "\n" . $line;
            }
        }

        // Save the last question
        if ($currentQuestionText !== '' && !empty($answers)) {
            $this->saveQuestion($currentQuestionText, $answers, $test_id);
        }
    }

    private function saveQuestion($questionText, $answers, $test_id)
    {
        $question = new Question();
        $question->test_id = $test_id;
        $question->question = trim($questionText);
        $question->save(false);

        $firstAnswerId = null; // Store the first answer's ID

        foreach ($answers as $index => $ansText) {
            $answer = new Answer();
            $answer->question_id = $question->id;
            $answer->answer = trim($ansText);
            $answer->save(false);

            if ($index === 0) {
                $firstAnswerId = $answer->id; // Save first answer's ID
            }
        }

        // Update question->answer with the first answer's ID
        if ($firstAnswerId !== null) {
            $question->answer = $firstAnswerId;
            $question->save(false, ['answer']); // Save only 'answer' field
        }
    }

    public function actionCreate()
    {
        $model = new Test();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->file  = UploadedFile::getInstance($model, 'file');

                if($model->file){
                    $filePath = 'uploads/'
                        . Yii::$app->security->generateRandomString(8)
                        . '.' . $model->file->extension;

                    $model->file->saveAs($filePath);
                    $model->status = 'new';
                    $model->save(false);

                    $this->parse($filePath, $model->id);

                    unlink($filePath);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionNew($id){
        $model = $this->findModel($id);
        $model->status = 'new';
        $model->save(false);
        return $this->redirect(['test/view',
            'id' => $id,
            'mode' => 'test'
        ]);
    }

    public function actionReady($id){
        $model = $this->findModel($id);
        $model->status = 'ready';
        $model->save(false);
        return $this->redirect(['test/view',
            'id' => $id
        ]);
    }

    public function actionPublish($id){
        $model = $this->findModel($id);
        $model->status = 'public';
        $model->save(false);
        return $this->redirect(['test/view',
            'id' => $id
        ]);
    }

    public function actionEnd($id){
        $model = $this->findModel($id);
        $model->status = 'finished';
        $model->save(false);
        return $this->redirect(['test/view',
            'id' => $id
        ]);
    }

    public function actionResult($id)
    {
        //save results in xlsx
        $participants = Participant::find()
            ->andWhere(['test_id' => $id])
            ->orderBy(['result' => SORT_DESC])
            ->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Есімі');
        $sheet->setCellValue('B1', 'Мекеме');
        $sheet->setCellValue('C1', 'Нәтиже');

        $row = 2;
        foreach ($participants as $participant) {
            $sheet->setCellValue('A' . $row, $participant->name);
            $sheet->setCellValue('B' . $row, $participant->school);
            $sheet->setCellValue('C' . $row, $participant->result);
            $row++;
        }

        $filePath = 'uploads/' . Yii::$app->security->generateRandomString(8) . '.xlsx'; // Construct the file path
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $test = Test::findOne($id);
        $filename = trim($test->subject->title_kz) . ' ' . $test->language . ' ' . $test->version . ' нәтиже.xlsx';

        return Yii::$app->response->sendFile($filePath, $filename);
    }

    private function certificate($participant, $test, $place)
    {
        $imgPath = Yii::getAlias("@webroot/templates/{$test->subject->id}/{$place}.jpg");
        $image = imagecreatefromjpeg($imgPath);
        $textColor = imagecolorallocate($image, 227, 41, 29);
        $fontPath = Yii::getAlias('@frontend/fonts/times.ttf');

        //writing name
        $settings = Settings::findOne(1);
        $averageCharWidth = $settings->acw;
        $numChars = strlen($participant->name);
        $textWidth = $numChars * $averageCharWidth;
        $cx = $settings->cx;
        $x = (int)($cx - ($textWidth / 2));
        //imagettftext($image, 30, 0, $cx, 760, $textColor, $fontPath, '0');
        imagettftext($image, 30, 0, $x, $settings->name_y, $textColor, $fontPath, $participant->name);

        //writing number
        $formattedId = str_pad($participant->id, 5, '0', STR_PAD_LEFT);
        imagettftext($image, 30, 0, $settings->number_x, $settings->number_y, $textColor, $fontPath, $formattedId);

        //saving file
        $newPath = 'certificates/' . Yii::$app->security->generateRandomString(8) . '.jpg'; ;
        imagejpeg($image, $newPath);
        imagedestroy($image);

        //send email
        $email = $participant->user->email;
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'sendCertificate-html'],
                ['participant' => $participant]
            )
            ->setFrom(['beibarys.mukhammedyarov@alumni.nu.edu.kz' => Yii::t('app', Yii::$app->name)])
            ->setTo($email)
            ->setSubject(Yii::t('app', Yii::$app->name))
            ->attach(Yii::getAlias("@webroot/{$newPath}"))
            ->send();

        //saving to db
        $certificate = new File();
        $certificate->participant_id = $participant->id;
        $certificate->test_id = $test->id;
        $certificate->type = 'certificate';
        $certificate->file_path = $newPath;
        $certificate->save(false);
    }

    public function actionCertificate($id)
    {
        $test = Test::findOne($id);
        $test->status = 'certificated';
        $test->save(false);

        //send certificates
        $topResults = Participant::find()
            ->andWhere(['test_id' => $id])
            ->orderBy(['result' => SORT_DESC])
            ->all();

        $firstPlace = [];
        $secondPlace = [];
        $thirdPlace = [];
        $goodResults = [];
        $certificateResults = [];

        $percentage = Settings::find()->one();

        foreach ($topResults as $result) {
            if ($result->result >= $percentage->first) {
                $firstPlace[] = $result;
            }
            else if ($result->result < $percentage->first && $result->result >= $percentage->second) {
                $secondPlace[] = $result;
            }
            else if ($result->result < $percentage->second && $result->result >= $percentage->third) {
                $thirdPlace[] = $result;
            }
            else if ($result->result < $percentage->third && $result->result >= $percentage->fourth) {
                $goodResults[] = $result;
            }
            else if ($result->result < $percentage->fourth && $result->result >= $percentage->fifth) {
                $certificateResults[] = $result;
            }
        }

        foreach ($firstPlace as $result) {
            $this->certificate(Participant::findOne($result->id), $test, 'first');
        }
        foreach ($secondPlace as $result) {
            $this->certificate(Participant::findOne($result->id), $test, 'second');
        }
        foreach ($thirdPlace as $result) {
            $this->certificate(Participant::findOne($result->id), $test, 'third');
        }
        foreach ($goodResults as $result) {
            $this->certificate(Participant::findOne($result->id), $test, 'fourth');
        }
        foreach ($certificateResults as $result) {
            $this->certificate(Participant::findOne($result->id), $test, 'fifth');
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionSingleCertificate($id){
        $participant = Participant::findOne($id);
        $test = Test::findOne($participant->test_id);
        $percentage = Settings::find()->one();

        if ($participant->result >= $percentage->first) {
            $this->certificate($participant, $test, 'first');
        }
        else if ($participant->result < $percentage->first && $participant->result >= $percentage->second) {
            $this->certificate($participant, $test, 'second');
        }
        else if ($participant->result < $percentage->second && $participant->result >= $percentage->third) {
            $this->certificate($participant, $test, 'third');
        }
        else if ($participant->result < $percentage->third && $participant->result >= $percentage->fourth) {
            $this->certificate($participant, $test, 'fourth');
        }
        else if ($participant->result < $percentage->fourth && $participant->result >= $percentage->fifth) {
            $this->certificate($participant, $test, 'fifth');
        }

        return $this->redirect(['test/view', 'id' => $participant->test_id]);
    }

    public function actionJournal($id)
    {
        $participants = Participant::find()->andWhere(['test_id' => $id])->all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header row
        $sheet->setCellValue('A1', 'Есімі')
            ->setCellValue('B1', '1 орын сериясы')
            ->setCellValue('C1', '2 орын сериясы')
            ->setCellValue('D1', '3 орын сериясы')
            ->setCellValue('E1', 'Алғыс хат сериясы')
            ->setCellValue('F1', 'Серитификаттың сериясы');

        $row = 2;
        foreach ($participants as $participant) {
            $participantName = $participant->name ?? '---';
            $place = Settings::find()->one();

            $sheet->setCellValue("A{$row}", $participantName);

            $serial = $participant ? str_pad($participant->id, 5, '0', STR_PAD_LEFT) : '';

            $first = $participant->result >= $place->first;
            $second = $participant->result >= $place->second && $participant->result < $place->first;
            $third = $participant->result >= $place->third && $participant->result < $place->second;
            $fourth = $participant->result >= $place->fourth && $participant->result < $place->third;
            $fifth = $participant->result >= $place->fifth && $participant->result < $place->fourth;

            $sheet->setCellValue("B{$row}",  $first ? $serial : '');
            $sheet->setCellValue("C{$row}", $second ? $serial : '');
            $sheet->setCellValue("D{$row}", $third ? $serial : '');
            $sheet->setCellValue("E{$row}", $fourth ? $serial : '');
            $sheet->setCellValue("F{$row}", $fifth ? $serial : '');

            $row++;
        }

        $filePath = 'uploads/'
            . Yii::$app->security->generateRandomString(8)
            . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $test = Test::findOne($id);
        $filename = $test->subject->title_kz . ' ' . $test->language . ' ' . $test->version . ' журнал.xlsx';

        return Yii::$app->response->sendFile($filePath, $filename);
    }

    public function actionReceipts($id, $mode){
        if($mode == 'receipts'){
            $mode = 'participants';
        }else{
            $mode = 'receipts';
        }
        return $this->redirect(['test/view', 'id' => $id, 'mode' => $mode]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save(false)) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Test::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
