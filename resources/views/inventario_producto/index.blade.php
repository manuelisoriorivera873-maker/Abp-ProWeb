@extends('layouts.template')

@section('content')
<div class="container-fluid text-center">
    <h1 class="display-5 fw-bold">Inventario de Productos</h1>
    <p class="lead text-muted">Consulta y administra los productos disponibles en Tienda La Subidita</p>

    <div class="card shadow-sm border-0 p-4 mt-4" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle border-top">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" style="width: 250px;">Acciones</th>
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Cantidad Disponible</th>
                        <th>Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $item)
                    <tr>
                        <td class="text-start">
                            <div class="d-flex gap-1">
                                <a href="{{ route('inventarios_productos.edit', $item->id_producto) }}" 
                                   class="btn btn-sm btn-warning text-white fw-bold shadow-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                
                                <form action="{{ route('inventarios_productos.destroy', $item->id_producto) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger fw-bold shadow-sm" 
                                            onclick="return confirm('¿Eliminar {{ $item->nombre }}?')">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>

                                <a href="{{ route('productos.show',$item->id_producto) }}" 
                                   class="btn btn-sm btn-primary fw-bold shadow-sm">
                                    <i class="fas fa-plus-circle"></i> Pedir más
                                </a>
                            </div>
                        </td>
                        <td class="text-muted">{{ str_pad($item->id_producto, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-bold text-dark text-start">{{ $item->nombre }}</td>
                        <td>${{ number_format($item->precio_compra, 2) }}</td>
                        <td>${{ number_format($item->precio_venta, 2) }}</td>
                        <td>
                            <span class="badge {{ $item->stock < 5 ? 'bg-danger' : 'bg-success' }} p-2 shadow-sm" style="min-width: 40px;">
                                {{ $item->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted small text-uppercase fw-bold">{{ $item->categoria }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <button class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="width: 250px;">
                <i class="fas fa-search me-2"></i> Buscar
            </button>
            <a href="{{ url('/inicio') }}" class="btn btn-warning text-white px-5 py-2 fw-bold shadow-sm" 
               style="width: 250px; background-color: #ff7b00;">
                <i class="fas fa-times me-2"></i> Cancelar
            </a>
        </div>
    </div>
</div>
@endsection