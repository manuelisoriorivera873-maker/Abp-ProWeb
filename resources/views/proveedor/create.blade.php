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

                <form action="{{ route('proveedores.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Comercial</label>
                            <input type="text" name="nombre_comercial" class="form-control" placeholder="Ej: Distribuidora Central" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control" placeholder="Ej: 5512345678" required>
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
                            <label class="form-label">Interés (%)</label>
                            <select name="interes" class="form-select">
                                <option value="0">0%</option>
                                @for ($i = 1; $i <= 15; $i++)
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

@endsection