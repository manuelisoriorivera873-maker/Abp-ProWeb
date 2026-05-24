@extends('layouts.template')

@section('content')
<div class="container-fluid text-center" style="margin-top: 50px; min-height: 100vh;">
    <h1 class="display-5 fw-bold">Historial de Recargas</h1>
    <p class="lead text-muted">Registro de transacciones telefónicas realizadas en la tienda</p>

    <div class="card shadow-sm border-0 p-4 mt-4" style="border-radius: 15px; background: white;">
        <div class="d-flex justify-content-end mb-4">
            <a href="{{ route('recargas_telefonicas.create') }}" id="btn-nueva-recarga" class="btn btn-primary fw-bold px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i> Nueva Recarga
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Acciones</th>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Número</th>
                        <th>Compañía</th>
                        <th>Monto</th>
                        <th class="text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recargas as $r)
                    <tr>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('recargas_telefonicas.show', $r->id_recarga) }}" class="btn btn-sm btn-info text-white shadow-sm fw-bold btn-ver">
                                    Ver
                                </a>
                                <a href="{{ route('recargas_telefonicas.edit', $r->id_recarga) }}" class="btn btn-sm btn-warning text-white shadow-sm fw-bold btn-editar" style="background-color: #ffb100;">
                                    Editar
                                </a>
                                <form action="{{ route('recargas_telefonicas.destroy', $r->id_recarga) }}" method="POST" class="d-inline form-eliminar" data-folio="{{ str_pad($r->id_recarga, 4, '0', STR_PAD_LEFT) }}" data-numero="{{ $r->numero_telefono }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm fw-bold">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="text-muted small">#{{ str_pad($r->id_recarga, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->fecha)->format('d/m/Y') }}</td>
                        <td class="fw-bold">{{ $r->numero_telefono }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $r->compania }}</span>
                        </td>
                        <td class="fw-bold text-success">${{ number_format($r->monto, 2) }}</td>
                        <td class="text-center">
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i> Exitosa</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-2 px-3 fw-bold",
            cancelButton: "btn btn-danger mx-2 px-3 fw-bold"
        },
        buttonsStyling: false
    });

    document.getElementById('btn-nueva-recarga').addEventListener('click', function(e) {
        e.preventDefault();
        const urlDestino = this.getAttribute('href');

        swalWithBootstrapButtons.fire({
            title: '¿Nueva Recarga?',
            text: 'Te enviaremos al formulario para capturar la nueva recarga.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, ir',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlDestino;
            }
        });
    });

    document.querySelectorAll('.btn-ver').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const urlDestino = this.closest('.btn-ver').getAttribute('href');

            swalWithBootstrapButtons.fire({
                title: '¿Ver detalles?',
                text: 'Te redirigiremos a la pantalla del comprobante digital.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, ver',
                cancelButtonText: 'No, regresar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlDestino;
                }
            });
        });
    });

    document.querySelectorAll('.btn-editar').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const urlDestino = this.closest('.btn-editar').getAttribute('href');

            swalWithBootstrapButtons.fire({
                title: '¿Editar Registro?',
                text: '¿Quieres modificar los datos de esta transacción?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, editar',
                cancelButtonText: 'No, regresar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = urlDestino;
                }
            });
        });
    });

    document.querySelectorAll('.form-eliminar').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const folio = this.getAttribute('data-folio');
            const numero = this.getAttribute('data-numero');

            swalWithBootstrapButtons.fire({
                title: `¿Eliminar recarga ${folio}?`,
                text: `Se borrará el registro del número ${numero}. ¡Esta acción no se puede deshacer!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No, mantener',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire({
                        title: 'Cancelado',
                        text: 'El registro de la recarga sigue intacto.',
                        icon: 'error',
                        confirmButtonColor: '#198754'
                    });
                }
            });
        });
    });
</script>
@endsection
