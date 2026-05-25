@extends('layouts.template')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1>Corte de Caja | <span id="clock" class="text-primary fw-bold"></span></h1>
        <p class="text-muted">Resumen en Tienda La Subidita | {{ date('d/m/Y') }}</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="card p-3 border-success"><h6>Ventas</h6><h3>${{ number_format($totalVentas, 2) }}</h3></div></div>
        <div class="col-md-3"><div class="card p-3 border-info"><h6>Recargas</h6><h3>${{ number_format($totalRecargas, 2) }}</h3></div></div>
        <div class="col-md-3"><div class="card p-3 border-danger"><h6>Pagos Prov.</h6><h3>${{ number_format($totalPagos, 2) }}</h3></div></div>
        <div class="col-md-3"><div class="card p-3 bg-primary text-white"><h6>Esperado</h6><h3>${{ number_format($totalEsperado, 2) }}</h3></div></div>
    </div>

    <button class="btn btn-primary btn-lg w-100" data-bs-toggle="modal" data-bs-target="#corteModal">Realizar Corte Manual</button>

    <div class="card p-4 mt-4 shadow-sm">
        <h5>Auditorías realizadas hoy:</h5>
        @forelse($historialCortes as $corte)
            <div class="alert {{ $corte->diferencia >= 0 ? 'alert-success' : 'alert-danger' }} d-flex justify-content-between">
                <span><strong>{{ $corte->hora_cierre }}</strong> | Dif: ${{ number_format($corte->diferencia, 2) }}</span>
                <button class="btn btn-sm btn-outline-danger" onclick="confirmarEliminar({{ $corte->id_corte }})"><i class="fas fa-trash"></i></button>
            </div>
        @empty
            <p class="text-muted">Sin auditorías hoy.</p>
        @endforelse
    </div>

    <div class="card p-4 mt-4 bg-light shadow-sm">
        <h5 class="text-primary"><i class="fas fa-file-invoice-dollar"></i> Resumen del Último Arqueo</h5>
        <div class="row text-center mt-3">
            <div class="col-4"><small class="text-muted">Total Entradas</small><h5 class="fw-bold">${{ number_format($totalVentas + $totalRecargas, 2) }}</h5></div>
            <div class="col-4"><small class="text-muted">Total Pagos</small><h5 class="fw-bold text-danger">${{ number_format($totalPagos, 2) }}</h5></div>
            <div class="col-4"><small class="text-muted">Efectivo declarado (Último)</small><h5 class="fw-bold text-success">${{ number_format($totalEfectivoIngresado, 2) }}</h5></div>
        </div>
    </div>
</div>

<form id="formEliminar" method="POST" style="display:none;">@csrf @method('DELETE')</form>
<div class="modal fade" id="corteModal" tabindex="-1">
    <form action="{{ route('cortes_caja.store') }}" method="POST" id="corteForm" class="modal-dialog">
        @csrf
        <input type="hidden" name="fecha" value="{{ $fecha }}">
        <input type="hidden" name="total_ventas" value="{{ $totalVentas }}">
        <input type="hidden" name="total_recargas" value="{{ $totalRecargas }}">
        <input type="hidden" name="total_pagos" value="{{ $totalPagos }}">
        <input type="hidden" name="total_esperado" value="{{ $totalEsperado }}">
        <div class="modal-content p-4">
            <label>Efectivo Real en Caja:</label>
            <input type="number" step="0.01" name="total_real" class="form-control" required>
            <button type="button" class="btn btn-primary mt-3" onclick="confirmarCorte()">Guardar Corte</button>
        </div>
    </form>
</div>

<script>
    function updateClock() { document.getElementById('clock').innerText = new Date().toLocaleTimeString(); }
    setInterval(updateClock, 1000); updateClock();
    function confirmarCorte() { Swal.fire({title:'¿Guardar?', icon:'question', showCancelButton:true}).then(r => {if(r.isConfirmed) document.getElementById('corteForm').submit();}); }
    function confirmarEliminar(id) { Swal.fire({title:'¿Borrar?', icon:'warning', showCancelButton:true}).then(r => {if(r.isConfirmed){let f=document.getElementById('formEliminar'); f.action='/cortes_caja/'+id; f.submit();}}); }
    @if(session('success')) Swal.fire('Éxito', '{{ session('success') }}', 'success'); @endif
</script>
@endsection