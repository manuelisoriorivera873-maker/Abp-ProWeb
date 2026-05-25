@extends('layouts.template')

@section('content')
<div class="container-fluid">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Pago para Proveedores</h1>
        <p class="text-muted">Registre el pago realizado a un proveedor</p>
    </div>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 800px; border-radius: 15px;">
        <form action="{{ route('pagos_proveedores.store') }}" method="POST" id="formPago">
            @csrf
            
            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Fecha del Pago</label>
                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Proveedor</label>
                <select name="id_proveedor" id="id_proveedor" class="form-select" required>
                    <option value="" selected disabled>Seleccione un proveedor</option>
                    @foreach($proveedores as $p)
                        <option value="{{ $p->id_proveedor }}">{{ $p->nombre_comercial }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4 text-start">
                <label class="form-label fw-bold">Monto del Pago Total</label>
                <input type="number" step="0.01" name="monto" id="monto" class="form-control" placeholder="0.00" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label fw-bold">Método de Pago</label>
                <select name="metodo_pago" id="metodo_pago" class="form-select" required onchange="evaluarMetodoPago()">
                    <option value="" selected disabled>Seleccione método de pago</option>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Crédito">Crédito</option>
                </select>
            </div>

            {{-- SECCIÓN DINÁMICA: TRANSFERENCIA (Oculta por defecto) --}}
            <div id="seccionTransferencia" class="p-3 mb-3 bg-light rounded border border-info text-start" style="display: none;">
                <h5 class="text-info fw-bold mb-2"><i class="fas fa-university"></i> Datos de Transferencia</h5>
                <label class="form-label fw-bold">Número de Cuenta de cargo</label>
                <input type="text" name="numero_cuenta" id="numero_cuenta" class="form-control" placeholder="Ingrese los 16 o 18 dígitos de la cuenta">
            </div>

            {{-- SECCIÓN DINÁMICA: CRÉDITO (Oculta por defecto) --}}
            <div id="seccionCredito" class="p-3 mb-3 bg-light rounded border border-warning text-start" style="display: none;">
                <h5 class="text-warning fw-bold mb-3"><i class="fas fa-credit-card"></i> Planificación de Crédito</h5>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold">Número de Pagos (Parcialidades)</label>
                        <input type="number" name="numero_pagos" id="numero_pagos" class="form-control" placeholder="Ej. 4" min="1" oninput="calcularCuotas()">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold">Monto por Pago ($)</label>
                        <input type="number" step="0.01" name="monto_por_pago" id="monto_por_pago" class="form-control" placeholder="0.00" min="0" oninput="calcularCuotas()">
                    </div>
                </div>
                <div class="mt-2 text-end">
                    <small id="infoCredito" class="fw-bold text-muted">Suma acumulada: $0.00 / Esperado: $0.00</small>
                </div>
            </div>

            <div class="row g-2 justify-content-center mt-4">
                <div class="col-md-4">
                    <button type="button" class="btn btn-success w-100 fw-bold py-2" style="background-color: #198754;" onclick="confirmarPago()">
                        Pagar
                    </button>
                </div>
                <div class="col-md-4"><button type="reset" class="btn btn-warning text-white w-100 fw-bold py-2" style="background-color: #ff7b00;" onclick="resetearFormulario()">Limpiar</button></div>
                <div class="col-md-4"><a href="{{ route('pagos_proveedores.index') }}" class="btn btn-secondary w-100 fw-bold py-2" style="background-color: #6c757d;">Regresar</a></div>
            </div>
        </form>
    </div>
</div>

<script>
// Maneja qué campos se muestran según el método seleccionado
function evaluarMetodoPago() {
    const metodo = document.getElementById('metodo_pago').value;
    const seccionTrans = document.getElementById('seccionTransferencia');
    const seccionCred = document.getElementById('seccionCredito');
    
    // Reseteamos valores y ocultamos secciones por seguridad antes de evaluar
    seccionTrans.style.display = "none";
    seccionCred.style.display = "none";
    document.getElementById('numero_cuenta').required = false;
    document.getElementById('numero_pagos').required = false;
    document.getElementById('monto_por_pago').required = false;

    if (metodo === "Transferencia") {
        seccionTrans.style.display = "block";
        document.getElementById('numero_cuenta').required = true;
    } else if (metodo === "Crédito") {
        seccionCred.style.display = "block";
        document.getElementById('numero_pagos').required = true;
        document.getElementById('monto_por_pago').required = true;
        calcularCuotas();
    }
}

// Calcula en tiempo real cuánto suman las parcialidades del crédito
function calcularCuotas() {
    const montoTotal = parseFloat(document.getElementById('monto').value) || 0;
    const numPagos = parseInt(document.getElementById('numero_pagos').value) || 0;
    const montoPago = parseFloat(document.getElementById('monto_por_pago').value) || 0;
    const infoCredito = document.getElementById('infoCredito');

    const totalAcumulado = numPagos * montoPago;

    if (montoTotal === 0) {
        infoCredito.innerHTML = "Por favor ingresa primero el Monto del Pago Total arriba.";
        infoCredito.className = "fw-bold text-danger";
        return;
    }

    if (totalAcumulado.toFixed(2) === montoTotal.toFixed(2)) {
        infoCredito.innerHTML = `¡Plan de pagos perfecto! Total: $${totalAcumulado.toFixed(2)} de $${montoTotal.toFixed(2)}`;
        infoCredito.className = "fw-bold text-success";
    } else {
        infoCredito.innerHTML = `Suma del plan: $${totalAcumulado.toFixed(2)} / Esperado: $${montoTotal.toFixed(2)}`;
        infoCredito.className = "fw-bold text-danger";
    }
}

function resetearFormulario() {
    document.getElementById('seccionTransferencia').style.display = "none";
    document.getElementById('seccionCredito').style.display = "none";
}

function confirmarPago() {
    const monto = document.getElementById('monto').value;
    const proveedorSelect = document.getElementById('id_proveedor');
    const proveedor = proveedorSelect.options[proveedorSelect.selectedIndex].text;
    const metodo = document.getElementById('metodo_pago').value;

    // 1. Validación de campos generales
    if (!monto || monto <= 0 || proveedorSelect.value === "" || metodo === "") {
        Swal.fire({
            title: "Datos incompletos",
            text: "Por favor, llena los campos requeridos (Proveedor, Monto y Método de Pago).",
            icon: "error",
            confirmButtonColor: "#6c757d"
        });
        return;
    }

    // 2. Validación específica para Transferencia
    if (metodo === "Transferencia") {
        const cuenta = document.getElementById('numero_cuenta').value.trim();
        if (cuenta === "") {
            Swal.fire({
                title: "Cuenta requerida",
                text: "Debes ingresar el número de cuenta de donde se descontará el dinero.",
                icon: "warning",
                confirmButtonColor: "#0dcaf0"
            });
            return;
        }
    }

    // 3. Validación específica para Crédito
    if (metodo === "Crédito") {
        const numPagos = parseInt(document.getElementById('numero_pagos').value) || 0;
        const montoPago = parseFloat(document.getElementById('monto_por_pago').value) || 0;
        const totalEsperado = parseFloat(monto);
        const totalAcumulado = numPagos * montoPago;

        if (numPagos <= 0 || montoPago <= 0) {
            Swal.fire({
                title: "Plan de pagos inválido",
                text: "El número de pagos y el monto por pago deben ser mayores a cero.",
                icon: "warning",
                confirmButtonColor: "#ffc107"
            });
            return;
        }

        // Verificamos matemáticamente que las cuotas cubran el monto total
        if (totalAcumulado.toFixed(2) !== totalEsperado.toFixed(2)) {
            Swal.fire({
                title: "Desajuste en los montos",
                text: `El plan de pagos suma $${totalAcumulado.toFixed(2)}, pero el monto total especificado es de $${totalEsperado.toFixed(2)}. ¡Ajusta los valores!`,
                icon: "error",
                confirmButtonColor: "#dc3545"
            });
            return;
        }
    }

    // Mixin personalizado para tus botones estilizados
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success mx-2",
            cancelButton: "btn btn-danger mx-2"
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: "¿Confirmar pago completado?",
        text: `¿Estás seguro de registrar este pago de $${monto} a ${proveedor} mediante ${metodo}?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, registrar pago",
        cancelButtonText: "No, revisar",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Mandamos una alerta de confirmación final antes de enviar
            Swal.fire({
                title: "¡Pago Completado!",
                text: "El registro ha sido procesado de forma exitosa.",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });

            // Retrasamos un segundo el submit para que el usuario alcance a ver el mensaje de éxito
            setTimeout(() => {
                document.getElementById('formPago').submit();
            }, 1500);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelado",
                text: "El pago no ha sido registrado.",
                icon: "error"
            });
        }
    });
}
</script>
@endsection