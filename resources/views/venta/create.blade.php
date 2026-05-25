@extends("layouts.template")

@section("content")
<div class="container-fluid">
    <h1 class="text-center fw-bold">Nueva Venta - La Subidita</h1>

    <form action="{{ route('ventas.store') }}" method="POST" id="form-venta">
        @csrf
        <div class="row mb-4">
            <div class="col-md-4"><label>Fecha</label><input type="text" class="form-control" value="{{ $fechaActual }}" readonly></div>
            <div class="col-md-4"><label>Hora</label><input type="text" class="form-control" id="hora-input" value="{{ $horaActual }}" readonly></div>
            <div class="col-md-4"><label>Tipo de pago</label>
                <select name="tipo_venta" class="form-select"><option value="Contado">Contado</option><option value="Credito">Crédito</option></select>
            </div>
        </div>

        <div class="mb-4">
            <input type="text" id="buscador" class="form-control" placeholder="Buscar producto...">
            <div id="lista-resultados" style="position:absolute; z-index:999; background:white; width:95%; border:1px solid #ccc;"></div>
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr><th>Código</th><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th><th>Acción</th></tr>
            </thead>
            <tbody id="tabla-body"></tbody>
        </table>

        <div class="text-end">
            <h3>Total: $<span id="total-general">0.00</span></h3>
            <input type="hidden" name="total" id="input-total">
            <button type="button" id="btn-finalizar" class="btn btn-success btn-lg">FINALIZAR VENTA</button>
        </div>
    </form>
</div>

<script>
    const productos = @json($productos);
    
    // Reloj en tiempo real del navegador
    setInterval(() => {
        document.getElementById('hora-input').value = new Date().toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit', hour12: true});
    }, 1000);

    function agregarFila(p) {
        // Uso de (p.codigo ?? '') para evitar mostrar "null"
        const codigo = p.codigo ?? '';
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td><input name="codigo_producto[]" value="${codigo}" class="form-control" readonly></td>
            <td>${p.nombre}</td>
            <td><input type="number" name="cantidad[]" value="1" class="form-control cantidad" oninput="calcular()"></td>
            <td><input name="precio_unitario[]" value="${p.precio_venta}" class="form-control precio" readonly></td>
            <td class="subtotal">${p.precio_venta}</td>
            <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove(); calcular()">X</button></td>
        `;
        document.getElementById('tabla-body').appendChild(tr);
        calcular();
    }

    // Lógica del buscador
    document.getElementById('buscador').onkeyup = function(e) {
        const val = this.value.toLowerCase();
        const lista = document.getElementById('lista-resultados');
        lista.innerHTML = '';
        productos.filter(p => p.nombre.toLowerCase().includes(val)).forEach(p => {
            const div = document.createElement('div');
            div.style.padding = '10px'; div.style.borderBottom = '1px solid #ccc'; div.style.cursor = 'pointer';
            div.innerHTML = `<strong>${p.codigo ?? ''}</strong> - ${p.nombre}`;
            div.onclick = () => { agregarFila(p); lista.innerHTML = ''; };
            lista.appendChild(div);
        });
    };

    function calcular() {
        let t = 0;
        document.querySelectorAll('#tabla-body tr').forEach(r => {
            let sub = r.querySelector('.cantidad').value * r.querySelector('.precio').value;
            r.querySelector('.subtotal').innerText = sub.toFixed(2);
            t += sub;
        });
        document.getElementById('total-general').innerText = t.toFixed(2);
        document.getElementById('input-total').value = t;
    }

    document.getElementById('btn-finalizar').onclick = () => document.getElementById('form-venta').submit();
</script>
@endsection