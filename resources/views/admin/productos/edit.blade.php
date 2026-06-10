@extends('admin.panel') 

@section('titulo', 'Editar Producto - Brightness.Store')

@section('contenido')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Editar Producto: {{ $producto->nombre }}</h5>
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <select name="categoria_id" class="form-select" required>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" @if($categoria->id == $producto->categoria_id) selected @endif>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio ($)</label>
                                <input type="number" step="0.01" name="precio" class="form-control" value="{{ $producto->precio }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Actual</label>
                                <input type="number" name="stock" class="form-control" value="{{ $producto->stock }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ $producto->descripcion }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cambiar Imagen (Opcional)</label>
                            <input type="file" name="imagen" class="form-control" accept="image/*">
                            <small class="text-muted">Dejá este campo vacío si querés mantener la imagen actual.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-warning text-dark fw-bold">Actualizar Producto</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection