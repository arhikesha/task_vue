<template>
    <div class="panel-body">
        <h1 align="center">Выполнение заданий </h1>

        <form @submit.prevent="addArticle" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="task.title">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="date" v-model="task.date">
            </div>
            <div class="form-group">
            <textarea class="form-control" placeholder="Desc" v-model="task.desc"></textarea>
        </div>

            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        {{ user }}
        <div class="card card-body mb-2" v-for="task in tasks" v-bind:key="task.id">
            <h3>{{task.title}}</h3>
            <p>{{task.desc}}</p>
            <h5>{{task.date}}</h5>
            <hr>
            <button @click="editTask(task)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteTask(task.id)" class="btn btn-danger">Delete</button>
        </div>
    </div>

</template>

<script>

     export default {
        data() {
            return {
              tasks:[],
                task:{
                  id:'',
                  title:'',
                   desc:'',
                   date:'',
                },
                task_id: '',
                edit: false,
                user:''
            };
        },
        created(){
            this.fetchTasks();
        },

        methods:{
            fetchTasks(){
              fetch('api/task').then((response)=> {
                  response.json().then((data)=> {
                      this.tasks = data;
                  });
              });
            },
            addArticle() {
                /////add
                if (this.edit === false) {
                    fetch('api/task', {
                        method: 'post',
                        body: JSON.stringify(this.task),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })

                        .then((response)=> {
                        response.json()
                        .then((data) => {
                  if(data.error){
                            alert(data.error);
                }else
                {

                    this.task.title = data.title;
                    this.task.desc = data.desc;
                    this.task.time = data.date;
                    this.fetchTasks();
                }

            }).catch(err => console.log(err))
               })
            }else{
                    //update
                    fetch('api/task', {
                        method: 'put',
                        body: JSON.stringify(this.task),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })

                        .then((response)=> {
                        response.json()
                        .then((data) => {
                        if(data.error){
                        alert(data.error);
                    }else
                    {
                        this.task.title = data.title;
                        this.task.desc = data.desc;
                        this.task.time = data.date;
                        this.fetchTasks();
                    }

                }).catch(err => console.log(err))
                })
                }
            },
            editTask(task) {
                this.edit = true;
                this.task.id = task.id;
                this.task.desc = task.desc;
                this.task.title = task.title;
                this.task.date = task.date;
            },
            deleteTask(id){
                if (confirm('Вы уверены?')) {
                fetch(`api/task/${id}`, {
                    method: 'delete'
                }) .then((response)=> {
                    response.json()
                    .then((data) => {
                    alert('Задача Удалена');
                     this.fetchTasks();
            })
            .catch(err => console.log(err))
                });
                }
            },

        }
    };


</script>

<style scoped>

</style>