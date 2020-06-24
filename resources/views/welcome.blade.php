@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1 class="display-4">Hola, Bienvenido a CoursesApp!</h1>
                <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                <hr class="my-4">
                <p>Te presentamos nuestros tres mejores cursos.</p>
            </div>

           <best-courses-component> </best-courses-component>
        </div>
    </div>
</div>

@endsection