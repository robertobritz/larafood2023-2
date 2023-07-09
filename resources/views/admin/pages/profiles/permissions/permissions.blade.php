@extends('adminlte::page')

@section('title', "Permissões do perfil {$profile->name}")

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('profiles.index') }}" class="">Perfis</a></li>
    </ol>
    <h1>Permissões do Perfil <strong>{{ $profile->name }} </strong>
        <a href="{{ route('profiles.permissions.available', $profile->id)}}" class="btn btn-dark">ADD NOVO PERMISSÃO</a>
    </h1>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <table class="table table-condensed">
               <thead>
                <tr>
                    <th>Nome</th>
                    <th width="50px">Ação</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>
                                {{ $permission->name}}
                            </td>
                            <td style="width=1000px">
                                <a href="{{ route('profiles.permission.detach', [ $profile->id, $permission->id]) }}" class="btn btn-danger">Remover</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
            {!! $permissions->appends($filters)->links() !!}
            @else
            {!! $permissions->links() !!}
            @endif
        </div>
    </div>
@stop
