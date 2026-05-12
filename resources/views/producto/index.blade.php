@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold text-dark">Inventario de Productos</h1>
        <p class="text-muted">Gestión de existencias y precios de Tienda La Subidita</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="submit" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="input-group w-50">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Buscar por código, nombre o categoría...">
            </div>
            <a href="{{ route('productos.create') }}" class="btn btn-primary px-4 fw-bold shadow">
                <i class="fas fa-plus-circle me-1"></i> Nuevo Producto
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle text-center border">
                <thead class="table-dark text-uppercase fs-7">
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>P. Venta</th>
                        <th>Stock</th>
                        <th>Proveedor</th>
                        <th style="width: 220px;">Acciones</th> </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                    <tr>
                        <td class="fw-bold text-secondary">{{ $producto->codigo }}</td>
                        <td class="text-start">
                            <div class="fw-bold text-dark">{{ $producto->nombre }}</div>
                            <small class="text-muted">{{ Str::limit($producto->descripcion, 40) }}</small>
                        </td>
                        <td><span class="badge rounded-pill bg-light text-dark border">{{ $producto->categoria }}</span></td>
                        <td class="fw-bold text-success fs-5">${{ number_format($producto->precio_venta, 2) }}</td>
                        <td>
                            @if($producto->stock <= 5)
                                <span class="badge bg-danger shadow-sm w-100 py-2">CRÍTICO: {{ $producto->stock }}</span>
                            @elseif($producto->stock <= 15)
                                <span class="badge bg-warning text-dark shadow-sm w-100 py-2">BAJO: {{ $producto->stock }}</span>
                            @else
                                <span class="badge bg-success shadow-sm w-100 py-2">{{ $producto->stock }}</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $producto->proveedor->nombre_comercial ?? 'Sin proveedor' }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('productos.edit', $producto->id_producto) }}" 
                                   class="btn btn-primary btn-sm px-3 shadow-sm flex-grow-1" 
                                   title="Editar Producto">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>

                                <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" class="d-inline flex-grow-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm px-3 shadow-sm w-100" 
                                            title="Eliminar Producto"
                                            onclick="return confirm('¿Seguro que deseas eliminar el producto {{ $producto->nombre }}?')">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3 d-block opacity-50"></i>
                            No hay productos registrados en el inventario de Tienda La Subidita.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection