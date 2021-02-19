<?php
$this->registerCssFile("@web/css/preloader.css", [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);


?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<div id="app">

    <input id="date" type="date" class="form-control mb-2" v-model="datep" v-on:change="func">
    <div :class="state">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>id</th>
                <th>Город</th>
                <th>Название</th>
                <th>Картинки</th>
                <th>Статус</th>
                <th>Нога</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="data in datas">
                <td>{{data['id']}}</td>
                <td>{{data['name']}}</td>
                <td>{{data['namei']}}</td>
                <td><a :href="'images?address_id='+data['id']"><button type="button" class="btn btn-info btn-sm">К картинкам</button></a></td>
                <td>{{data['status']}}</td>
                <td>{{data['username']}}</td>

            </tr>
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
                prel: ''
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
                    .get('/site/salesapi?date=' + this.datep)
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
