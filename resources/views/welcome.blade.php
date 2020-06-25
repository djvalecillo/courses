@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="jumbotron">
                <h1 class="display-4">Hola, Bienvenido a CoursesApp!</h1>
                <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
            </div>
            @auth
                <h1 class="h3 mb-3 text-gray-800">Top 3 cursos con mas asistencia en los utimos 6 meses:</h1>
                <best-courses-component> </best-courses-component>
            @endauth
        </div>
    </div>
</div>

@endsection