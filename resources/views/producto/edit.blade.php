@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg border-0">

            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Producto: {{ $producto->nombre }}</h4>
                <a href="{{ route('productos.index') }}" class="btn btn-light btn-sm shadow-sm">
                    <i class="fas fa-arrow-left"></i> Volver al Inventario
                </a>
            </div>

            <div class="card-body p-5">

                <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="codigo" class="form-label fw-bold text-primary">Código de Barras / SKU</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                <input type="text" id="codigo" name="codigo" class="form-control" value="{{ $producto->codigo }}" required>
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="nombre" class="form-label fw-bold text-primary">Nombre del Producto</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="categoria" class="form-label fw-bold text-primary">Categoría</label>
                            <input type="text" id="categoria" name="categoria" class="form-control" value="{{ $producto->categoria }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold text-primary">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="2">{{ $producto->descripcion }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="precio_compra" class="form-label fw-bold text-primary">Precio Compra</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" id="precio_compra" name="precio_compra" class="form-control" value="{{ $producto->precio_compra }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="precio_venta" class="form-label fw-bold text-primary">Precio Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" id="precio_venta" name="precio_venta" class="form-control" value="{{ $producto->precio_venta }}" required>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label fw-bold text-primary">Stock</label>
                            <input type="number" id="stock" name="stock" class="form-control" value="{{ $producto->stock }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="id_proveedor" class="form-label fw-bold text-primary">Proveedor</label>
                        <select id="id_proveedor" name="id_proveedor" class="form-select" required>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id_proveedor }}" {{ $producto->id_proveedor == $prov->id_proveedor ? 'selected' : '' }}>
                                    {{ $prov->nombre_comercial }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mt-4">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                <i class="fas fa-sync-alt"></i> Actualizar Producto
                            </button>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('productos.index') }}" class="btn btn-outline-danger w-100">
                                Descartar Cambios
                            </a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

@endsection