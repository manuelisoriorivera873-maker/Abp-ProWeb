@extends('layouts.template')

@section('content')
<div class="container-fluid" style="margin-top: 50px; min-height: 100vh;">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Editar Recarga</h1>
        <p class="text-muted">Corrija la información de la transacción #{{ $recarga->id_recarga }}</p>
    </div>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">
        <form action="{{ route('recargas_telefonicas.update', $recarga->id_recarga) }}" method="POST" id="form-editar-recarga" novalidate autocomplete="off">
            @csrf
            @method('PUT')

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Fecha de la Recarga</label>
                <input type="date" name="fecha" class="form-control" value="{{ $recarga->fecha }}" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Número Celular (10 dígitos)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                    <input type="text" id="numero_telefono" name="numero_telefono" class="form-control form-control-lg"
                           value="{{ $recarga->numero_telefono }}" maxlength="10" required>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Compañía</label>
                <select id="compania" name="compania" class="form-select form-select-lg" required>
                    <option value="Telcel" {{ $recarga->compania == 'Telcel' ? 'selected' : '' }}>Telcel</option>
                    <option value="Movistar" {{ $recarga->compania == 'Movistar' ? 'selected' : '' }}>Movistar</option>
                    <option value="AT&T" {{ $recarga->compania == 'AT&T' ? 'selected' : '' }}>AT&T</option>
                    <option value="Bait" {{ $recarga->compania == 'Bait' ? 'selected' : '' }}>Bait</option>
                    <option value="Virgin Mobile" {{ $recarga->compania == 'Virgin Mobile' ? 'selected' : '' }}>Virgin Mobile</option>
                </select>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label fw-bold">Monto de la Recarga</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <select id="monto" name="monto" class="form-select form-select-lg" required>
                        @foreach([10, 20, 30, 50, 100, 150, 200, 500] as $m)
                            <option value="{{ $m }}" {{ $recarga->monto == $m ? 'selected' : '' }}>${{ number_format($m, 2) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-2 justify-content-center border-top pt-4">
                <div class="col-md-5">
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                        <i class="fas fa-save me-2"></i> Actualizar Recarga
                    </button>
                </div>
                <div class="col-md-5">
                    <a href="{{ route('recargas_telefonicas.index') }}" id="btn-cancelar" class="btn btn-warning btn-lg text-white w-100 fw-bold shadow-sm" style="background-color: #ff7b00;">
                        <i class="fas fa-times-circle me-2"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-swal-confirm { background-color: #0d6efd !important; color: white !important; margin: 0 10px; padding: 10px 24px; font-weight: bold; border-radius: 8px; }
    .btn-swal-cancel { background-color: #ff7b00 !important; color: white !important; margin: 0 10px; padding: 10px 24px; font-weight: bold; border-radius: 8px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const inputTelefono = document.getElementById('numero_telefono');
    const formEditar = document.getElementById('form-editar-recarga');

    // Forzar estrictamente solo números en el teléfono
    inputTelefono.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn-swal-confirm",
            cancelButton: "btn-swal-cancel"
        },
        buttonsStyling: false
    });

    formEditar.addEventListener('submit', function(e) {
        e.preventDefault();

        const telefono = inputTelefono.value.trim();
        const compania = document.getElementById('compania').value;
        const monto = document.getElementById('monto').value;

        if (!telefono || telefono.length !== 10) {
            Swal.fire({ title: 'Número Inválido', text: 'El número de celular debe tener exactamente 10 dígitos numéricos.', icon: 'error', confirmButtonColor: '#0d6efd' });
            return;
        }

        swalWithBootstrapButtons.fire({
            title: '¿Actualizar los datos?',
            html: `Se guardarán los cambios para el número <strong>${telefono}</strong> (${compania}) con monto de <strong>$${parseFloat(monto).toFixed(2)}</strong>.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '¡Modificado!',
                    text: 'Los datos de la recarga fueron actualizados correctamente.',
                    icon: 'success',
                    confirmButtonColor: '#0d6efd'
                }).then(() => {
                    formEditar.submit();
                });
            }
        });
    });

    document.getElementById('btn-cancelar').addEventListener('click', function(e) {
        e.preventDefault();
        const urlDestino = this.getAttribute('href');

        swalWithBootstrapButtons.fire({
            title: '¿Cancelar cambios?',
            text: 'Se perderán las modificaciones que hayas hecho en este formulario.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'No, quedarme',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlDestino;
            }
        });
    });
</script>
@endsection
