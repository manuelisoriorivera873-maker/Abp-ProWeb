@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Detalle de Venta</h1>
        <p class="text-muted">Comprobante de transacción #{{ $venta->id_venta }}</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-store me-2"></i>Tienda La Subidita</h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="fw-bold">Fecha:</span> {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted text-uppercase small fw-bold">Estado de Pago</p>
                            <span class="badge bg-success px-3 py-2 shadow-sm"><i class="fas fa-check-circle me-1"></i> Completado</span>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-1 text-muted text-uppercase small fw-bold">Método de Venta</p>
                            <p class="fw-bold fs-5 text-dark">{{ $venta->tipo_venta }}</p>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-hover border-top">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th>Descripción del Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unitario</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($venta->detalles as $detalle)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $detalle->producto->nombre ?? 'Producto no disponible' }}</div>
                                        <small class="text-muted">SKU: {{ $detalle->producto->codigo ?? 'N/A' }}</small>
                                    </td>
                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                    <td class="text-end">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="text-end fw-bold text-dark">${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between border-top pt-3">
                                <span class="h4 fw-bold">TOTAL:</span>
                                <span class="h4 fw-bold text-primary">${{ number_format($venta->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light py-3 border-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('ventas.index') }}" class="btn btn-secondary px-4 fw-bold shadow-sm">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Historial
                        </a>
                        <button class="btn btn-primary px-4 fw-bold shadow-sm" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Imprimir Ticket
                        </button>
                    </div>
                </div>
            </div>
            
            <p class="text-center mt-4 text-muted small">
                Gracias por su compra en <strong>Tienda La Subidita</strong>. Guarde este comprobante para cualquier aclaración.
            </p>
        </div>
    </div>
</div>

<style>
    /* Estilo para que al imprimir no salgan los botones ni el fondo gris */
    @media print {
        .btn, .text-center.mb-4, .card-footer {
            display: none !important;
        }
        .card {
            border: none !important;
            shadow: none !important;
        }
        body {
            background-color: white !important;
        }
    }
</style>
@endsection