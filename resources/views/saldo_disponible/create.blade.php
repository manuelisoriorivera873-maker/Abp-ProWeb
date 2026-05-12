@extends('layouts.template')

@section('content')
<div class="main-container">
    
    <div class="header">
        <h1>Añadir Saldo a la Caja</h1>
        <p>Ingresa el monto que deseas cargar para las recargas telefónicas</p>
    </div>

    <div class="card-form">
        <form action="{{ route('saldo_disponible.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="monto">Monto a depositar ($)</label>
                <div class="input-wrapper">
                    <span class="currency-symbol">$</span>
                    <input type="number" 
                           name="monto" 
                           id="monto" 
                           step="0.01" 
                           min="0.01" 
                           placeholder="0.00" 
                           required 
                           autofocus>
                </div>
                @if($errors->has('monto'))
                    <span class="error-msg">{{ $errors->first('monto') }}</span>
                @endif
            </div>

            <div class="button-stack">
                <button type="submit" class="btn btn-green">Confirmar Depósito</button>
                <a href="{{ route('saldo_disponible.index') }}" class="btn btn-orange">Cancelar y Volver</a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Estructura General */
    .main-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-align: center;
        padding-top: 50px;
        background-color: #f4f7f6;
        min-height: 100vh;
    }

    .header h1 { color: #1a202c; font-size: 2.5rem; margin-bottom: 8px; }
    .header p { color: #4a5568; font-size: 1.1rem; margin-bottom: 40px; }

    /* Tarjeta del Formulario */
    .card-form {
        background: white;
        max-width: 450px;
        margin: 0 auto;
        padding: 40px;
        border-radius: 25px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border: 1px solid #edf2f7;
    }

    /* Grupo de Input */
    .form-group {
        text-align: left;
        margin-bottom: 35px;
    }
    .form-group label {
        display: block;
        color: #2d3748;
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 12px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .currency-symbol {
        position: absolute;
        left: 20px;
        font-size: 1.8rem;
        font-weight: bold;
        color: #a0aec0;
    }

    .input-wrapper input {
        width: 100%;
        padding: 18px 18px 18px 50px;
        font-size: 2rem;
        font-weight: 600;
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        outline: none;
        transition: border-color 0.3s;
        color: #1a202c;
    }
    .input-wrapper input:focus {
        border-color: #1e6aff;
    }

    /* Botones */
    .button-stack {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .btn {
        display: block;
        padding: 18px;
        border-radius: 12px;
        text-decoration: none;
        color: white !important;
        font-weight: bold;
        font-size: 1.3rem;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        text-align: center;
    }
    
    .btn-green { background-color: #15803d; }
    .btn-green:hover { background-color: #166534; box-shadow: 0 4px 12px rgba(21, 128, 61, 0.3); }
    
    .btn-orange { background-color: #ff7a00; }
    .btn-orange:hover { background-color: #ea580c; box-shadow: 0 4px 12px rgba(255, 122, 0, 0.3); }

    .error-msg { color: #e53e3e; font-size: 0.9rem; margin-top: 8px; display: block; font-weight: 600; }

    /* Quitar flechas del input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection