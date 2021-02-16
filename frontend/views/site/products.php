<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>Название</th>
        <th>Кол-во</th>
        <th>Город</th>
        <th>Ед. измерения</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($products as $product) {

        echo '  <tr>
                <td>'.$product->id.'</td>
                <td>'.$product->name.'</td>
                <td>посчитать кол-во</td>
                <td>'.$product->city->name.'</td>
                <td>'.$product->ed->type.'</td>
                <td><a href="packages?product_id='.$product->id.'"><button type="button" class="btn btn-info btn-sm">К упаковкам</button></a>';
        if (Yii::$app->user->identity->role_id == 1)
        {  echo '<a href="products?idedit='.$product->id.'"><button type="button" class="btn btn-info btn-sm" style="margin-left: 10px;">Редактировать</button></a>
                 <a href="removeproducts?idremove='.$product->id.'"><button type="button" class="btn btn-danger btn-sm" style="margin-left: 10px;">Удалить</button></a>';}
        echo '</td>
            </tr>';

    }  ?>
    </tbody>
</table>

<?php if (Yii::$app->user->identity->role_id == 1) {
    echo '<div class="row">
            <div class="col-lg-5">'; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput()->label('Название товара') ?>
    <?= $form->field($model, 'city_id')->dropDownList($items_city)->label('Город') ?>
    <?= $form->field($model, 'ed_id')->dropDownList($items_ed)->label('Ед. измерения') ?>


    <?php echo '<div class="form-group">'; ?>
    <?= Html::submitButton($buttonname.' товар', ['class' => 'btn btn-primary']) ?>
    <?php if ($buttonname == 'Редактировать') {
        echo '<a href="cities"><button type="button" class="btn btn-danger">Отмена</button></a>';
    }?>
    <?php echo '</div>'; ?>

    <?php ActiveForm::end(); ?>
    <?php echo '</div>'; ?>
    <?php echo '</div>';
}
?>


