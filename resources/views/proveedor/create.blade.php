@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg border-0">

            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Registro de Proveedor</h4>
                <a href="{{ route('proveedores.index') }}" class="btn btn-light btn-sm shadow-sm">
                    <i class="fas fa-list"></i> Mostrar proveedores
                </a>
            </div>

            <div class="card-body p-5">

                <form action="{{ route('proveedores.store') }}" method="POST" id="form-proveedor" novalidate autocomplete="off">

                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Comercial</label>
                            <input type="text" name="nombre_comercial" class="form-control" placeholder="Ej: Distribuidora Central" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" placeholder="Ej: 5512345678" minlength="10" maxlength="10" pattern="[0-9]{10}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="2" placeholder="Dirección completa del proveedor" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Tipo de Pago</label>
                            <select name="tipo_pago" class="form-select" required>
                                <option value="" disabled selected>Seleccione</option>
                                <option value="Contado">Contado</option>
                                <option value="7 días">7 días</option>
                                <option value="15 días">15 días</option>
                                <option value="30 días">30 días</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label">Interés </label>
                            <select name="interes" class="form-select">
                                <option value="0">Selecciona el interes</option>
                                @for ($i = 0; $i <= 15; $i++)
                                    <option value="{{ $i }}">{{ $i }}%</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-save"></i> Guardar Proveedor
                            </button>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('proveedores.index') }}" class="btn btn-outline-secondary w-100">
                                Cancelar
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('form-proveedor').addEventListener('submit', function(e) {
    e.preventDefault();


    if (!this.checkValidity()) {
        this.classList.add('was-validated');

        Swal.fire({
            title: '¡Faltan campos!',
            text: 'Por favor, llena todos los campos obligatorios.',
            icon: 'error',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#198754'
        });
        return;
    }


    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-2",
            cancelButton: "btn btn-danger mx-2"
        },
        buttonsStyling: false
    });


    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro?",
        text: "¿Quieres registrar este proveedor?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, guardar",
        cancelButtonText: "No, cancelar",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {

            this.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "El proveedor no fue registrado.",
                icon: "error"
            });
        }
    });
});
</script>

@endsection
