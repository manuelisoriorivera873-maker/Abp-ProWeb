@extends('layouts.template')

@section('content')
<div class="main-container">
    
    <div class="header">
        <h1>Saldo Disponible para Recargas</h1>
        <p>Consulta el saldo disponible para realizar recargas telefónicas</p>
    </div>

    <div class="card">
        <div class="balance-box">
            <span class="amount">${{ number_format($monto, 2) }}</span>
        </div>

        <div class="status-msg">
            @if($monto <= 0)
                <p class="red-text">● Saldo insuficiente para realizar recargas</p>
            @else
                <p class="green-text">● Saldo disponible</p>
            @endif
        </div>

        <div class="button-group">
            <a href="{{ route('saldo_disponible.create') }}" class="btn btn-green">Recargar Saldo</a>
            <a href="{{ url('/home') }}" class="btn btn-orange">Regresar</a>
        </div>
    </div>
</div>

<style>
    .main-container {
        font-family: Arial, sans-serif;
        text-align: center;
        padding-top: 50px;
        background-color: #f9f9f9;
        min-height: 100vh;
    }
    .header h1 { color: #333; font-size: 2.5rem; margin-bottom: 5px; }
    .header p { color: #666; font-size: 1.1rem; margin-bottom: 30px; }

    .card {
        background: white;
        max-width: 600px;
        margin: 0 auto;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    /* ESTILO DEL RECUADRO AZUL */
    .balance-box {
        background-color: #1e6aff;
        padding: 50px 20px;
        border-radius: 15px;
        margin-bottom: 30px;
    }
    .amount {
        color: white;
        font-size: 5rem;
        font-weight: bold;
    }

    .status-msg { margin-bottom: 30px; font-weight: bold; font-size: 1.2rem; }
    .red-text { color: #dc2626; }
    .green-text { color: #16a34a; }

    .button-group { display: flex; justify-content: center; gap: 20px; }
    
    .btn {
        padding: 15px 30px;
        border-radius: 10px;
        text-decoration: none;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        transition: 0.3s;
    }
    .btn-green { background-color: #15803d; }
    .btn-green:hover { background-color: #166534; }
    .btn-orange { background-color: #ff7a00; }
    .btn-orange:hover { background-color: #ea580c; }
</style>
@endsection