<template>
    <div class="card">
        <div class="card-header">
            <h1 class="page-header">
                {{ student.firstname }} {{ student.lastname }}
            </h1>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#student" role="tab" data-toggle="tab">Estudiante</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#course" role="tab" data-toggle="tab">Cursos Suscritos</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="student">
                    <div class="table-reponsive mt-3">
                        <table class="vertical-table">
                            <tr>
                                <th scope="row">Nombre:</th>
                                <td> {{ student.firstname }} {{ student.lastname }}</td>
                            </tr>
                            <tr>
                                <th scope="row"> Email: </th>
                                <td>{{ student.email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Birthdate </th>
                                <td>{{ student.birthdate }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Registrado: </th>
                                <td>{{ student.created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="course">
                    <div class="table-reponsive mt-3">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Horario</th>
                                <th scope="col">Fecha de Inicio</th>
                                <th scope="col">Fecha de Cierre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(course, i) in student.courses" :key="course.id">
                                    <td>{{ i + 1 }}</td>
                                    <td>{{ course.name }}</td>
                                    <td>{{ course.schedule}}</td>
                                    <td>{{ course.start_date }}</td>
                                    <td>{{ course.end_date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['alert', 'studentid'],
        created () {
            this.student = this.getStudent();
        },
        data () {
            return {
                student: {
                    firstname: '',
                    lastname: '',
                    email: '',
                    birthdate: '',
                    created_at: '',
                    courses: {},
                }
            }
        },
        methods: {
            getStudent () {
                const url = `/students/${this.studentid}`;
                axios.get(url)
                .then(response => {
                    this.student = response.data;
                })
                .catch(err => {
                    this.alert('Ocurrio un error al conseguir los datos.', 'error');
                    console.log(err);
                });
            },
        }
    }
</script>