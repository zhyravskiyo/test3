<template>
    <div class="container">
        <div class="row">
            <a class="col-lg-1" @click="setPage(n)" v-for="n in pageCount">
                {{ n }}
            </a>
        </div>
        <form class="row">
            <select class="col-lg-1" v-model="sortCondidon">
                <option value="<">Ascending</option>
                <option value=">">Descending</option>
            </select>
            <select class="col-lg-1" v-model="countOnPage">
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="10">10</option>
            </select>
            <select class="col-lg-1" v-model="sortFiled">
                <option value="id">ID</option>
                <option value="username">User Name</option>
                <option value="email">Email</option>
                <option value="status">Status</option>
            </select>
        </form>
        <div id="tasks list-group">
            <div class="row list-group-item" v-for="task in tasks">
                <div class="col-lg-1">
                    <span>id</span><br>
                    <span>{{task.id}}</span>
                </div>
                <div class="col-lg-2">
                    <span>username</span><br>
                    <span>{{task.username}}</span>
                </div>
                <div class="col-lg-2">
                    <span>email</span><br>
                    <span>{{task.email}}</span>
                </div>
                <div class="col-lg-2">
                    <span>create time</span><br>
                    <span>{{task.createdAt}}</span>
                </div>
                <div class="col-lg-2">
                    <span>update time</span><br>
                    <span>{{task.updatedAt}}</span>
                </div>

                <div class="col-lg-1">
                    <span>status</span><br>
                    <template v-if="task.status == 0">
                        <span>No Completed</span>
                    </template>
                    <template v-else>
                        <span>Completed</span>
                    </template>

                    <input type="checkbox" v-model="task.status"/>
                </div>
                <div class="col-lg-12">
                    <span class="row">body</span><br>
                    <textarea class="col-lg-9" v-model="task.body"></textarea>
                    <div class="col-lg-2">
                        <span v-html="task.image"></span>
                    </div>
                </div>
                <button class="btn btn-info btn-lg" type="button" @click="save(task)">save {{task.id}}</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                tasks: [],
                page: 1,
                countOnPage: 3,
                sortFiled: "id",
                sortCondidon: "<",
                pageCount: 1,
            };
        },
        mounted() {
            this.prepareComponent();
        },

        ready() {
            this.prepareComponent();
        },

        methods: {
            prepareComponent() {
                this.getTasks();
            },

            getTasks() {
                axios.get('/task/' + this.page + '/' + this.countOnPage + '/' + this.sortFiled + '/' + this.sortCondidon + '/')
                    .then(response => {
                        this.tasks = response.data;
                    });
                this.getCount();
            },

            getCount() {
                axios.get('/task/count/')
                    .then(response => {
                        this.pageCount = Math.ceil(response.data[0] / this.countOnPage);
                    });
            },

            save(task) {
                const data = new FormData();
                data.append('body', task.body);
                data.append('status',task.status);
                axios.post('/task/' + task.id + "/", data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then(response => {
                        this.getTasks();
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
            },

            setPage(n) {
                this.page = n;
                this.getTasks();
            },
        }
    }
</script>
