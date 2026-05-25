@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Detalle de Venta</h1>
        <p class="text-muted">Comprobante de transacción #{{ $venta->id_venta }}</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0" id="ticket-card">
                <div class="card-header bg-primary text-white py-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-store me-2"></i>Tienda La Subidita</h5>
                        </div>
                        <div class="col-6 text-end">
                            <span class="fw-bold">Fecha:</span> {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}<br>
                            <span class="fw-bold">Hora:</span> {{ \Carbon\Carbon::parse($venta->hora)->format('h:i A') }}
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted text-uppercase small fw-bold">Estado de Pago</p>
                            <span class="badge bg-success px-3 py-2 shadow-sm">Completado</span>
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
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary px-4 fw-bold shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Volver al Historial
                </a>
                <button class="btn btn-primary px-4 fw-bold shadow-sm" onclick="confirmarImprimir()">
                    <i class="fas fa-print me-2"></i> Imprimir Ticket
                </button>
            </div>
            
            <p class="text-center mt-4 text-muted small">
                Gracias por su compra en <strong>Tienda La Subidita</strong>.
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarImprimir() {
        Swal.fire({
            title: '¿Imprimir Ticket?',
            text: "¿Desea enviar este comprobante a la impresora?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, imprimir'
        }).then((result) => {
            if (result.isConfirmed) {
                var contenido = document.getElementById('ticket-card').innerHTML;
                var ventana = window.open('', '_blank', 'width=800,height=600');
                
                ventana.document.write('<html><head><title>Ticket Venta #{{ $venta->id_venta }}</title>');
                ventana.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
                ventana.document.write('<style>body { padding: 20px; } .card { border: none !important; }</style>');
                ventana.document.write('</head><body>');
                ventana.document.write(contenido);
                ventana.document.write('</body></html>');
                
                ventana.document.close();
                ventana.focus();
                
                setTimeout(function() {
                    ventana.print();
                    ventana.close();
                }, 500);
            }
        });
    }
</script>
@endsection