@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Historial de Ventas</h1>
        <p class="text-muted">Consulta las transacciones realizadas en Tienda La Subidita</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group w-50">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Buscar por fecha o ID de venta...">
            </div>
            <a href="{{ route('ventas.create') }}" class="btn btn-primary px-4 fw-bold shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Nueva Venta
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center border">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 100px;">ID Venta</th>
                        <th>Fecha y Hora</th>
                        <th>Tipo de Venta</th>
                        <th>Total Cobrado</th>
                        <th style="width: 250px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventas as $venta)
                    <tr>
                        <td class="fw-bold text-secondary">#{{ $venta->id_venta }}</td>
                        <td>{{ $venta->fecha }}</td>
                        <td>
                            <span class="badge rounded-pill bg-info text-dark px-3">{{ $venta->tipo_venta }}</span>
                        </td>
                        <td class="text-primary fw-bold fs-5">
                            ${{ number_format($venta->total, 2) }}
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('ventas.show', $venta->id_venta) }}" class="btn btn-primary btn-sm px-3 shadow-sm flex-grow-1">
                                    <i class="fas fa-file-invoice me-1"></i> Ver Ticket
                                </a>

                                <form action="{{ route('ventas.destroy', $venta->id_venta) }}" method="POST" class="d-inline flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm w-100" onclick="return confirm('¿Está seguro de anular esta venta? El stock será devuelto al inventario.')">
                                        <i class="fas fa-ban me-1"></i> Anular
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-muted">
                            <i class="fas fa-receipt fa-3x mb-3 d-block opacity-50"></i>
                            No se han registrado ventas en el historial de Tienda La Subidita.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-primary text-white p-3 rounded-3 mt-3 shadow-sm d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">Corte de Caja (Total Histórico):</h4>
            <h3 class="mb-0 fw-bold">${{ number_format($ventas->sum('total'), 2) }}</h3>
        </div>
    </div>
</div>
@endsection