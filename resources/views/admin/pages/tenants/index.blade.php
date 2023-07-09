@extends('adminlte::page')

@section('logo', 'Empresas')

@section('content_header')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="{{ route('tenants.index') }}" class="">Empresas</a></li>
    </ol>
    <h1>Empresas</h1>
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <form action="{{ route('tenants.search')}}"  class="form form-inline">
                @csrf 
                <input type="text" name='filter' placeholder="Filtrar:" class="form-control" value="{{ $filters['filter'] ?? ''}}">
                <button type="submit" class="btn btn-dark">Filtrar</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
               <thead>
                <tr>
                    <th width="100px">Imagem</th>
                    <th>Nome</th>
                    <th width="190px">Ação</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($tenants as $tenant)
                        <tr>
                            <td>
                                <img src="{{ url("storage/$tenant->logo") }}" alt="{{ $tenant->logo}}" style="max-width: 90px">
                            </td>
                            <td>
                                {{ $tenant->name}}
                            </td>
                            <td style="width=10px">
                                {{-- <a href="{{ route('tenants.categories', $tenant->id) }}" class="btn btn-warning" logo="Categorias"><i class="fas fa-layer-group"></i></a> --}}
                                <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-info">Edit</a>
                                <a href="{{ route('tenants.show', $tenant->id) }}" class="btn btn-warning">VER</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            @if (isset($filters))
            {!! $tenants->appends($filters)->links() !!}
            @else
            {!! $tenants->links() !!}
            @endif
        </div>
    </div>
@stop
