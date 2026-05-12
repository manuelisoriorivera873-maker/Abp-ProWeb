@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold">Editar Producto</h1>
            <p class="text-muted">Modifique la información del producto en Inventario de Productos</p>
        </div>
        <a href="{{ route('inventarios_productos.index') }}" class="btn btn-outline-secondary fw-bold px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Volver al Inventario
        </a>
    </div>

    <div class="card shadow-sm border-0 p-4" style="border-radius: 15px;">
        <form action="{{ route('inventarios_productos.update', $producto->id_producto) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold text-primary">ID de Venta (No editable)</label>
                    <input type="text" class="form-control form-control-lg bg-light" 
                           value="#{{ str_pad($producto->id_producto, 3, '0', STR_PAD_LEFT) }}" readonly>
                </div>
                <div class="col-md-9">
                    <label class="form-label fw-bold text-primary">Nombre del Producto</label>
                    <div class="input-group input-group-lg shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-tag text-muted"></i></span>
                        <input type="text" name="nombre" class="form-control border-start-0" 
                               placeholder="Ej: Pepino Extra" value="{{ $producto->nombre }}" required>
                    </div>
                </div>
            </div>

            <hr class="text-muted mb-4">

            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label fw-bold text-success">Precio Compra ($)</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white"><i class="fas fa-dollar-sign text-success"></i></span>
                        <input type="number" name="precio_compra" class="form-control" 
                               step="0.01" placeholder="0.00" value="{{ $producto->precio_compra }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-success">Precio Venta ($)</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white"><i class="fas fa-hand-holding-usd text-success"></i></span>
                        <input type="number" name="precio_venta" class="form-control" 
                               step="0.01" placeholder="0.00" value="{{ $producto->precio_venta }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold text-danger">Cantidad Disponible</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white"><i class="fas fa-box text-danger"></i></span>
                        <input type="number" name="stock" class="form-control" 
                               placeholder="0" value="{{ $producto->stock }}" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Categoría</label>
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white"><i class="fas fa-folder text-muted"></i></span>
                        <input type="text" name="categoria" class="form-control" 
                               placeholder="Ej: Verduras" value="{{ $producto->categoria }}" required>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center border-top pt-4">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow">
                        <i class="fas fa-save me-2"></i> Guardar Cambios
                    </button>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('inventarios_productos.index') }}" class="btn btn-warning btn-lg text-white w-100 fw-bold shadow" 
                       style="background-color: #ff7b00;">
                        <i class="fas fa-times-circle me-2"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection