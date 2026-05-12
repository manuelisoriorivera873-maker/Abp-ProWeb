@extends('layouts.template')

@section('content')
<div class="container py-5 text-center">
    <div class="card shadow border-0 mx-auto" style="max-width: 600px; border-radius: 20px;">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0">Comprobante de Pago #{{ $pago_proveedor->id_pago }}</h4>
        </div>
        <div class="card-body p-5">
            <h5 class="text-muted mb-4">Tienda La Subidita</h5>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Fecha:</span> <span>{{ $pago_proveedor->fecha }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Proveedor:</span> <span>{{ $pago_proveedor->proveedor->nombre_comercial ?? 'Proveedor no encontrado' }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="fw-bold">Método:</span> <span>{{ $pago_proveedor->metodo_pago }}</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between py-2">
                <span class="h4 fw-bold">TOTAL:</span>
                <span class="h4 fw-bold text-primary">${{ number_format($pago_proveedor->monto, 2) }}</span>
            </div>
        </div>
        <div class="card-footer bg-light">
            <a href="{{ route('pagos_proveedores.index') }}" class="btn btn-secondary">Regresar</a>
            <button onclick="window.print()" class="btn btn-primary">Imprimir</button>
        </div>
    </div>
</div>
@endsection