<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>Город</th>
        <th>Товар</th>
        <th>Картинки</th>
        <th>Цена</th>
        <th>Клиент</th>
        <th>Время</th>
        <th>Статус</th>
        <th>Нога</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($reservation as $reserv) {

        echo '  <tr>
                <td>'.$reserv->id.'</td>
                <td>'.$reserv->region->city->name.'</td>
                <td>'.$reserv->package->product->name.'</td>
                <td><a href="images?address_id='.$reserv->id.'"><button type="button" class="btn btn-info btn-sm">К картинкам</button></a></td>
                <td>'.$reserv->package->price.'</td>
                <td>'.$reserv->client_name.'</td>
                <td>'.$reserv->time.'</td>
                <td>'.$reserv->status.'</td>
                <td>'.$reserv->leg->username.'</td>
                <td>';
        if (Yii::$app->user->identity->role_id == 1)
        {  echo '<a href="reservation?idedit='.$reserv->id.'"><button type="button" class="btn btn-danger btn-sm" style="margin-left: 10px;">Отменить</button></a>';} echo '</td>
            </tr>';

    }  ?>
    </tbody>
</table>



