@extends('adminlte::page')

@section('title', "Editar o Cargo {$role->name}")

@section('content_header')
    <h1>Editar o Cargo {{$role->name}}</h1>

@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.update', $role->id) }}" class="form" method="POST">
                @method('PUT')

                @include('admin.pages.roles.__partials.form')
        </div>
    </div>
@endsection