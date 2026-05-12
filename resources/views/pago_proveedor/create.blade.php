@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Pago para Proveedores</h1>
        <p class="text-muted">Registre el pago realizado a un proveedor</p>
    </div>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">
        <form action="{{ route('pagos_proveedores.store') }}" method="POST">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Fecha del Pago</label>
                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Proveedor</label>
                <select name="id_proveedor" class="form-select" required>
                    <option value="" selected disabled>Seleccione un proveedor</option>
                    @foreach($proveedores as $p)
                        <option value="{{ $p->id_proveedor }}">{{ $p->nombre_comercial }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Método de Pago</label>
                <select name="metodo_pago" class="form-select" required>
                    <option value="" selected disabled>Seleccione método de pago</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Crédito">Crédito</option>
                </select>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label fw-bold">Monto del Pago</label>
                <input type="number" step="0.01" name="monto" class="form-control" placeholder="0.00" required>
            </div>

            <div class="row g-2 justify-content-center">
                <div class="col-md-4"><button type="submit" class="btn btn-success w-100 fw-bold py-2" style="background-color: #198754;">Pagar</button></div>
                <div class="col-md-4"><button type="reset" class="btn btn-warning text-white w-100 fw-bold py-2" style="background-color: #ff7b00;">Cancelar</button></div>
                <div class="col-md-4"><a href="{{ route('pagos_proveedores.index') }}" class="btn btn-secondary w-100 fw-bold py-2" style="background-color: #6c757d;">Regresar</a></div>
            </div>
        </form>
    </div>
</div>
@endsection