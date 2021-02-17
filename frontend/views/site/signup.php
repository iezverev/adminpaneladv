<div class="container">
<?php

/*var $this yii\web\View
var $form yii\bootstrap\ActiveForm
var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;


$q = $cities->find()->all();
$items = ArrayHelper::map($q,'id','name');

$this->title = 'Регистрация';
?>
<div class="site-contact" style="text-align: left">
    <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-5">

               <?php $form = ActiveForm::begin(); ?>

                      <?= $form->field($model, 'username')->textInput()->label('Логин') ?>

                      <?=  $form->field($model, 'password')->passwordInput(['class'=>'textPassReg form-control'])->label('Пароль')  ?>

<!--                      --><?//= $form->field($ctu, 'city_id')->dropDownList($items)->label('Город') ?>
                      <?= $form->field($ctu, 'city_id')->checkboxList($items)->label('Город') ?>


                <div class="form-group">
                        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

</div>
</div>
