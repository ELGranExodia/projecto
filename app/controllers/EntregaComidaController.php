<?php

namespace App\Controllers;
use App\Models\EntregaComidaModel;
use App\Vendor\Fpdf\FPDF;
class EntregaComidaController extends Controller {
    protected $modelo;

    public function __construct() {
        $this->modelo = new EntregaComidaModel();
    }

    public function index() {
        return $this->view('entregacomida');
    }
    public function obtener_registro() {
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['rows']) ? (int)$_POST['rows'] : 10;
        $sidx = isset($_POST['sidx']) ? $_POST['sidx'] : 'id_entrega';
        $sord = isset($_POST['sord']) ? $_POST['sord'] : 'asc';
        $fecha = $_POST['fecha'] ?? null;
        $seccion = $_POST['seccion'] ?? null;
        $bachillerato = $_POST['bachillerato'] ?? null;
        // Obtener el total de registros
        $totalRegistros = $this->modelo->getTotalRegistros();
    
        // Verifica si $totalRegistros es un número entero antes de hacer la operación
        if (is_int($totalRegistros) && $totalRegistros > 0) {
            $totalPages = ceil($totalRegistros / $limit); // calcular total de páginas
        } else {
            $totalPages = 0;
        }
    
        // Calcular el offset para la paginación
        $start = ($page - 1) * $limit;
        if ($start < 0) {
            $start = 0;
        }
    
        // Obtener los registros paginados
        $registros = $this->modelo->getEstudiantesConOT($start, $limit, $sidx, $sord, $fecha, $seccion, $bachillerato);
    
        // Formatear la respuesta
        $response = [
        'page' => $page,
        'total' => $totalPages,
        'records' => $totalRegistros,
        'rows' => array_map(function($registro) {
            return [
                'id_entrega' => $registro->id_entrega,  // Usar '->' en lugar de '[]'
                'nombre_completo' => $registro->nombre_completo,
                'seccion' => $registro->seccion,
                'bachillerato' => $registro->bachillerato,
                'nie' => $registro->nie,
                'anio' => $registro->ano,
                'fecha' => $registro->fecha
            ];
            }, $registros)
        ];
    
        // Enviar la respuesta en formato JSON
        echo json_encode($response);
    }    
    public function guardar() {
        // Recibir la acción del formulario
        $accion = $_POST['accion'];
        // Configurar la zona horaria
        date_default_timezone_set('America/El_Salvador');

        // Obtener la fecha y hora actual
        $fecha_entrega = date('Y-m-d H:i:s');
        $fecha_entrega =  date('Y-m-d H:i:s');
        $fecha_entrega =  date('Y-m-d H:i:s');
        // Verifica si el 'id_comida' y 'id_estudiante' han sido enviados
        if (!isset($_POST['comida']) || !isset($_POST['estudiante'])) {
            echo json_encode(['res' => false, 'error' => 'Datos incompletos.']);
            return;
        }
    
        // Arreglo con los datos a insertar/actualizar
        $data = [
            'fecha' => $fecha_entrega,  // Fecha de entrega
            'numero_orden' => $_POST['estudiante'],  // ID del estudiante seleccionado
            'id_comida' => $_POST['comida'],  // ID del platillo seleccionado
        ];
    
        // Si la acción es '0', se hace una inserción
        if ($accion == '0') {
            $this->modelo->insert($data);  // Insertar nuevo registro
        } else {
            // Si la acción es distinta a '0', se hace una actualización
            $where = ['id_entrega' => $_POST['id_entrega']];  // Condición para el WHERE
            $this->modelo->update($data, $where);  // Actualizar registro
        }
    
        // Respuesta en formato JSON
        echo json_encode(['res' => true]);
    }
    public function editar() {
        $id_entrega = $_POST['id_entrega'];
        echo json_encode($this->modelo->where('id_entrega', $id_entrega)->first());
    }

    public function eliminar() {
        $id_entrega = $_POST['id_entrega'];
        $where = ['id_entrega' => $id_entrega];
        $this->modelo->delete($where);
        echo json_encode(['res' => true]);
    }

    // Método para verificar si el estudiante ya ha recibido su comida
    public function verificarEntrega() {
        $id_estudiante = $_POST['id_estudiante'];
        $rec = $this->modelo->where('id_estudiante', $id_estudiante)->first();
        if ($rec) {
            echo json_encode(['valid' => false]);
        } else {
            echo json_encode(['valid' => true]);
        }
    }

    public function informe() {
        // Implementar lógica para generar un informe PDF si es necesario.
    }

    public function informetabla() {
        $entregas = $this->modelo->getEstudiantesConOT();

        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->AddPage();

        $ancho = $pdf->GetPageWidth() - 20;

        $pdf->Cell($ancho, 7, 'LISTA DE ENTREGAS DE COMIDA', 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);

        $pdf->Ln(14);
        $pdf->Cell($ancho * 0.15, 5, 'Fecha', 1, 0, 'C');
        $pdf->Cell($ancho * 0.2, 5, 'ID Estudiante', 1, 0, 'C');
        $pdf->Cell($ancho * 0.25, 5, 'Nombre del Estudiante', 1, 0, 'C');
        $pdf->Cell($ancho * 0.2, 5, 'Platillo', 1, 0, 'C');
        $pdf->Cell($ancho * 0.1, 5, 'Responsable', 1, 1, 'C');

        foreach ($entregas as $entrega) {
            $pdf->Cell($ancho * 0.15, 5, $entrega->fecha, 1, 0);
            $pdf->Cell($ancho * 0.2, 5, $entrega->nie, 1, 0);
            $pdf->Cell($ancho * 0.25, 5, utf8_decode($entrega->nombre_completo), 1, 0);
            $pdf->Cell($ancho * 0.2, 5, utf8_decode($entrega->nombre_platillo), 1, 0);
            $pdf->Cell($ancho * 0.1, 5, utf8_decode($entrega->responsable), 1, 1);
        }

        $pdf->Output('I', 'entregas_comida.pdf');
    }
}
