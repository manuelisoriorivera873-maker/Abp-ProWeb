@extends("layouts.template")

@section("content")
<div class="container-fluid">

    <div class="text-center mb-4">
        <h1 class="fw-bold">Historial de Ventas</h1>
        <p class="text-muted">Consulta las transacciones realizadas en Tienda La Subidita</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('ventas.index') }}" method="GET" class="card shadow-sm p-4 mb-4">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label class="fw-bold">Buscar por:</label>
                <select name="tipo_busqueda" id="tipo_busqueda" class="form-select form-select-lg">
                    <option value="id_venta" {{ request('tipo_busqueda') == 'id_venta' ? 'selected' : '' }}>ID de Venta</option>
                    <option value="fecha" {{ request('tipo_busqueda') == 'fecha' ? 'selected' : '' }}>Fecha</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Ingresa el valor:</label>
                <input 
                    type="text" 
                    name="valor" 
                    id="valor" 
                    class="form-control form-control-lg" 
                    list="lista_valores" 
                    value="{{ request('valor') }}"
                    placeholder="Busca el valor" 
                    required
                >
                <datalist id="lista_valores"></datalist>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-lg w-100">
                    <i class="fas fa-search"></i> Filtrar
                </button>
            </div>
        </div>
    </form>

    <div class="mb-3">
        <a href="{{ route('ventas.index') }}" class="btn btn-dark">Ver Todo el Historial</a>
        <a href="{{ route('ventas.create') }}" class="btn btn-success">Nueva Venta</a>
    </div>

    <div class="card shadow-sm p-3">
        <table class="table table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha y Hora</th>
                    <th>Tipo de Venta</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td class="fw-bold">#{{ $venta->id_venta }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }} {{ \Carbon\Carbon::parse($venta->hora)->format('h:i A') }}</td>
                    <td><span class="badge bg-info">{{ $venta->tipo_venta }}</span></td>
                    <td class="text-success fw-bold">${{ number_format($venta->total, 2) }}</td>
                    <td>
                        <a href="{{ route('ventas.show', $venta->id_venta) }}" class="btn btn-primary btn-sm">Ver Ticket</a>
                        <form id="form-{{ $venta->id_venta }}" action="{{ route('ventas.destroy', $venta->id_venta) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmarAnular({{ $venta->id_venta }})">Anular</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const todasLasVentas = @json($ventas);
    const tipoSelect = document.getElementById('tipo_busqueda');
    const dataList = document.getElementById('lista_valores');

    function cargarLista() {
        dataList.innerHTML = "";
        if (tipoSelect.value === "id_venta") {
            todasLasVentas.forEach(v => {
                let op = document.createElement("option");
                op.value = v.id_venta;
                dataList.appendChild(op);
            });
        } else {
            const fechas = [...new Set(todasLasVentas.map(v => v.fecha))];
            fechas.forEach(f => {
                let op = document.createElement("option");
                op.value = f;
                dataList.appendChild(op);
            });
        }
    }

    tipoSelect.addEventListener('change', cargarLista);
    window.onload = cargarLista;

    function confirmarAnular(id) {
        Swal.fire({
            title: '¿Estás segura?',
            text: "La venta #" + id + " será anulada y el stock se devolverá.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, anular',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-' + id).submit();
            }
        });
    }
</script>
@endsection