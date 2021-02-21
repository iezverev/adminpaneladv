<?php
$this->registerCssFile("@web/css/preloader.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);

use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$cities = ArrayHelper::map($leg_info,'city_id','city.name');

?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<div id="app">
    <?= Html::dropDownList('Cities', null ,$cities, ['v-model' => 'city', 'class'=> 'form-control mb-1', 'v-on:change' => 'func', 'options' => [array_keys($cities)[0] => ['Selected' => true]]]) ?>
    <input id="date" type="date" class="form-control mb-2" v-model="datep" v-on:change="func">
    <div :class="state">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>id</th>
                <th>Город</th>
                <th>Название</th>
                <th>Картинки</th>
                <th>Цена</th>
                <th>Клиент</th>
                <th>Время</th>
                <th>Статус</th>
                <th>Нога</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="data in datas">

                <tr v-for="r_id in data['regionlist']" v-if="r_id == data['region_id']">
                    <td>{{data['id']}}</td>
                    <td>{{data['name']}}</td>
                    <td>{{data['namei']}}</td>
                    <td><a :href="'images?address_id='+data['id']"><button type="button" class="btn btn-info btn-sm">К картинкам</button></a></td>
                    <td>{{data['price']}}</td>
                    <td>{{data['client_name']}}</td>
                    <td>{{data['time']}}</td>
                    <td>{{data['status']}}</td>
                    <td>{{data['username']}}</td>

                </tr>
            </template>
            </tbody>
        </table>
        <h2 class="text-center">{{empty}}</h2>
    </div>
    <div :class="'gooey '+prel">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                empty: '',
                datep: '',
                datas: [],
                timer: '',
                state: 'hidden',
                prel: '',
                city: '<?= array_keys($cities)[0]?>'
            };
        },
        created: function() {
            const o_date = new Intl.DateTimeFormat;
            const f_date = (m_ca, m_it) => Object({...m_ca, [m_it.type]: m_it.value});
            const m_date = o_date.formatToParts().reduce(f_date, {});
            this.datep = m_date.year + '-' + m_date.month + '-' + m_date.day;
            this.getData();
            this.timer = setInterval(this.getData, 10000);
        },
        methods: {
            getData: function() {
                axios
                    .get('/site/salesapi?date=' + this.datep+'&leg_id='+<?=$leg_id ?>+'&city_id='+this.city)
                    .then((response) => {
                        this.datas = response.data
                        if (this.datas.length == 0) {
                            this.empty = 'За выбранную дату продаж нет';
                        } else {
                            this.empty = '';
                        }
                        this.prel = 'hidden';
                        this.state = '';
                    });
            },
            func: function() {
                this.state = 'hidden';
                this.prel = '';
                this.getData();
            }
        }
    });
</script>
