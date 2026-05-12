@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Lista de Proveedores</h4>
                <a class="btn btn-light btn-sm" href="{{ route('proveedores.create') }}">
                    <i class="fas fa-plus"></i> Nuevo Proveedor
                </a>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nombre Comercial</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Tipo de Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($proveedores as $proveedor)
                            <tr>
                                <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $proveedor->nombre_comercial }}</td>
                                <td>{{ $proveedor->telefono }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $proveedor->direccion }}</td>
                                <td>
                                    <span class="badge bg-info text-dark shadow-sm">
                                        {{ $proveedor->tipo_pago }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-warning btn-sm px-3" href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>

                                        <form action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-3" onclick="return confirm('¿Seguro que deseas eliminar a {{ $proveedor->nombre_comercial }}?')">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($proveedores->isEmpty())
                    <div class="alert alert-light text-center mt-3 border">
                        <i class="fas fa-info-circle text-warning"></i> No hay proveedores registrados actualmente.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection