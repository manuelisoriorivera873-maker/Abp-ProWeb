@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Editar Recarga</h1>
        <p class="text-muted">Corrija la información de la transacción #{{ $recarga->id_recarga }}</p>
    </div>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">
        <form action="{{ route('recargas_telefonicas.update', $recarga->id_recarga) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Fecha de la Recarga</label>
                <input type="date" name="fecha" class="form-control" value="{{ $recarga->fecha }}" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Número Celular (10 dígitos)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                    <input type="tel" name="numero_telefono" class="form-control form-control-lg" 
                           value="{{ $recarga->numero_telefono }}" pattern="[0-9]{10}" maxlength="10" required>
                </div>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Compañía</label>
                <select name="compania" class="form-select form-select-lg" required>
                    <option value="Telcel" {{ $recarga->compania == 'Telcel' ? 'selected' : '' }}>Telcel</option>
                    <option value="Movistar" {{ $recarga->compania == 'Movistar' ? 'selected' : '' }}>Movistar</option>
                    <option value="AT&T" {{ $recarga->compania == 'AT&T' ? 'selected' : '' }}>AT&T</option>
                    <option value="Bait" {{ $recarga->compania == 'Bait' ? 'selected' : '' }}>Bait</option>
                    <option value="Virgin Mobile" {{ $recarga->compania == 'Virgin Mobile' ? 'selected' : '' }}>Virgin Mobile</option>
                </select>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label fw-bold">Monto de la Recarga</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <select name="monto" class="form-select form-select-lg" required>
                        @foreach([10, 20, 30, 50, 100, 150, 200, 500] as $m)
                            <option value="{{ $m }}" {{ $recarga->monto == $m ? 'selected' : '' }}>${{ number_format($m, 2) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row g-2 justify-content-center border-top pt-4">
                <div class="col-md-5">
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm">
                        <i class="fas fa-save me-2"></i> Actualizar Recarga
                    </button>
                </div>
                <div class="col-md-5">
                    <a href="{{ route('recargas_telefonicas.index') }}" class="btn btn-warning btn-lg text-white w-100 fw-bold shadow-sm" style="background-color: #ff7b00;">
                        <i class="fas fa-times-circle me-2"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection