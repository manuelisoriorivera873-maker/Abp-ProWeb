@extends("layouts.template")

@section("content")
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Registro de Nuevo Producto</h4>
                <a href="{{ route('productos.index') }}" class="btn btn-light btn-sm shadow-sm">
                    <i class="fas fa-boxes"></i> Mostrar productos
                </a>
            </div>

            <div class="card-body p-5">
                <form action="{{ route('productos.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="codigo" class="form-label fw-bold">Código de Barras / SKU</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                <input type="text" id="codigo" name="codigo" class="form-control" value="{{ old('codigo')?old('codigo'):$producto->codigo??'' }}" placeholder="Escanee o digite el código" >
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre del Producto</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej: Jabón Líquido" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="categoria" class="form-label fw-bold">Categoría</label>
                            <input type="text" id="categoria" name="categoria" class="form-control" value="{{ old('categoria') }}" placeholder="Ej: Limpieza">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-bold">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="2" placeholder="Detalles adicionales del producto">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="precio_compra" class="form-label fw-bold">Precio Compra</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" id="precio_compra" name="precio_compra" class="form-control" value="{{ old('precio_compra') }}" >
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="precio_venta" class="form-label fw-bold">Precio Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" id="precio_venta" name="precio_venta" class="form-control" value="{{ old('precio_venta') }}" >
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="stock" class="form-label fw-bold">Stock Inicial</label>
                            <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock') }}" >
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="id_proveedor" class="form-label fw-bold">Proveedor</label>
                        <select id="id_proveedor" name="id_proveedor" class="form-select" >
                            <option value="" disabled selected>Seleccione el proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id_proveedor }}" {{ old('id_proveedor') == $proveedor->id_proveedor ? 'selected' : '' }}>
                                    {{ $proveedor->nombre_comercial }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                <i class="fas fa-save"></i> Guardar Producto
                            </button>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary w-100">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection