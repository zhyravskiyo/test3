<template>
    <div class="container">
        <div class="modal fade" id="login-form" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form class="modal-content" action="/login/" method="post">
                    <div class="form form-group">
                        <label for="login">Login:</label><br>
                        <input type="text" name="login" id="login">
                    </div>
                    <div class="form form-group">
                        <label for="password">Password:</label><br>
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- modal preview new task -->

        <div id="new-task-preview" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Task</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" v-for="task in tasks">
                            <div class="col-lg-1">
                                <span>id</span><br>
                                <span>0</span>
                            </div>
                            <div class="col-lg-2">
                                <span>username</span><br>
                                <span>{{newTask.username}}</span>
                            </div>
                            <div class="col-lg-2">
                                <span>email</span><br>
                                <span>{{newTask.email}}</span>
                            </div>
                            <div class="col-lg-2">
                                <span class="col-lg-12">create time</span><br>
                                <span class="col-lg-12">{{getTime()}}</span>
                            </div>
                            <div class="col-lg-2">
                                <span class="col-lg-12">update time</span><br>
                                <span class="col-lg-12">{{getTime()}}</span>
                            </div>
                            <div class="col-lg-2">
                                <img src="{ newTask:image }"/>
                            </div>
                            <div class="col-lg-1">
                                <span>status:</span><br>
                                <span>not completed</span>
                            </div>
                            <div class="col-lg-12">
                                <span class="row">body</span>
                                <span class="row">{{newTask.body}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>


        <div class="row">
            <!-- pagination block -->
            <div class="col-lg-5 pagination">
                <a class="col-lg-1" @click="setPage(n)" v-for="n in pageCount">
                    {{ n }}
                </a>
            </div>
            <!-- form for pagination conditions -->

            <form class="col-lg-5">
                <select class="col-lg-3" v-model="sortCondidon">
                    <option value="<">Ascending</option>
                    <option value=">">Descending</option>
                </select>
                <select class="col-lg-3" v-model="countOnPage">
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                </select>
                <select class="col-lg-3" v-model="sortFiled">
                    <option value="id">ID</option>
                    <option value="username">User Name</option>
                    <option value="email">Email</option>
                    <option value="status">Status</option>
                </select>
                <button type="button" class="btn btn-success btn-lg" @click="this.getTasks">Reload</button>
            </form>
            <!-- login block -->

            <div class="col-lg-1">
                <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#login-form">
                    Login
                </button>
            </div>
        </div>

        <!-- form for new task -->

        <form class="row" id="new-task-form" name="new-task-form">
            <div class="col-lg-3">
                <label for="new-task-username">username</label>
                <input class="form-control" v-model="newTask.username" id="new-task-username">
            </div>
            <div class="col-lg-3">
                <label for="new-task-email">email</label>
                <input class="form-control" v-model="newTask.email" type="email" id="new-task-email">
            </div>
            <div class="col-lg-3">
                <label for="new-task-img">img</label>
                <input class="form-control" v-on="this.newTask.img" type="file" id="new-task-img" name="new-task-img">
            </div>
            <div class="form-group">
                <label class="col-lg-12" for="new-task-body">Task Text</label>
                <textarea class="col-lg-12" v-model="newTask.body" id="new-task-body">Insert your task here</textarea>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-lg" @click="this.save">save</button>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#new-task-preview">
                    Preview
                </button>
            </div>
        </form>

        <!-- list of tasks -->

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
                <div class="col-lg-2">
                    <span v-html="task.image"></span>
                </div>
                <div class="col-lg-1">
                    <span>status</span><br>
                    <template v-if="task.status === 0">
                        <span>No Completed</span>
                    </template>
                    <template v-else>
                        <span>Completed</span>
                    </template>
                </div>
                <div class="col-lg-12">
                    <span class="row">body</span><br>
                    <span class="row">{{task.body}}</span>
                </div>
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
                newTask: {
                    username: "",
                    email: "",
                    body: "",
                    img: ""
                }
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

            save() {
                var s = this;
                const data = new FormData(document.getElementById('new-task-form'));
                var imagefile = document.querySelector('#new-task-img');
                console.log(imagefile.files[0]);
                data.append('image', imagefile.files[0]);
                data.append('username', s.newTask.username);
                data.append('email', s.newTask.email);
                data.append('body', s.newTask.body);
                axios.post('/task/', data, {
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
            getTime() {
                var date = new Date();

                return date.getFullYear()
                    + "-"
                    + (date.getMonth() + 1)
                    + "-"
                    + date.getDay()
                    + " "
                    + date.getHours()
                    + ":"
                    + date.getMinutes()
                    + ":"
                    + date.getSeconds();
            }
        }
    }
</script>
