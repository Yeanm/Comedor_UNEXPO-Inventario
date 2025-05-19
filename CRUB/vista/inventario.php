<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario con Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="assets/css/style.css">  
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="https://kit.fontawesome.com/3267127607.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
</head>
<body>

    <button id="btnToggleSidebar">☰</button>
    <?php include 'assets/components/sidebar.php'; ?>

<section>
    <div id="content">
    
        <center><h1>Inventario</h1></center>
    <div class="d-flex justify-content-end mb-3"> 
        <button class="btn btn-primary mb-3" onclick="abrirModal()">Agregar Producto</button>
    </div>
        <table id="tablaInventario" class="display table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Estado</th>
                    <th>Ingreso</th>
                    <th>Vencimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Agregar / Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formProducto">
          <input type="hidden" id="id" name="id">
          <div class="row mb-3">
            <div class="col">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col">
              <label for="cantidad" class="form-label">Cantidad</label>
              <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="unidad" class="form-label">Unidad</label>
              <input type="text" class="form-control" id="unidad" name="unidad" required>
            </div>
            <div class="col">
              <label for="estado" class="form-label">Estado</label>
              <select class="form-select" id="estado" name="estado" required>
                <option value="">Seleccione</option>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
              <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
              <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
            </div>
            <div class="col">
              <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
              <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tablaInventario').DataTable({
          
                ajax: {
                    url: 'controlador/Inventario.php?action=listar',
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'cantidad' },
                    { data: 'unidad' },
                    { data: 'estado' },
                    { data: 'fecha_ingreso' },
                    { data: 'fecha_vencimiento' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-primary" onclick="editar(${row.id})">Editar</button>
                                <button class="btn btn-sm btn-danger" onclick="eliminar(${row.id})">Eliminar</button>
                            `;
                        }
                    }
                ],    "pageLength": 5,
        "lengthMenu": [5, 10, 15, 20],
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"  }  }
            });

            $('#formProducto').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.post('controlador/Inventario.php?action=guardar', formData, function(response) {
            if (response.success) {
                $('#modalProducto').modal('hide');
                tabla.ajax.reload(null, false);
            } else {
                alert('Error al guardar: ' + (response.error || ''));
            }
        }, 'json');
    });
});

function abrirModal() {
    $('#formProducto')[0].reset();
    $('#formProducto input[name="id"]').val('');
    $('#modalProducto').modal('show');
}

function editar(id) {
    $.getJSON('controlador/Inventario.php?action=obtener&id=' + id, function(data) {
        if ($.isEmptyObject(data)) {
            alert('Producto no encontrado');
        } else {
            $('#formProducto input[name="id"]').val(data.id);
            $('#formProducto input[name="nombre"]').val(data.nombre);
            $('#formProducto input[name="cantidad"]').val(data.cantidad);
            $('#formProducto input[name="unidad"]').val(data.unidad);
            $('#formProducto input[name="estado"]').val(data.estado);
            $('#formProducto input[name="fecha_ingreso"]').val(data.fecha_ingreso);
            $('#formProducto input[name="fecha_vencimiento"]').val(data.fecha_vencimiento);
            $('#modalProducto').modal('show');
        }
    });
}

function eliminar(id) {
    if (confirm('¿Seguro que deseas eliminar este producto?')) {
        $.post('controlador/Inventario.php?action=eliminar', {id: id}, function(response) {
            if (response.success) {
                tabla.ajax.reload(null, false);
            } else {
                alert('Error al eliminar: ' + (response.error || ''));
            }
        }, 'json');
    }
}
            $('#btnToggleSidebar').on('click', function () {
                $('#sidebar').toggleClass('collapsed');
                $('#content').toggleClass('expanded');
            });
    </script>
</body>
</html>