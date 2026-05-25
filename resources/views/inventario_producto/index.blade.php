@extends('layouts.template')

@section('content')
<div class="container-fluid text-center">
    <h1 class="display-5 fw-bold">Inventario de Productos</h1>
    <p class="lead text-muted">Consulta y administra los productos disponibles en Tienda La Subidita</p>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 fw-bold small text-success bg-success bg-opacity-10 py-3">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm border-0 p-4 mt-4" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle border-top">
                <thead class="table-light">
                    <tr>
                        <th class="text-start" style="width: 250px;">Acciones</th>
                        <th>Código</th>
                        <th>Nombre del Producto</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Cantidad Disponible</th>
                        <th>Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $item)
                    <tr>
                        <td class="text-start">
                            <div class="d-flex gap-1">
                                <a href="{{ route('inventarios_productos.edit', $item->id_producto) }}" 
                                   class="btn btn-sm btn-warning text-white fw-bold shadow-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                
                                <form action="{{ route('inventarios_productos.destroy', $item->id_producto) }}" method="POST" class="d-inline form-eliminar-producto m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger fw-bold shadow-sm btn-trigger-delete" data-nombre="{{ $item->nombre }}">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>

                                <button type="button" 
                                        class="btn btn-sm btn-primary fw-bold shadow-sm btn-pedir-mas"
                                        data-id="{{ $item->id_producto }}"
                                        data-nombre="{{ $item->nombre }}"
                                        data-stock="{{ $item->stock }}">
                                    <i class="fas fa-plus-circle"></i> Pedir más
                                </button>
                            </div>
                        </td>
                        <td class="text-muted">{{ str_pad($item->id_producto, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="fw-bold text-dark text-start">{{ $item->nombre }}</td>
                        <td>${{ number_format($item->precio_compra, 2) }}</td>
                        <td>${{ number_format($item->precio_venta, 2) }}</td>
                        <td>
                            <span class="badge {{ $item->stock < 5 ? 'bg-danger' : 'bg-success' }} p-2 shadow-sm" style="min-width: 40px;">
                                {{ $item->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted small text-uppercase fw-bold">{{ $item->categoria }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center gap-3 mt-4">
           
            <a href="{{ url('/inicio') }}" class="btn btn-warning text-white px-5 py-2 fw-bold shadow-sm" 
               style="width: 250px; background-color: #ff7b00;">
                <i class="fas fa-times me-2"></i> Cancelar
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. VENTANA EMERGENTE QUE CAPTURA LA CANTIDAD NUEVA Y SE SUMA EN TU CONTROLADOR (CORREGIDO ERROR 404)
    document.querySelectorAll('.btn-pedir-mas').forEach(function(boton) {
        boton.addEventListener('click', function() {
            const idProducto = this.getAttribute('data-id');
            const nombreProducto = this.getAttribute('data-nombre');
            const stockActual = parseInt(this.getAttribute('data-stock'));

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-4 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-4 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Abastecer Producto',
                html: `<div class="text-start mb-3" style="font-size: 14px;">
                        <p class="mb-1"><strong>Producto:</strong> ${nombreProducto}</p>
                        <p class="text-muted"><strong>Existencia actual:</strong> ${stockActual} unidades</p>
                       </div>`,
                icon: 'question',
                input: 'number',
                inputAttributes: {
                    min: 1,
                    step: 1,
                    placeholder: 'Ingresa la cantidad a añadir...'
                },
                inputValue: '',
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-plus me-1"></i> Añadir al Inventario',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
                inputValidator: (value) => {
                    if (!value || parseInt(value) <= 0) {
                        return '¡Debes ingresar una cantidad válida mayor a 0!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const cantidadNueva = parseInt(result.value);
                    
                    const form = document.createElement('form');
                    form.method = 'POST';
                    
                    // CORRECCIÓN CLAVE: Usamos el helper route() de Laravel mapeando dinámicamente el ID del botón
                    form.action = "{{ route('inventarios_productos.incrementarStock', ':id') }}".replace(':id', idProducto);
                    
                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';
                    form.appendChild(token);

                    const inputCantidad = document.createElement('input');
                    inputCantidad.type = 'hidden';
                    inputCantidad.name = 'cantidad_nueva';
                    inputCantidad.value = cantidadNueva;
                    form.appendChild(inputCantidad);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

    // 2. CONFIRMACIÓN INTERACTIVA DE ELIMINACIÓN
    document.querySelectorAll('.form-eliminar-producto').forEach(function(formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            const boton = this.querySelector('.btn-trigger-delete');
            const nombre = boton.getAttribute('data-nombre');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success fw-bold px-3 py-2 rounded-3 mx-2",
                    cancelButton: "btn btn-danger fw-bold px-3 py-2 rounded-3 mx-2"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: '¿Eliminar producto?',
                text: `Vas a quitar "${nombre}" permanentemente del catálogo de la tienda.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No, conservar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit();
                }
            });
        });
    });
</script>
@endsection