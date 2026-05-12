@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Nueva Venta - La Subidita</h1>
        <a href="{{ route('ventas.index') }}" class="btn btn-outline-primary fw-bold">Historial</a>
    </div>

    <div class="card shadow-sm border-0 p-4">
        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="fw-bold">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="fw-bold">Hora</label>
                    <input type="time" name="hora" class="form-control" value="{{ date('H:i') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="fw-bold">Tipo</label>
                    <select name="tipo_venta" class="form-select">
                        <option value="Contado">Contado</option>
                        <option value="Crédito">Crédito</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Escanear o Buscar Producto</label>
                <input type="text" id="buscar_producto" list="lista_productos_db" class="form-control form-control-lg" placeholder="Código o nombre..." autocomplete="off">
                <datalist id="lista_productos_db">
                    @foreach($productos as $p)
                        <option value="{{ $p->codigo }}" data-precio="{{ $p->precio_venta }}" data-nombre="{{ $p->nombre }}">
                            {{ $p->nombre }} - ${{ $p->precio_venta }}
                        </option>
                    @endforeach
                </datalist>
            </div>

            <input type="hidden" id="cantidad" value="1">

            <div class="table-responsive mb-4">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th>Precio</th>
                            <th>Subtotal</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_items"></tbody>
                </table>
            </div>

            <div class="bg-primary text-white p-3 rounded mb-4 d-flex justify-content-between">
                <h4 class="mb-0">Total:</h4>
                <h3 class="mb-0">$<span id="total_label">0.00</span></h3>
                <input type="hidden" name="total" id="input_total" value="0">
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">FINALIZAR VENTA</button>
        </form>
    </div>
</div>

<script>
    let totalVenta = 0;

    document.getElementById('buscar_producto').addEventListener('input', function(e) {
        const val = e.target.value;
        const opts = document.getElementById('lista_productos_db').options;
        for (let i = 0; i < opts.length; i++) {
            if (opts[i].value === val) {
                agregarProducto(opts[i]);
                e.target.value = "";
                break;
            }
        }
    });

    function agregarProducto(opt) {
        const codigo = opt.value;
        const nombre = opt.getAttribute('data-nombre');
        const precio = parseFloat(opt.getAttribute('data-precio'));
        const tabla = document.getElementById('tabla_items');

        let filaExistente = document.querySelector(`input[value="${codigo}"]`);

        if (filaExistente) {
            let fila = filaExistente.closest('tr');
            let inputCant = fila.querySelector('.input-cant');
            inputCant.value = parseInt(inputCant.value) + 1;
            actualizarFila(fila, precio);
        } else {
            const row = tabla.insertRow();
            row.innerHTML = `
                <td>${codigo} <input type="hidden" name="codigo_producto[]" value="${codigo}"></td>
                <td>${nombre}</td>
                <td class="text-center">
                    <input type="number" name="cantidad[]" value="1" class="form-control form-control-sm input-cant" style="width:70px" onchange="recalcularTodo()">
                </td>
                <td>$${precio.toFixed(2)} <input type="hidden" name="precio_unitario[]" value="${precio}"></td>
                <td class="fw-bold subtotal">$${precio.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); recalcularTodo();">X</button></td>
            `;
        }
        recalcularTodo();
    }

    function actualizarFila(fila, precio) {
        let cant = fila.querySelector('.input-cant').value;
        fila.querySelector('.subtotal').innerText = '$' + (cant * precio).toFixed(2);
    }

    function recalcularTodo() {
        totalVenta = 0;
        document.querySelectorAll('#tabla_items tr').forEach(fila => {
            let cant = fila.querySelector('.input-cant').value;
            let prec = fila.querySelector('input[name="precio_unitario[]"]').value;
            let sub = cant * prec;
            fila.querySelector('.subtotal').innerText = '$' + sub.toFixed(2);
            totalVenta += sub;
        });
        document.getElementById('total_label').innerText = totalVenta.toFixed(2);
        document.getElementById('input_total').value = totalVenta;
    }
</script>
@endsection