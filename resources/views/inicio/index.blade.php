@extends('layouts.template')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 fw-bold mb-0">Tienda La Subidita</h1>
            <p class="text-muted">La Subidita, calidad que siempre va hacia arriba</p>
        </div>
        <div class="text-end">
            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                Sistema en linea
            </span>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-8 col-md-12">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold"><span class="text-danger">⚠️</span> Stock Crítico</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th>PRODUCTO</th>
                                    <th class="text-center">CANTIDAD</th>
                                    <th class="text-end">PRECIO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stockBajo as $prod)
                                <tr>
                                    <td class="fw-bold">{{ $prod->nombre }}</td> 
                                    <td class="text-center">
                                        <span class="badge bg-danger-subtle text-danger rounded-pill">
                                            {{ $prod->stock }} pz 
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold">${{ number_format($prod->precio_venta, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Todo el inventario está al día.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="card border-0 shadow-sm bg-primary text-white h-100" style="border-radius: 15px;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center py-4">
                    <div class="mb-3" style="font-size: 3rem;">⭐</div>
                    <h6 class="text-uppercase mb-1 opacity-75">Producto Destacado</h6>
                    <h3 class="fw-bold">{{ $productoTop->nombre ?? 'N/A' }}</h3>
                    <h2 class="display-6 fw-bold mt-2">${{ number_format($productoTop->precio_venta ?? 0, 2) }}</h2>
                    <p class="small mb-0 opacity-75">Precio de mercado actual</p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="fw-bold mb-4">Accesos Directos</h5>
    <div class="row g-4">
        @php
            $botones = [
                ['titulo' => 'Proveedores', 'url' => 'pagos_proveedores', 'desc' => 'Gestionar pagos', 'icon' => '🚚'],
                ['titulo' => 'Productos', 'url' => 'inventarios_productos', 'desc' => 'Ver inventario', 'icon' => '📦'],
                ['titulo' => 'Ventas', 'url' => 'ventas', 'desc' => 'Punto de venta', 'icon' => '💰'],
                ['titulo' => 'Servicios', 'url' => 'recargas_telefonicas', 'desc' => 'Pines y saldo', 'icon' => '📱'],
            ];
        @endphp

        @foreach($botones as $btn)
        <div class="col-6 col-lg-3">
            <a href="{{ url($btn['url']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 btn-dashboard" style="border-radius: 15px; transition: 0.3s;">
                    <div class="card-body text-center py-4">
                        <div class="fs-1 mb-2">{{ $btn['icon'] }}</div>
                        <h6 class="fw-bold text-dark mb-1">{{ $btn['titulo'] }}</h6>
                        <p class="text-muted small mb-0">{{ $btn['desc'] }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<style>
    .btn-dashboard:hover {
        transform: translateY(-5px);
        background-color: #f8f9fa;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .bg-danger-subtle { background-color: #fce8e6 !important; }
    .bg-success-subtle { background-color: #e6f4ea !important; }
</style>
@endsection