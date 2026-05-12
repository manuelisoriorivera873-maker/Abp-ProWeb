@extends('layouts.template')

@section('content')
<div class="container-fluid text-center">
    <h1 class="display-5 fw-bold">Historial de Recargas</h1>
    <p class="lead text-muted">Registro de transacciones telefónicas realizadas en la tienda</p>

    <div class="card shadow-sm border-0 p-4 mt-4" style="border-radius: 15px;">
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('recargas_telefonicas.create') }}" class="btn btn-primary fw-bold px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Nueva Recarga
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Acciones</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Compañía</th>
                        <th>Monto</th>
                        <th class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recargas as $r)
                    <tr>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('recargas_telefonicas.show', $r->id_recarga) }}" class="btn btn-sm btn-info text-white shadow-sm fw-bold">
                                    Ver
                                </a>
                                <a href="{{ route('recargas_telefonicas.edit', $r->id_recarga) }}" class="btn btn-sm btn-warning text-white shadow-sm fw-bold" style="background-color: #ffb100;">
                                    Editar
                                </a>
                                <form action="{{ route('recargas_telefonicas.destroy', $r->id_recarga) }}" method="POST" onsubmit="return confirm('¿Eliminar registro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm fw-bold">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="text-muted small">#{{ str_pad($r->id_recarga, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                        <td class="fw-bold">{{ $r->numero_telefono }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $r->compania }}</span>
                        </td>
                        <td class="fw-bold text-success">${{ number_format($r->monto, 2) }}</td>
                        <td class="text-center">
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Exitosa</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection