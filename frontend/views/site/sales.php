<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.js"></script>



<div id="app">
    <input id="date" type="date" class="form-control" value="02-16-2012" v-model="datep" v-on:change="getData">
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
            <tr v-for="data in datas">
                <td>{{data['id']}}</td>
                <td>{{data['desc']}}</td>
                <td><a :href="'images?address_id='+data['id']"><button type="button" class="btn btn-info btn-sm">К картинкам</button></a></td>
                <td>{{data['status']}}</td>
                <td>{{data['name']}}</td>
                <td>{{data['username']}}</td>

            </tr>
        </tbody>
    </table>
    <h2>{{empty}}</h2>
</div>
<script>
    new Vue({
        el: '#app',
        data() {
            return {
                empty: '',
                datep: '',
                datas: [],
                timer: ''
            };
        },
        created: function() {
            this.getData();
            this.timer = setInterval(this.getData, 10000);
        },
        methods: {
            getData: function() {
                if (this.datep !== '') {
                    this.empty = '';
                    axios
                        .get('/site/salesapi?date=' + this.datep)
                        .then(response => (this.datas = response.data));
                }
                if (this.datas.length == 0) {
                    this.empty = 'За выбранную дату продаж нет';
                } else {
                    this.empty = '';
                }

            },
            func: function() {
                console.log(this.datep);
            }
        }
    });
</script>