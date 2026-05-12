@extends('layouts.template')

@section('content')
<style>
    /* Estilo para que combine con el POS */
    .card-resumen { border-radius: 15px; border: none; transition: 0.3s; }
    .card-resumen:hover { transform: translateY(-5px); }
    .bg-subidita { background: linear-gradient(45deg, #0d6efd, #0dcaf0); }
    .table-subidita thead { background-color: #f8f9fa; color: #0d6efd; }
    .btn-rounded { border-radius: 10px; padding: 10px 30px; font-weight: bold; }
</style>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="display-5 fw-bold text-primary">Corte de Caja</h1>
        <p class="text-muted">Resumen de operaciones en Tienda La Subidita</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-4">
            <div class="card shadow-sm p-3 card-resumen text-center">
                <form action="{{ route('cortes_caja.index') }}" method="GET" id="fechaForm">
                    <label for="fecha" class="form-label fw-bold text-secondary">Fecha del Corte</label>
                    <input type="date" name="fecha" id="fecha" class="form-control form-control-lg text-center border-primary-subtle" 
                           value="{{ $fecha }}" onchange="document.getElementById('fechaForm').submit()">
                </form>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card bg-white shadow-sm text-center p-3 card-resumen border-bottom border-success border-4">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Ventas</h6>
                    <h2 class="fw-bold text-success">${{ number_format($totalVentas, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white shadow-sm text-center p-3 card-resumen border-bottom border-info border-4">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Recargas</h6>
                    <h2 class="fw-bold text-info">${{ number_format($totalRecargas, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-white shadow-sm text-center p-3 card-resumen border-bottom border-danger border-4">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Pagos Prov.</h6>
                    <h2 class="fw-bold text-danger">-${{ number_format($totalPagos, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-subidita text-white text-center p-3 card-resumen shadow">
                <div class="card-body">
                    <h6 class="text-uppercase small fw-bold opacity-75">Esperado en Caja</h6>
                    <h2 class="fw-bold">${{ number_format($totalEsperado, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 overflow-hidden" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-subidita">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Operación</th>
                        <th>Descripción</th>
                        <th>Monto</th>
                        <th class="pe-4 text-end">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($operaciones as $op)
                    <tr>
                        <td class="ps-4 text-muted small">#{{ $op->id }}</td>
                        <td>
                            <span class="badge rounded-pill {{ $op->tipo == 'Venta' ? 'bg-success-subtle text-success' : ($op->tipo == 'Recarga' ? 'bg-info-subtle text-info' : 'bg-danger-subtle text-danger') }} border px-3">
                                {{ $op->tipo }}
                            </span>
                        </td>
                        <td>{{ $op->descripcion }}</td> 
                        <td class="fw-bold text-dark">${{ number_format($op->monto, 2) }}</td>
                        <td class="pe-4 text-end text-muted small">{{ $op->hora }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x d-block mb-3 opacity-25"></i>
                            Sin movimientos para esta fecha.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center pb-5">
        <button type="button" class="btn btn-primary btn-lg btn-rounded shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#corteModal">
            <i class="fas fa-cash-register me-2"></i> Generar Corte
        </button>
        
        <a href="{{ url('/') }}" class="btn btn-light btn-lg btn-rounded border px-5">Cancelar</a>
    </div>
</div>

<div class="modal fade" id="corteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('cortes_caja.store') }}" method="POST">
        @csrf
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
          <div class="modal-header border-0 pt-4 px-4">
            <h5 class="modal-title fw-bold text-primary">Cierre Definitivo de Caja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <input type="hidden" name="fecha" value="{{ $fecha }}">
            <div class="mb-4 text-center">
                <label class="form-label fw-bold h5 text-secondary">Efectivo Físico en Caja</label>
                <div class="input-group input-group-lg shadow-sm">
                    <span class="input-group-text bg-primary text-white border-0">$</span>
                    <input type="number" step="0.01" name="total_real" class="form-control text-center border-0 bg-light" required placeholder="0.00" autofocus>
                </div>
                <div class="form-text mt-2">Ingrese el total de monedas y billetes contados.</div>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold small text-muted">OBSERVACIONES</label>
                <textarea name="observaciones" class="form-control border-light bg-light" rows="2" placeholder="Ej. Faltaron $5 pesos..."></textarea>
            </div>
          </div>
          <div class="modal-footer border-0 justify-content-center pb-4">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5">Guardar y Cerrar Día</button>
          </div>
        </div>
    </form>
  </div>
</div>
@endsection