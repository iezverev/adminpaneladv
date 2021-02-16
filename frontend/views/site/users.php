<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>Логин</th>
        <th>Пароль</th>
        <th>Роль</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $user) {

        echo '  <tr>
                <td>'.$user->id.'</td>
                <td>'.$user->username.'</td>
                <td>'.$user->password.'</td>
                <td>'.$user->role->name.'</td>';
        /*if (Yii::$app->user->identity->role_id == 1)
        {  echo '<a href="cities?idedit='.$city->id.'"><button type="button" class="btn btn-info btn-sm" style="margin-left: 10px;">Редактировать</button></a>
                 <a href="removecities?id='.$city->id.'"><button type="button" class="btn btn-danger btn-sm" style="margin-left: 10px;">Удалить</button></a>';}
        */echo '
            </tr>';

    }  ?>
    </tbody>
</table>

<?php
/*    echo '<div class="row">
            <div class="col-lg-5">'; */?><!--

    <?php /*$form = ActiveForm::begin(); */?>

    <?/*= $form->field($model, 'name')->textInput()->label('Название города') */?>



    <?php /*echo '<div class="form-group">'; */?>
    <?/*= Html::submitButton($buttonname.' город', ['class' => 'btn btn-primary']) */?>
    <?php /*if ($buttonname == 'Редактировать') {
        echo '<a href="cities"><button type="button" class="btn btn-danger">Отмена</button></a>';
    }*/?>
    <?php /*echo '</div>'; */?>

    <?php /*ActiveForm::end(); */?>
    <?php /*echo '</div>'; */?>
    --><?php /*echo '</div>';

*/?>


