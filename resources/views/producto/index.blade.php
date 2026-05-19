@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-dark">Inventario de Productos</h1>
        <p class="text-muted">Gestión de existencias de Tienda La Subidita</p>
    </div>

    <div class="card shadow-sm border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group w-50">
                {{-- La lupa pone el foco en el input al hacer clic --}}
                <span class="input-group-text bg-white border-end-0" style="cursor: pointer;" onclick="document.getElementById('inputBusqueda').focus();">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" id="inputBusqueda" class="form-control border-start-0" placeholder="Buscar por código, nombre o categoría...">
            </div>
            <a href="{{ route('productos.create') }}" class="btn btn-primary px-4 fw-bold shadow">
                <i class="fas fa-plus-circle me-1"></i> Nuevo Producto
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center border" id="tablaProductos">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>P. Venta</th>
                        <th>Stock</th>
                        <th>Acciones</th> 
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                    <tr>
                        <td class="fw-bold text-secondary">{{ $producto->codigo }}</td>
                        <td class="text-start">
                            <div class="fw-bold text-dark">{{ $producto->nombre }}</div>
                        </td>
                        <td class="fw-bold text-success">${{ number_format($producto->precio_venta, 2) }}</td>
                        <td>
                            <span class="badge {{ $producto->stock <= 5 ? 'bg-danger' : ($producto->stock <= 15 ? 'bg-warning text-dark' : 'bg-success') }} p-2 w-75">
                                {{ $producto->stock }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                {{-- Botón Pedir Más --}}
                                <button type="button" 
                                        class="btn btn-primary btn-sm text-white shadow-sm" 
                                        onclick="abrirModalSumar({{ $producto->id_producto }}, '{{ $producto->nombre }}', {{ $producto->stock }})">
                                    <i class="fas fa-cart-plus"></i> Pedir más
                                </button>
                                
                                <a href="{{ route('productos.edit', $producto->id_producto) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" id="delete-form-{{ $producto->id_producto }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminar({{ $producto->id_producto }}, '{{ $producto->nombre }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr id="filaVacia">
                        <td colspan="5" class="text-center py-4 text-muted">No hay productos registrados en el inventario.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL PARA SUMAR STOCK --}}
<div class="modal fade" id="modalSumar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="tituloModal">Sumar Stock</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSumarStock" method="POST">
                @csrf
                <div class="modal-body">
                    <p id="infoProducto" class="fw-bold"></p>
                    <div class="mb-3">
                        <label class="form-label">Cantidad a ingresar:</label>
                        <input type="number" name="cantidad" class="form-control" min="1" required>
                        <small class="text-muted">Esta cantidad se sumará al inventario actual.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white">Aumentar Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// 1. BUSCADOR EN TIEMPO REAL
document.getElementById('inputBusqueda').addEventListener('keyup', function() {
    let filtro = this.value.toLowerCase().trim();
    let filas = document.querySelectorAll('#tablaProductos tbody tr');
    
    filas.forEach(fila => {
        if (fila.id === 'filaVacia') return;
        let texto = fila.innerText.toLowerCase();
        fila.style.display = texto.includes(filtro) ? '' : 'none';
    });
});

// 2. FUNCIÓN PARA ABRIR MODAL
function abrirModalSumar(id, nombre, actual) {
    const form = document.getElementById('formSumarStock');
    form.action = "/productos/" + id + "/sumar";
    
    document.getElementById('infoProducto').innerText = "Producto: " + nombre + " (Actual: " + actual + ")";
    
    let modalElement = document.getElementById('modalSumar');
    let miModal = bootstrap.Modal.getOrCreateInstance(modalElement);
    miModal.show();
}

// 3. CONFIRMACIÓN ELIMINAR
function confirmarEliminar(id, nombre) {
    Swal.fire({
        title: "¿Borrar " + nombre + "?",
        text: "Esta acción es irreversible.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, borrar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection