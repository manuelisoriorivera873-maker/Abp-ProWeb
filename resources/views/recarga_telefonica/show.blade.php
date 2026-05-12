@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Detalle de la Recarga</h1>
        <p class="text-muted">Comprobante digital de la transacción</p>
    </div>

    <div class="card shadow border-0 mx-auto" style="max-width: 500px; border-radius: 20px;">
        <div class="bg-primary text-white text-center p-4" style="border-radius: 20px 20px 0 0;">
            <i class="fas fa-check-circle fa-3x mb-3"></i>
            <h3 class="fw-bold mb-0">Recarga Exitosa</h3>
            <p class="mb-0 opacity-75">Folio: #{{ str_pad($recarga->id_recarga, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h6 class="text-muted text-uppercase fw-bold">Monto Recargado</h6>
                <h1 class="display-4 fw-bold text-dark">${{ number_format($recarga->monto, 2) }}</h1>
            </div>

            <hr class="border-dashed">

            <div class="row g-3">
                <div class="col-6">
                    <p class="text-muted mb-0">Compañía</p>
                    <p class="fw-bold fs-5">{{ $recarga->compania }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="text-muted mb-0">Número</p>
                    <p class="fw-bold fs-5">{{ $recarga->numero_telefono }}</p>
                </div>
                <div class="col-6">
                    <p class="text-muted mb-0">Fecha</p>
                    <p class="fw-bold">{{ \Carbon\Carbon::parse($recarga->fecha)->format('d/m/Y') }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="text-muted mb-0">ID Venta</p>
                    <p class="fw-bold">{{ $recarga->id_venta ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="bg-light p-3 rounded-3 mt-4 text-center">
                <p class="small text-muted mb-0 italic">
                    Transacción procesada correctamente en el sistema de Tienda La Subidita.
                </p>
            </div>
        </div>

        <div class="card-footer bg-white border-0 p-4 pt-0">
            <div class="row g-2">
                <div class="col-12">
                    <a href="{{ route('recargas_telefonicas.index') }}" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                        <i class="fas fa-list-ul me-2"></i> Volver al Historial
                    </a>
                </div>
                <div class="col-12">
                    <button onclick="window.print()" class="btn btn-outline-secondary w-100 fw-bold">
                        <i class="fas fa-print me-2"></i> Imprimir Comprobante
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed {
        border-top: 2px dashed #dee2e6;
        margin: 1.5rem 0;
    }
</style>
@endsection