<?php

namespace App\Controllers;

use App\Models\RegistroComidaModel;
use App\Vendor\Fpdf\FPDF;

class RegistroComidaController extends Controller {
    protected $modelo;

    public function __construct() {
        $this->modelo = new RegistroComidaModel();
    }

    public function index() {
        return $this->view('registrocomida');
    }

    public function obtener_registro() {
        // Variables enviadas por jqGrid
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        $sidx = $_POST['sidx'];
        $sord = $_POST['sord'];
    
        // Variables para las fechas
        $fecha_inicio = $_POST['fecha_inicio'] ?? null;
        $fecha_fin = $_POST['fecha_fin'] ?? null;
    
        if (!$sidx) $sidx = 'numero_orden'; // Definir un valor por defecto para sidx
    
        // Consulta para obtener y contar la cantidad de registros de la tabla registro_comida
        $total_registros = $this->modelo->getMenu(0, PHP_INT_MAX, $sidx, $sord, $fecha_inicio, $fecha_fin); // Obtener todos los registros para contar
        $count = count($total_registros);
    
        // Fórmula para determinar la cantidad de páginas
        $total_pages = $count > 0 ? ceil($count / $limit) : 0;
    
        if ($page > $total_pages) $page = $total_pages;
        $start = $limit * $page - $limit;
        if ($start < 0) $start = 0;
    
        // Obtener registros filtrados y paginados
        $registros = $this->modelo->getMenu($start, $limit, $sidx, $sord, $fecha_inicio, $fecha_fin);
    
        // Creación del objeto de respuesta
        $responce = new \stdClass();
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
    
        // Preparamos los datos que se mostrarán en la tabla dinámica
        $i = 0;
        foreach ($registros as $comida) {
            $responce->rows[$i]['id'] = $comida->id_comida; // Asegúrate de que id_comida exista
            $responce->rows[$i]['cell'] = [
                $comida->id_comida,
                $comida->fecha_preparacion,
                $comida->nombre_platillo,
                $comida->tipo_comida,
                $comida->ingredientes,
                $comida->porciones_preparadas,
                $comida->responsable
            ];
            $i++;
        }
    
        // Se envía la respuesta en formato JSON
        header('Content-Type: application/json'); // Asegúrate de establecer el tipo de contenido
        echo json_encode($responce);
    }
    public function guardar() {
        $accion = $_POST['accion'];
        $data = [
            'fecha_preparacion' => $_POST['fecha_preparacion'],
            'nombre_platillo' => $_POST['nombre_platillo'],
            'tipo_comida' => $_POST['tipo_comida'],
            'ingredientes' => $_POST['ingredientes'],
            'porciones_preparadas' => $_POST['porciones_preparadas'],
            'responsable' => $_POST['responsable']
        ];

        if ($accion == '0') {
            $this->modelo->insert($data);
        } else {
            unset($data['id_comida']);
            $where = ['id_comida' => $_POST['id_comida']];
            $this->modelo->update($data, $where);
        }

        echo json_encode(['res' => true]);
    }

    public function editar() {
        $id_comida = $_POST['id_comida'];
        echo json_encode($this->modelo->where('id_comida', $id_comida)->first());
    }
    public function eliminar() {
        $id_comida = $_POST['id_comida'];
        $where = ['id_comida' => $id_comida];
        $this->modelo->delete($where);
        echo json_encode(['res' => true]);
    }
    // Método para verificar si el platillo ya existe en la tabla registro_comida
    public function verificarPlatillo() {
        $nombre_platillo = $_POST['nombre_platillo'];
        $rec = $this->modelo->where('nombre_platillo', $nombre_platillo)->first();
        if ($rec) {
            echo json_encode(['valid' => false]);
        } else {
            echo json_encode(['valid' => true]);
        }
    }
    public function obtener_listacomidas() {
        // Verificar que no haya salida de texto antes de esto
        $comidas = $this->modelo->all(); // Obtener todas las comidas desde la base de datos
        echo json_encode($comidas); // Devolver las comidas en formato JSON
    }
    public function informe() {
        // Implementar lógica para generar un informe PDF si es necesario.
    }
   
    public function informetabla() {
        $comidas = $this->modelo->getRegistros();
        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->AddPage();

        $ancho = $pdf->GetPageWidth() - 20;

        $pdf->Cell($ancho, 7, 'LISTA DE COMIDAS', 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);

        $pdf->Ln(14);
        $pdf->Cell($ancho * 0.15, 5, 'Fecha', 1, 0, 'C');
        $pdf->Cell($ancho * 0.25, 5, 'Nombre del Platillo', 1, 0, 'C');
        $pdf->Cell($ancho * 0.15, 5, 'Tipo de Comida', 1, 0, 'C');
        $pdf->Cell($ancho * 0.25, 5, 'Ingredientes', 1, 0, 'C');
        $pdf->Cell($ancho * 0.1, 5, 'Porciones', 1, 0, 'C');
        $pdf->Cell($ancho * 0.1, 5, 'Responsable', 1, 1, 'C');

        foreach ($comidas as $comida) {
            $pdf->Cell($ancho * 0.15, 5, $comida->fecha_preparacion, 1, 0);
            $pdf->Cell($ancho * 0.25, 5, utf8_decode($comida->nombre_platillo), 1, 0);
            $pdf->Cell($ancho * 0.15, 5, $comida->tipo_comida, 1, 0);
            $pdf->Cell($ancho * 0.25, 5, utf8_decode($comida->ingredientes), 1, 0);
            $pdf->Cell($ancho * 0.1, 5, $comida->porciones_preparadas, 1, 0);
            $pdf->Cell($ancho * 0.1, 5, $comida->responsable, 1, 1);
        }

        $pdf->Output('I', 'comidas.pdf');
    }
}
