@extends('layouts.template')

@section('content')
<div class="container-fluid text-center">
    <h1 class="display-5 fw-bold">Historial de Pagos</h1>
    <p class="lead text-muted">Consulta los pagos realizados a proveedores de Tienda La Subidita</p>

    <div class="card shadow-sm border-0 p-4 mt-4">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('pagos_proveedores.create') }}" class="btn btn-primary fw-bold px-4">
                <i class="fas fa-plus"></i> Nuevo Pago
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr>
                        <td>#{{ $pago->id_pago }}</td>
                        <td>{{ \Carbon\Carbon::parse($pago->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $pago->proveedor->nombre_comercial ?? 'N/A' }}</td>
                        <td class="fw-bold text-success">${{ number_format($pago->monto, 2) }}</td>
                        <td><span class="badge bg-info text-dark">{{ $pago->metodo_pago }}</span></td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('pagos_proveedores.show', $pago->id_pago) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                
                                {{-- Formulario oculto para eliminar --}}
                                <form action="{{ route('pagos_proveedores.destroy', $pago->id_pago) }}" method="POST" id="delete-form-{{ $pago->id_pago }}" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                {{-- Botón que activa el SweetAlert --}}
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmarEliminacion({{ $pago->id_pago }}, '{{ $pago->proveedor->nombre_comercial ?? 'este pago' }}', '{{ $pago->monto }}')">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmarEliminacion(id, proveedor, monto) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-2",
            cancelButton: "btn btn-danger mx-2"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Estás seguro?",
        text: "Vas a eliminar el registro de pago por $" + monto + " a " + proveedor + ". ¡Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Enviamos el formulario correspondiente
            document.getElementById('delete-form-' + id).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "El registro de pago está a salvo :)",
                icon: "error"
            });
        }
    });
}
</script>
@endsection