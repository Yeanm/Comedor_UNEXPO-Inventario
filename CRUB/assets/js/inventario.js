let tabla;

$(document).ready(function () {
    tabla = $('#tablaInventario').DataTable({
        "lengthMenu": [ [5, 10, 15, 20], [5, 10, 15, 20] ],
        ajax: {
            url: 'controlador/inventario.php?action=listar',
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
                orderable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary" onclick="editar(${row.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminar(${row.id})">Eliminar</button>
                    `;
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });

    // Manejar el submit del formulario para guardar o editar
    $('#formProducto').submit(function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.post('controlador/inventario.php?action=guardar', formData, function (response) {
            if (response.success) {
                $('#modalProducto').modal('hide');
                tabla.ajax.reload(null, false);
            } else {
                alert('Error al guardar: ' + (response.error || ''));
            }
        }, 'json');
    });
});

// Función para abrir modal para agregar
function abrirModal() {
    $('#formProducto')[0].reset();
    $('#formProducto input[name="id"]').val('');
    $('#modalProducto').modal('show');
}

// Función para editar un producto
function editar(id) {
    $.getJSON('controlador/inventario.php?action=obtener&id=' + id, function (data) {
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

// Función para eliminar un producto
function
eliminar(id) {
    if (confirm('¿Seguro que deseas eliminar este producto?')) {
    $.post('controlador/inventario.php?action=eliminar', { id: id }, function (response) {
    if (response.success) {
    tabla.ajax.reload(null, false);
    } else {
    alert('Error al eliminar: ' + (response.error || ''));
    }
    }, 'json');
    }
    }