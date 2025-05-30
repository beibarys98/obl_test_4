<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var LoginForm $model */

use common\models\LoginForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = Yii::$app->name;
?>
<div class="site-login">

    <div style="margin: 0 auto; width: 500px;">

        <?= Html::img('@web/images/adort2.png', [
            'alt' => 'logo',
            'class' => 'mb-3',
            'style' => 'width: 50%; display: block; margin: 0 auto;'
        ]) ?>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username')->textInput([
            'autofocus' => true,
            'placeholder' => Yii::t('app', 'ЖСН'),
            'id' => 'username-input'
        ])->label(false) ?>

        <div id="password-field" style="display: none;">
            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => Yii::t('app', 'Құпия сөз'),
            ])->label(false) ?>
        </div>

        <div class="form-group text-center mt-3">
            <?= Html::submitButton(Yii::t('app', 'Кіру'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <div class="text-end mt-2">
            <?= Html::a(Yii::t('app', 'Тіркелу'), ['site/signup'], ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$js = <<<JS
document.getElementById('username-input').addEventListener('input', function() {
    const passwordField = document.getElementById('password-field');
    if (this.value.trim().toLowerCase() === 'admin') {
        passwordField.style.display = 'block';
    } else {
        passwordField.style.display = 'none';
    }
});
JS;

$this->registerJs($js);
?>
