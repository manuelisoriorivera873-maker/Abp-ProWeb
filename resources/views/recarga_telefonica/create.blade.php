@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Recargas Telefónicas</h1>
        <p class="text-muted">Realice recargas de saldo para todas las compañías</p>
    </div>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">
        <form action="{{ route('recargas_telefonicas.store') }}" method="POST" id="form-recarga" novalidate autocomplete="off">
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
                    <input type="text" id="numero_telefono" name="numero_telefono" class="form-control form-control-lg"
                           placeholder="Ej: 5512345678" maxlength="10" required>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Compañía</label>
                <select id="compania" name="compania" class="form-select form-select-lg" required>
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
                    <select id="monto" name="monto" class="form-select form-select-lg" required>
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
                    <button type="button" id="btn-limpiar" class="btn btn-warning text-white w-100 fw-bold py-2 shadow-sm" style="background-color: #ff7b00;">
                        <i class="fas fa-eraser me-1"></i> Limpiar
                    </button>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('recargas_telefonicas.index') }}" id="btn-historial" class="btn btn-secondary w-100 fw-bold py-2 shadow-sm">
                        <i class="fas fa-history me-1"></i> Ver Historial
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Estilos personalizados para los botones de SweetAlert2 */
    .btn-swal-confirm { background-color: #198754 !important; color: white !important; margin: 0 10px; padding: 10px 24px; font-weight: bold; border-radius: 8px; }
    .btn-swal-cancel { background-color: #dc3545 !important; color: white !important; margin: 0 10px; padding: 10px 24px; font-weight: bold; border-radius: 8px; }
    .btn-swal-clear { background-color: #ff7b00 !important; color: white !important; margin: 0 10px; padding: 10px 24px; font-weight: bold; border-radius: 8px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const inputTelefono = document.getElementById('numero_telefono');
    const formRecarga = document.getElementById('form-recarga');

    // Control estricto: Bloquear letras y caracteres, solo admitir números
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

    // Validar y confirmar envío de recarga
    formRecarga.addEventListener('submit', function(e) {
        e.preventDefault();

        const telefono = inputTelefono.value.trim();
        const compania = document.getElementById('compania').value;
        const monto = document.getElementById('monto').value;

        // Validaciones coherentes en JS para evitar alertas feas del navegador
        if (!telefono || telefono.length !== 10) {
            Swal.fire({ title: 'Número Inválido', text: 'El número de celular debe tener exactamente 10 dígitos numéricos.', icon: 'error', confirmButtonColor: '#198754' });
            return;
        }

        if (!compania) {
            Swal.fire({ title: 'Falta Compañía', text: 'Por favor, selecciona una compañía telefónica.', icon: 'error', confirmButtonColor: '#198754' });
            return;
        }

        if (!monto) {
            Swal.fire({ title: 'Falta Monto', text: 'Por favor, selecciona el monto de la recarga.', icon: 'error', confirmButtonColor: '#198754' });
            return;
        }

        swalWithBootstrapButtons.fire({
            title: '¿Confirmar Transacción?',
            html: `Se aplicará una recarga de <strong>$${parseFloat(monto).toFixed(2)}</strong> al número <strong>${telefono}</strong> (${compania}).`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, recargar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '¡Recarga Procesada!',
                    text: 'La recarga se registró exitosamente en el sistema.',
                    icon: 'success',
                    confirmButtonColor: '#198754'
                }).then(() => {
                    formRecarga.submit();
                });
            }
        });
    });

    // Confirmación al presionar "Limpiar"
    document.getElementById('btn-limpiar').addEventListener('click', function() {
        Swal.mixin({
            customClass: { confirmButton: "btn-swal-clear", cancelButton: "btn-swal-cancel" },
            buttonsStyling: false
        }).fire({
            title: '¿Limpiar formulario?',
            text: 'Se borrarán todos los datos ingresados.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, limpiar',
            cancelButtonText: 'No, mantener',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                formRecarga.reset();
            }
        });
    });

    // Confirmación al presionar "Ver Historial"
    document.getElementById('btn-historial').addEventListener('click', function(e) {
        e.preventDefault();
        const urlDestino = this.getAttribute('href');

        swalWithBootstrapButtons.fire({
            title: '¿Ir al historial?',
            text: 'Salir de esta pantalla te llevará al listado de transacciones.',
            icon: 'question',
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
