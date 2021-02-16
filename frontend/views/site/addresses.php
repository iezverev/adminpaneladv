<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>Описание</th>
        <th>Картинка</th>
        <th>Статус</th>
        <th>Район</th>
        <th>Нога</th>

    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($addresses as $address) {

        echo '  <tr>
                <td>'.$address->id.'</td>
                <td>'.$address->desc.'</td>
                <td><img width="100px" height="100px" src="../web/'.$address->imgs->img.'"></td>
                <td>'.$address->status.'</td>
                <td>'.$address->region->name.'</td>
                <td>'.$address->leg->username.'</td>
                <td><!--<a href="addresspage?address_id='.$address->id.'"><button type="button" class="btn btn-info btn-sm">К адресу</button></a>-->';
        if (Yii::$app->user->identity->role_id == 1)
        {  echo '<a href="addresses?package_id='.$package_id.'&idedit='.$address->id.'"><button type="button" class="btn btn-info btn-sm" style="margin-left: 10px;">Редактировать</button></a>
                 <a href="removeaddress?product_id='.$package_id.'&idremove='.$address->id.'"><button type="button" class="btn btn-danger btn-sm" style="margin-left: 10px;">Удалить</button></a>';}
        echo '</td>
            </tr>';

    }  ?>
    </tbody>
</table>

<?php
    echo '<div class="row">
            <div class="col-lg-5">'; ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'status')->textInput(['style' => 'display:none', 'value' => 'Доступен'])->label('') ?>
<?= $form->field($model, 'package_id')->textInput(['style' => 'display:none', 'value' => $package_id])->label('') ?>
<?= $form->field($model, 'leg_id')->textInput(['style' => 'display:none', 'value' => Yii::$app->user->identity->id])->label('') ?>

<?= $form->field($model, 'region_id')->dropDownList($items_region)->label('Район') ?>
<?= $form->field($model, 'desc')->textarea(['rows' => '6'])->label('Описание') ?>
<?= $form->field($picturemodel, 'img[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Картинки') ?>





<?php echo '<div class="form-group">'; ?>
    <?= Html::submitButton($buttonname.' упаковку', ['class' => 'btn btn-primary']) ?>
    <?php if ($buttonname == 'Редактировать') {
        echo '<a href="addresses?package_id='.$package_id.'"><button type="button" class="btn btn-danger">Отмена</button></a>';
    }?>
    <?php echo '</div>'; ?>

    <?php ActiveForm::end(); ?>
    <?php echo '</div>'; ?>
    <?php echo '</div>';

?>


