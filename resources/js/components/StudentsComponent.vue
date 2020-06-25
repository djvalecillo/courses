<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h1 class="page-header">
                    Listado de Estudiantes
                    <button type="button" class="btn btn-primary float-right" v-on:click.prevent="showModal(false)">+ Nuevo</button>
                </h1>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">F.Nacimiento</th>
                        <th scope="col">Cursos suscritos</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(student, i) in students" :key="student.id">
                            <td>{{ i + 1 }}</td>
                            <td> <a v-bind:href="'/estudiantes/' + student.id"> {{ `${student.firstname} ${student.lastname}` }} </a></td>
                            <td>{{ student.email }}</td>
                            <td>{{ student.birthdate }}</td>
                            <td><span class="badge badge-secondary">{{ student.courses_count || 0 }}</span></td>
                            <td width="15%">
                                <a v-bind:href="'/estudiantes/' + student.id" title="Ver Informacion" class="btn btn-light btn-sm"><i class="fas fa-search-plus"></i></a>
                                <a href="#" v-on:click.prevent="showModal(true, student)" title="Editar" class="btn btn-info btn-sm"><i class="far fa-edit"></i></a>
                                <a href="#" v-on:click.prevent="deleteStudent(student, i)" title="Eliminar" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modalStudent" tabindex="-1" role="dialog" aria-labelledby="CreateStudentModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ this.editMode ? 'Editar' : 'Nuevo' }} Estudiante</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form v-on:submit.prevent="update(student)" v-if="editMode">
                        <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="firstname">Nombre</label>
                                        <input type="text" v-model="student.firstname" class="form-control" id="firstname" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lastname">Apellido</label>
                                        <input type="text" v-model="student.lastname" class="form-control" id="lastname" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" v-model="student.email" class="form-control" id="email" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="birthdate">Fecha de Nacimiento</label>
                                        <input type="date" v-model="student.birthdate" class="form-control" id="birthdate">
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
                                        <label for="firstname">Nombre</label>
                                        <input type="text" v-model="student.firstname" class="form-control" id="firstname" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="lastname">Apellido</label>
                                        <input type="text" v-model="student.lastname" class="form-control" id="lastname" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" v-model="student.email" class="form-control" id="email" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="birthdate">Fecha de Nacimiento</label>
                                        <input type="date" v-model="student.birthdate" class="form-control" id="birthdate">
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
            students: [],
            editMode: false,
            student: {
                firstname: '',
                lastname: '',
                email: '',
                birthdate: ''
            }
        }
    },
    created () {
        this.students = this.getStudents();
    },
    watch: {
        editMode(newVvalue, oldValue) {
            if(!newVvalue && newVvalue != oldValue)
                this.clearModel();
        }
    },
    methods: {
        getStudents () {
            const url = '/students';
            axios.get(url)
            .then(response => {
                this.students = response.data;
            });
        },
        create() {
            const newStudent = this.student;

            axios.post('/students', newStudent)
            .then((response) => {
                this.students.unshift(response.data);
                this.alert('Nuevo estudiante creado con exito.', 'success');
            })
            .catch(err => {
                console.log(err);
                this.alert('Fallo la creacion de Nuevo estudiante.', 'error');
            });
            this.editMode = false;
            this.closeModal();
        },
        update(student) {
            const data = {firstname: student.firstname, lastname: student.lastname, email: student.email, birthdate: student.birthdate};

            axios.put(`/students/${student.id}`, data)
            .then(response => {
                this.getStudents();
                this.alert('El estudiante ha sido actualizado.', 'success');
            })
            .catch(err => {
                console.log(err);
                this.alert('Ha ocurrido un error, no se pudo actualizar.', 'error');
            });
            this.editMode = false;
            this.closeModal();
        },
        deleteStudent (student, i) {
            const url = '/students/' + student.id;
            swal.fire({
                title: `Esta seguro de eliminar el estudiante ${student.firstname} ?`,
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
                        this.students.splice(i, 1);
                        this.alert('El estudiante ha sido eliminado.', 'success');
                    })
                    .catch(err => {
                        this.alert('Ha ocurrido un error, no se pudo eliminar.', 'error');
                    });
                }
            });
        },
        showModal(editMode, student = {}) {
            this.editMode = editMode;
            if(this.editMode) {
                this.student.id = student.id;
                this.student.firstname = student.firstname;
                this.student.lastname = student.lastname;
                this.student.email = student.email;
                this.student.birthdate = student.birthdate;
            }
            $('#modalStudent').modal('show');
        },
        btnCancel() {
            this.editMode = false;
            this.closeModal();
        },
        clearModel() {
            this.student.id = '';
            this.student.firstname = '';
            this.student.lastname = '';
            this.student.email = '';
            this.student.birthdate = '';
        },
        closeModal() {
            $('#modalStudent').modal('hide');
        }
    }
}
</script>