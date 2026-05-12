@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Recargas Telefónicas</h1>
        <p class="text-muted">Realice recargas de saldo para todas las compañías</p>
    </div>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">
        <form action="{{ route('recargas_telefonicas.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="id_venta" value="">

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Fecha de Operación</label>
                <input type="date" name="fecha" class="form-control bg-light" value="{{ date('Y-m-d') }}" readonly>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Número Celular (10 dígitos)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                    <input type="tel" name="numero_telefono" class="form-control form-control-lg" 
                           placeholder="Ej: 5512345678" pattern="[0-9]{10}" maxlength="10" required>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Compañía</label>
                <select name="compania" class="form-select form-select-lg" required>
                    <option value="" selected disabled>Seleccione compañía</option>
                    <option value="Telcel">Telcel</option>
                    <option value="Movistar">Movistar</option>
                    <option value="AT&T">AT&T</option>
                    <option value="Bait">Bait</option>
                    <option value="Virgin Mobile">Virgin Mobile</option>
                </select>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label fw-bold">Monto de la Recarga</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <select name="monto" class="form-select form-select-lg" required>
                        <option value="" selected disabled>Seleccione monto</option>
                        <option value="10">10.00</option>
                        <option value="20">20.00</option>
                        <option value="30">30.00</option>
                        <option value="50">50.00</option>
                        <option value="100">100.00</option>
                        <option value="150">150.00</option>
                        <option value="200">200.00</option>
                        <option value="500">500.00</option>
                    </select>
                </div>
            </div>

            <div class="row g-2 justify-content-center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                        <i class="fas fa-check-circle me-1"></i> Realizar Recarga
                    </button>
                </div>
                <div class="col-md-4">
                    <button type="reset" class="btn btn-warning text-white w-100 fw-bold py-2 shadow-sm" style="background-color: #ff7b00;">
                        <i class="fas fa-eraser me-1"></i> Limpiar
                    </button>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('recargas_telefonicas.index') }}" class="btn btn-secondary w-100 fw-bold py-2 shadow-sm">
                        <i class="fas fa-history me-1"></i> Ver Historial
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection