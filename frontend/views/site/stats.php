<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Статистика';
?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<div class="cont">
    <div class="block">
        <div class="headb"><b>Продано за текущий день</b></div>
        <ul>
            <li><b>Товаров:</b> <?= $res['today']['count'] ?></li>
            <li><b>На сумму:</b> <?= $res['today']['price'] ?> р.</li>
        </ul>
    </div>
    <div class="block">
        <div class="headb"><b>Продано за 7 дней</b></div>
        <ul>
            <li><b>Товаров:</b> <?= $res['seven']['count'] ?></li>
            <li><b>На сумму:</b> <?= $res['seven']['price'] ?> р.</li>
        </ul>
    </div>
    <div class="block">
        <div class="headb"><b>Продано за месяц</b></div>
        <ul>
            <li><b>Товаров:</b> <?= $res['month']['count'] ?></li>
            <li><b>На сумму:</b> <?= $res['month']['price'] ?> р.</li>
        </ul>
    </div>
</div>
<?php if (Yii::$app->user->identity->role_id == 1): ?>
<div id="app">
    <div class="block bxmr">
        <div class="headb"><b>Курс XMR</b></div>
        <ul>
            <li>1 XMR = <b>{{data['RUB']}} руб.</b></li>
            <li>С учетом коррекции: <b>{{cdata.toFixed(2)}} руб.</b></li>
        </ul>
    </div>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($adj, 'adjustment')->textInput(['type' => 'number'])->label('Корректировка в процентах') ?>


                <!--                    --><?//= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>

                <?php ActiveForm::end(); ?>
                <div class="form-group">
                    <button class="btn btn-primary" v-on:click="adj">Редактировать</button>
                </div>
            </div>
        </div>
</div>
<?php endif; ?>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                data: null,
                cdata: 0,
            };
        },
        created: function() {
            this.getData();
            this.timer = setInterval(this.getData, 10000);
        },
        methods: {
            getData: function() {
                axios
                    .get('https://min-api.cryptocompare.com/data/price?fsym=XMR&tsyms=RUB')
                    .then((response) => {
                        this.data = response.data;
                        axios
                            .get('getadj')
                            .then((response) => {
                                this.cdata = this.data['RUB'] + (this.data['RUB'] * response.data / 100);
                            });
                    });

            },
            adj: function (event) {
                var form = w0;
                var data = new FormData(form);
                var json = '';
                var end = '&';
                // _csrf-frontend=pkevkDTEOkchbGhJJdx_RAZKoF84hzQmlF7QeDDJW6bgCfX3TrdTClc_EChI6AkDZRn_FFPtTnHiLuQec7oK7A%3D%3D&Adjustment%5Badjustment%5D=5
                // _csrf-frontend=Y6KE6nf73p9zhzpJi_xkf-Mziv1F_omJQIaJ8ObJKLkl7N6NDYi30gXUQijmyBI4gGDVti6U89429r2Wpbp58w%3D%3D&Adjustment%5Badjustment%5D=7
                // _csrf-frontend=wNgJhSsdLeTLnyd3itpe0GixO4uENPaciUwNetkUtw2GllPiUW5Eqb3MXxbn7iiXC-JkwO9ejMv_PDkcmmfmRw%3D%3D%26Adjustment%5Badjustment%5D=5
                // _csrf-frontend=nYmD83E497GpEnt_3rBT3ndnJUys_99EPpIeRFFhULvbx9mUC0ue_N9BAx6zhCWZFDR6B8eVpRNI4ioiEhIB8Q%3D%3D%2CAdjustment%5Badjustment%5D=5
                // _csrf-frontend=6y2Tw6uHcASrDRWACP1qu3qRl3zPTFG2Cv40HQNTuzKtY8mk0fQZSd1ebeFlyRz8GcLIN6QmK-F8jgB7QCDqeA%3D%3D,Adjustment%5Badjustment%5D=5
                // _csrf-frontend%3DImtuzxQA2L6IVAMQyyXYm4uuLlA1t-JYchCvXe7c5HhkJTSobnOx8_4He3GmEa7c6P1xG17dmA8EYJs7ra-1Mg%3D%3D%2CAdjustment%5Badjustment%5D%3D5
                // _csrf-frontend=y0X_AV12h1CtVsKCyF1i6dq0HrbSyGzA5IeAB-qdMf-NC6VmJwXuHdsFuuOlaRSuuedB_bmiFpeS97Rhqe5gtQ==,Adjustment[adjustment]=5
                // {_csrf-frontend=Sq3zWNKkhoENsia2du-UH06h4jEH8pxO-HUsbxT0I90M46k_qNfvzHvhXtcb2-JYLfK9emyY5hmOBRgJV4dylw==,Adjustment[adjustment]=5}
                for (var [key, value] of data.entries()) {
                    json += encodeURIComponent(key)+'='+encodeURIComponent(value)+end;
                    end = '';
                }
                axios
                    .post('stats', json)
                    .then(this.getData());
            }

        }
    });
</script>
