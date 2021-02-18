<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<?php
    echo '<div class="row">
            <div class="col-lg-5">'; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bot_token')->textInput()->label('Токен бота') ?>
    <?= $form->field($model, 'xmr_address')->textInput()->label('Главный XMR адрес') ?>



    <?php echo '<div class="form-group">'; ?>
    <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
    <?php echo '</div>'; ?>

    <?php ActiveForm::end(); ?>
    <?php echo '</div>'; ?>
    <?php echo '</div>';

?>


