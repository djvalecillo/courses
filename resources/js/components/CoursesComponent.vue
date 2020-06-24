<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h1 class="page-header">
                    Listado de Cursos
                    <button type="button" class="btn btn-primary float-right" v-on:click.prevent="showModal(false)">+ Nuevo</button>
                </h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Estudiantes</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Inicio</th>
                        <th scope="col">Fin</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(course, i) in courses" :key="course.id">
                            <td>{{ i + 1 }}</td>
                            <td>{{ course.name }}</td>
                            <td><span class="badge badge-secondary">{{ course.students_count || 0 }}</span></td>
                            <td>{{ course.schedule }}</td>
                            <td>{{ course.start_date }}</td>
                            <td>{{ course.end_date }}</td>
                            <td width="15%">
                                <a href="#" v-on:click.prevent="showModal(true, course)" class="btn btn-info btn-sm">Editar</a>
                                <a href="#" v-on:click.prevent="deleteCourse(course, i)" class="btn btn-danger btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalCourse" tabindex="-1" role="dialog" aria-labelledby="CreateCourseModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Curso</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form v-on:submit.prevent="update(course)" v-if="editMode">
                        <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Nombre</label>
                                        <input type="text" v-model="course.name" class="form-control" id="name" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="schedule">Horario</label>
                                        <input type="time" v-model="course.schedule" class="form-control" id="schedule">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="start_date">Fecha de Inicio</label>
                                        <input type="date" v-model="course.start_date" class="form-control" id="start_date" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="end_date">Fecha de Cierre</label>
                                        <input type="date" v-model="course.end_date" class="form-control" id="end_date" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" v-on:click.prevent="btnCancel">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                    <form v-on:submit.prevent="create" v-else>
                        <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Nombre</label>
                                        <input type="text" v-model="course.name" class="form-control" id="name" placeholder="Nombre" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="schedule">Horario</label>
                                        <input type="time" v-model="course.schedule" class="form-control" id="schedule">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="start_date">Fecha de Inicio</label>
                                        <input type="date" v-model="course.start_date" class="form-control" id="start_date" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="end_date">Fecha de Cierre</label>
                                        <input type="date" v-model="course.end_date" class="form-control" id="end_date" required>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" v-on:click.prevent="btnCancel" >Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['alert'],
    data () {
        return {
            courses: [],
            editMode: false,
            course: {
                name: '',
                schedule: '',
                start_date: '',
                end_date: ''
            }
        }
    },
    created () {
        this.courses = this.getCourses();
    },
    watch: {
        editMode(newVvalue, oldValue) {
            if(!newVvalue && newVvalue != oldValue)
                this.clearModel();
        }
    },
    methods: {
        getCourses () {
            const url = '/courses';
            axios.get(url)
            .then(response => {
                this.courses = response.data;
            });
        },
        create() {
            const newCourse = this.course;

            axios.post('/courses', newCourse)
            .then((response) => {
                this.courses.unshift(response.data);
                this.alert('Nuevo curso creado con exito.', 'success');
            })
            .catch(err => {
                console.log(err);
                this.alert('Fallo la creacion de Nuevo curso.', 'error');
            });
            this.editMode = false;
            this.closeModal();
        },
        update(course) {
            const data = {name: course.name, schedule: course.schedule, start_date: course.start_date, end_date: course.end_date};

            axios.put(`/courses/${course.id}`, data)
            .then(response => {
                const index = this.courses.findIndex(item => item.id == course.id);
                this.courses[index] = response.data;
                this.alert('El curso ha sido actualizado.', 'success');
            })
            .catch(err => {
                console.log(err);
                this.alert('Ha ocurrido un error, no se pudo actualizar.', 'error');
            });
            this.editMode = false;
            this.closeModal();
        },
        deleteCourse (course, i) {
            const url = '/courses/' + course.id;
            swal.fire({
                title: `Esta seguro de eleminar el curso ${course.name} ?`,
                text: 'Si lo eliminas no podras recuperarlo.!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(url)
                    .then(response => {
                        this.courses.splice(i, 1);
                        this.alert('El curso ha sido eliminado.', 'success');
                    })
                    .catch(err => {
                        this.alert('Ha ocurrido un error, no se pudo eliminar.', 'error');
                    });
                }
            });
        },
        showModal(editMode, course = {}) {
            this.editMode = editMode;
            if(this.editMode) {
                this.course.id = course.id;
                this.course.name = course.name;
                this.course.schedule = course.schedule;
                this.course.start_date = course.start_date;
                this.course.end_date = course.end_date;
            }
            $('#modalCourse').modal('show');
        },
        btnCancel() {
            this.editMode = false;
            this.closeModal();
        },
        clearModel() {
            this.course.id = '';
            this.course.name = '';
            this.course.schedule = '';
            this.course.start_date = '';
            this.course.end_date = '';
        },
        closeModal() {
            $('#modalCourse').modal('hide');
        }
    }
}
</script>