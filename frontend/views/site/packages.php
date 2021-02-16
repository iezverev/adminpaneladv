<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>Размер</th>
        <th>Цена</th>
        <th>Оплата</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($packages as $package) {

        echo '  <tr>
                <td>'.$package->id.'</td>
                <td>'.$package->size.'</td>
                <td>'.$package->price.'</td>
                <td>'.$package->salary.'</td>
                <td><a href="addresses?package_id='.$package->id.'"><button type="button" class="btn btn-info btn-sm">К адресам</button></a>';
        if (Yii::$app->user->identity->role_id == 1)
        {  echo '<a href="packages?product_id='.$product_id.'&idedit='.$package->id.'"><button type="button" class="btn btn-info btn-sm" style="margin-left: 10px;">Редактировать</button></a>
                 <a href="removepackage?product_id='.$product_id.'&idremove='.$package->id.'"><button type="button" class="btn btn-danger btn-sm" style="margin-left: 10px;">Удалить</button></a>';}
        echo '</td>
            </tr>';

    }  ?>
    </tbody>
</table>

<?php if (Yii::$app->user->identity->role_id == 1) {
    echo '<div class="row">
            <div class="col-lg-5">'; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'size')->textInput(['type' => 'number'])->label('Размер') ?>
    <?= $form->field($model, 'price')->textInput(['type' => 'number'])->label('Цена') ?>
    <?= $form->field($model, 'salary')->textInput(['type' => 'number'])->label('Оплата') ?>
    <?= $form->field($model, 'product_id')->textInput(['style' => 'display:none', 'value' => $product_id])->label('') ?>




    <?php echo '<div class="form-group">'; ?>
    <?= Html::submitButton($buttonname.' упаковку', ['class' => 'btn btn-primary']) ?>
    <?php if ($buttonname == 'Редактировать') {
        echo '<a href="packages?product_id='.$product_id.'"><button type="button" class="btn btn-danger">Отмена</button></a>';
    }?>
    <?php echo '</div>'; ?>

    <?php ActiveForm::end(); ?>
    <?php echo '</div>'; ?>
    <?php echo '</div>';
}
?>


