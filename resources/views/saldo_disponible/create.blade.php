@extends('layouts.template')

@section('content')
<div class="main-container">

    <div class="header">
        <h1>Añadir Saldo a la Caja</h1>
        <p>Ingresa el monto que deseas cargar para las recargas telefónicas</p>
    </div>

    <div class="card-form">
        <form action="{{ route('saldo_disponible.store') }}" method="POST" id="form-recarga" novalidate autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="monto">Monto a depositar ($)</label>
                <div class="input-wrapper">
                    <span class="currency-symbol">$</span>
                    <input type="number" name="monto" id="monto" step="0.01" min="0.01" max="100000" placeholder="0.00" required autofocus>
                </div>
                @if($errors->has('monto'))
                    <span class="error-msg">{{ $errors->first('monto') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label>Método de Recarga</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="metodo_pago" value="transferencia" id="radio-transferencia" checked>
                        <span>Transferencia</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="metodo_pago" value="efectivo" id="radio-efectivo">
                        <span>Efectivo</span>
                    </label>
                </div>
            </div>

            <div id="seccion-transferencia" class="seccion-dinamica">
                <div class="form-group">
                    <label for="cuenta_empresa_tx">Cuenta de la Empresa (Destino)</label>
                    <select name="cuenta_empresa_tx" id="cuenta_empresa_tx" class="form-control-custom">
                        <option value="BBVA - Clabe: 0123 4567 8901 2345 67">BBVA (Principal)</option>
                        <option value="Banamex - Clabe: 0021 8070 1023 4567 89">Citibanamex (Secundaria)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="banco_cliente">Banco Emisor (Tu Banco)</label>
                    <input type="text" name="banco_cliente" id="banco_cliente" class="form-control-custom" placeholder="Ej. Santander, Banorte" maxlength="50" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+">
                </div>
                <div class="form-group">
                    <label for="cuenta_cliente">Número de CLABE (Desde la que envías)</label>
                    <input type="text" name="cuenta_cliente" id="cuenta_cliente" class="form-control-custom" placeholder="Exactamente 18 dígitos numéricos" maxlength="18" minlength="18" pattern="\d{18}">
                </div>
                <div class="form-group">
                    <label for="referencia_tx">Folio</label>
                    <input type="text" name="referencia_tx" id="referencia_tx" class="form-control-custom" placeholder="Exactamente 7 dígitos" maxlength="7" minlength="7" pattern="\d{7}">
                </div>
            </div>

            <div id="seccion-efectivo" class="seccion-dinamica d-none">
                <div class="form-group">
                    <label for="cuenta_empresa_ef">Cuenta de la Empresa (Destino)</label>
                    <select name="cuenta_empresa_ef" id="cuenta_empresa_ef" class="form-control-custom">
                        <option value="OXXO - Tarjeta: 4766 8412 3456 7890">OXXO (Saldo BBVA)</option>
                        <option value="Ventanilla BBVA - Cuenta: 0123456789">Ventanilla de Banco Azteca </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="referencia_ef">Folio del Ticket / Comprobante</label>
                    <input type="text" name="referencia_ef" id="referencia_ef" class="form-control-custom" placeholder="Exactamente 7 dígitos" maxlength="7" minlength="7" pattern="\d{7}">
                </div>
                <div class="info-box">
                    <strong>Nota:</strong> Conserva el ticket en físico por cualquier aclaración con el corte de caja.
                </div>
            </div>

            <div class="button-stack">
                <button type="submit" class="btn btn-green">Confirmar Depósito</button>
                <a href="{{ route('saldo_disponible.index') }}" id="btn-cancelar" class="btn btn-orange">Cancelar y Volver</a>
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

    .card-form {
        background: white;
        max-width: 480px;
        margin: 0 auto 50px auto;
        padding: 40px;
        border-radius: 25px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        border: 1px solid #edf2f7;
    }

    .form-group {
        text-align: left;
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        color: #2d3748;
        font-weight: bold;
        font-size: 1.05rem;
        margin-bottom: 10px;
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
        padding: 15px 15px 15px 50px;
        font-size: 2rem;
        font-weight: 600;
        border: 2px solid #e2e8f0;
        border-radius: 15px;
        outline: none;
        transition: border-color 0.3s;
        color: #1a202c;
    }
    .input-wrapper input:focus, .form-control-custom:focus {
        border-color: #1e6aff;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 5px;
    }
    .radio-label {
        display: flex !important;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-weight: 500 !important;
        font-size: 1.1rem !important;
    }
    .radio-label input {
        width: 18px;
        height: 18px;
        accent-color: #15803d;
    }

    .form-control-custom {
        width: 100%;
        padding: 12px 15px;
        font-size: 1.05rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        outline: none;
        box-sizing: border-box;
        color: #1a202c;
        transition: border-color 0.3s;
    }

    .info-box {
        background-color: #f0f4f8;
        border-left: 4px solid #1e6aff;
        padding: 12px;
        border-radius: 6px;
        font-size: 0.95rem;
        color: #4a5568;
        margin-bottom: 25px;
        text-align: left;
    }

    .d-none { display: none !important; }

    .button-stack {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        display: block;
        padding: 16px;
        border-radius: 12px;
        text-decoration: none;
        color: white !important;
        font-weight: bold;
        font-size: 1.25rem;
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

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const rTransferencia = document.getElementById('radio-transferencia');
    const rEfectivo = document.getElementById('radio-efectivo');
    const secTransferencia = document.getElementById('seccion-transferencia');
    const secEfectivo = document.getElementById('seccion-efectivo');

    const inputsTx = secTransferencia.querySelectorAll('input');
    const inputsEf = secEfectivo.querySelectorAll('input');

    // Forzar numéricos en CLABE y Folios
    document.getElementById('cuenta_cliente').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
    document.getElementById('referencia_tx').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
    document.getElementById('referencia_ef').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    function alternarFormulario() {
        if (rTransferencia.checked) {
            secTransferencia.classList.remove('d-none');
            secEfectivo.classList.add('d-none');
            inputsTx.forEach(i => i.required = true);
            inputsEf.forEach(i => i.required = false);
        } else {
            secEfectivo.classList.remove('d-none');
            secTransferencia.classList.add('d-none');
            inputsEf.forEach(i => i.required = true);
            inputsTx.forEach(i => i.required = false);
        }
    }

    rTransferencia.addEventListener('change', alternarFormulario);
    rEfectivo.addEventListener('change', alternarFormulario);

    alternarFormulario();

    document.getElementById('form-recarga').addEventListener('submit', function(e) {
        e.preventDefault();

        const monto = document.getElementById('monto').value;
        if (!monto || monto <= 0) {
            Swal.fire({ title: 'Monto inválido', text: 'Por favor ingresa un monto válido mayor a 0.', icon: 'error', confirmButtonColor: '#15803d' });
            return;
        }

        if (rTransferencia.checked) {
            const banco = document.getElementById('banco_cliente').value.trim();
            const clabe = document.getElementById('cuenta_cliente').value.trim();
            const refTx = document.getElementById('referencia_tx').value.trim();

            if (!banco || !clabe || !refTx) {
                Swal.fire({ title: 'Campos vacíos', text: 'Por favor rellena todos los datos de la transferencia.', icon: 'error', confirmButtonColor: '#15803d' });
                return;
            }

            if (clabe.length !== 18) {
                Swal.fire({ title: 'CLABE inválida', text: 'La cuenta CLABE debe tener exactamente 18 dígitos numéricos.', icon: 'error', confirmButtonColor: '#15803d' });
                return;
            }

            if (refTx.length !== 7) {
                Swal.fire({ title: 'Folio inválido', text: 'El folio debe tener exactamente 7 dígitos.', icon: 'error', confirmButtonColor: '#15803d' });
                return;
            }
        } else {
            const refEf = document.getElementById('referencia_ef').value.trim();

            if (!refEf) {
                Swal.fire({ title: 'Campos vacíos', text: 'Por favor ingresa el folio del comprobante.', icon: 'error', confirmButtonColor: '#15803d' });
                return;
            }

            if (refEf.length !== 7) {
                Swal.fire({ title: 'Folio inválido', text: 'El folio debe tener exactamente 7 dígitos.', icon: 'error', confirmButtonColor: '#15803d' });
                return;
            }
        }

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: { confirmButton: "btn btn-green mx-2 px-4", cancelButton: "btn btn-orange mx-2 px-4" },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: '¿Confirmar depósito?',
            text: `Se enviarán los datos para abonar $${parseFloat(monto).toFixed(2)} al sistema.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: '¡Depósito Exitoso!',
                    text: `Se han abonado $${parseFloat(monto).toFixed(2)} al saldo disponible de la caja.`,
                    icon: 'success',
                    confirmButtonColor: '#15803d'
                }).then(() => {
                    this.submit();
                });
            }
        });
    });

    document.getElementById('btn-cancelar').addEventListener('click', function(e) {
        e.preventDefault();
        const urlDestino = this.getAttribute('href');

        Swal.fire({
            title: '¿Cancelar operación?',
            text: 'Se perderán los datos que capturaste en el formulario.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'No, quedarme',
            confirmButtonColor: '#ff7a00',
            cancelButtonColor: '#15803d',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlDestino;
            }
        });
    });
</script>
@endsection
