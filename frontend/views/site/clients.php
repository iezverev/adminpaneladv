<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<table class="table table-hover">
    <thead>
    <tr>
        <th>id</th>
        <th>username</th>
        <th>password</th>
        <th>XMR адрес</th>
        <th>Баланс в боте</th>
        <th>Реальный баланс</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($clients as $client) {

        echo '  <tr>
                <td>'.$client->id.'</td>
                <td>'.$client->username.'</td>
                <td>'.$client->password.'</td>
                <td>'.$client->xmr_address.'</td>
                <td>'.$client->balance.'</td>
                <td>'.$client->real_balance.'</td>
                <td>';
        if (Yii::$app->user->identity->role_id == 1)
        {  echo '<a href="removeclients?id='.$client->id.'"><button type="button" class="btn btn-danger btn-sm" style="margin-left: 10px;">Удалить</button></a>';} echo '</td>
            </tr>';

    }  ?>
    </tbody>
</table>



