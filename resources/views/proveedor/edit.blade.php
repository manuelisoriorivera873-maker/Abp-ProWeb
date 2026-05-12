@extends("layouts.template")

@section("content")

<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-lg border-0">

            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Proveedor: {{ $proveedor->nombre_comercial }}</h4>
                <a href="{{ route('proveedores.index') }}" class="btn btn-dark btn-sm shadow-sm">
                    <i class="fas fa-arrow-left"></i> Volver a la lista
                </a>
            </div>

            <div class="card-body p-5">

                <form action="{{ route('proveedores.update', $proveedor->id_proveedor) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-success fw-bold">Nombre Comercial</label>
                            <input type="text" name="nombre_comercial" class="form-control" value="{{ $proveedor->nombre_comercial }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-success fw-bold">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="{{ $proveedor->telefono }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-success fw-bold">Dirección</label>
                        <textarea name="direccion" class="form-control" rows="2" required>{{ $proveedor->direccion }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label text-success fw-bold">Tipo de Pago</label>
                            <select name="tipo_pago" class="form-select" required>
                                <option value="Contado" {{ $proveedor->tipo_pago == 'Contado' ? 'selected' : '' }}>Contado</option>
                                <option value="7 días" {{ $proveedor->tipo_pago == '7 días' ? 'selected' : '' }}>7 días</option>
                                <option value="15 días" {{ $proveedor->tipo_pago == '15 días' ? 'selected' : '' }}>15 días</option>
                                <option value="30 días" {{ $proveedor->tipo_pago == '30 días' ? 'selected' : '' }}>30 días</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label text-success fw-bold">Interés (%)</label>
                            <select name="interes" class="form-select">
                                <option value="0" {{ $proveedor->interes == 0 ? 'selected' : '' }}>0%</option>
                                @for ($i = 1; $i <= 15; $i++)
                                    <option value="{{ $i }}" {{ $proveedor->interes == $i ? 'selected' : '' }}>
                                        {{ $i }}%
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-6">
                            <button type="submit" class="btn btn-success w-100 shadow-sm">
                                <i class="fas fa-sync-alt"></i> Actualizar Datos
                            </button>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('proveedores.index') }}" class="btn btn-outline-danger w-100">
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