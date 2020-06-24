<template>
    <div class="card-deck">
        <div class="card text-white bg-primary mb-3 col-md-4" v-for="course in courses" :key="course.id">
            <div class="card-body">
                <h5 class="card-title">{{ course.name }}</h5>
                <span class="badge badge-secondary"> <h2>{{ course.total }}</h2> </span> estudiantes
                <p class="card-text">
                    Some quick example text to build.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created () {
            this.courses = this.getCourses();
        },
        data () {
            return {
                courses: []
            }
        },
        methods: {
            getCourses () {
                const url = '/courses/stats';
                axios.get(url)
                .then(response => {
                    this.courses = response.data;
                });
            },
        }
    }
</script>