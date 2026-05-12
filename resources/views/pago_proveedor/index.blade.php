@extends('layouts.template')

@section('content')
<div class="container-fluid text-center">
    <h1 class="display-5 fw-bold">Historial de Pagos</h1>
    <p class="lead text-muted">Consulta los pagos realizados a proveedores</p>

    <div class="card shadow-sm border-0 p-4 mt-4">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('pagos_proveedores.create') }}" class="btn btn-primary fw-bold px-4">+ Nuevo Pago</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr>
                        <td>#{{ $pago->id_pago }}</td>
                        <td>{{ $pago->fecha }}</td>
                        <td>{{ $pago->proveedor->nombre_comercial ?? 'N/A' }}</td>
                        <td class="fw-bold text-success">${{ number_format($pago->monto, 2) }}</td>
                        <td><span class="badge bg-info text-dark">{{ $pago->metodo_pago }}</span></td>
                        <td>
                            <a href="{{ route('pagos_proveedores.show', $pago->id_pago) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                            <a href="{{ route('pagos_proveedores.edit', $pago->id_pago) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection