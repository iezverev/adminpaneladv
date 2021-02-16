<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>Название</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($regions as $region) {

        echo '  <tr>
                <td>'.$region->id.'</td>
                <td>'.$region->name.'</td>
                <td>';
        if (Yii::$app->user->identity->role_id == 1)
        {  echo '<a href="regions?city_id='.$city_id.'&idedit='.$region->id.'"><button type="button" class="btn btn-info btn-sm" style="margin-left: 10px;">Редактировать</button></a>
                 <a href="removeregion?city_id='.$city_id.'&idremove='.$region->id.'"><button type="button" class="btn btn-danger btn-sm" style="margin-left: 10px;">Удалить</button></a>';}
        echo '</td>
            </tr>';

    }  ?>
    </tbody>
</table>

<?php
    echo '<div class="row">
            <div class="col-lg-5">'; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput()->label('Название района') ?>
    <?= $form->field($model, 'city_id')->textInput(['style' => 'display:none', 'value' => $city_id])->label('') ?>



    <?php echo '<div class="form-group">'; ?>
    <?= Html::submitButton($buttonname.' район', ['class' => 'btn btn-primary']) ?>
    <?php if ($buttonname == 'Редактировать') {
        echo '<a href="regions?city_id='.$city_id.'"><button type="button" class="btn btn-danger">Отмена</button></a>';
    }?>
    <?php echo '</div>'; ?>

    <?php ActiveForm::end(); ?>
    <?php echo '</div>'; ?>
    <?php echo '</div>';

?>


