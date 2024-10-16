<?php

namespace App\Controllers;

use App\Models\EstudianteModel;
use Illuminate\Http\Request;
use App\Vendor\Fpdf\FPDF;

class EstudianteController extends Controller {
    protected $modelo;

    public function __construct() {
        $this->modelo = new EstudianteModel();
    }

    public function index() {
        return $this->view('estudiante');
    }
    public function obtenerFiltros()
    {
        $model = new EstudianteModel();

        // Obtener secciones únicas
        $secciones = $model->getEstudianteSeccion();
        // Obtener bachilleratos únicos
        $bachilleratos = $model->getEstudianteBachillerato();

        // Crear un arreglo con los datos
        $respuesta = [
            'secciones' => $secciones,
            'bachilleratos' => $bachilleratos
        ];

        // Configurar el encabezado Content-Type a JSON
        header('Content-Type: application/json');

        // Usar json_encode para convertir el arreglo a JSON
        echo json_encode($respuesta);
    }
    public function obtener_estudiantes() {
        // Variables enviadas por jqGrid
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        $sidx = $_POST['sidx'];
        $sord = $_POST['sord'];
    
        // Nuevas variables de filtro que recibirás del formulario o la solicitud
        $seccion = $_POST['seccion'] ;//$_POST['seccion'] : null;
        $bachillerato = $_POST['bachillerato'] ;//? $_POST['bachillerato'] : null;
        
        if (!$sidx) $sidx = 1;

        // Obtener registros filtrados
        $registros = $this->modelo->getEstudiantes($seccion, $bachillerato);
        $count = count($registros);
    
        $total_pages = $count > 0 ? ceil($count / $limit) : 0;
    
        if ($page > $total_pages) $page = $total_pages;
        $start = $limit * $page - $limit;
        if ($start < 0) $start = 0;
    
        // Crear la respuesta para jqGrid
        $responce = new \stdClass();
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;
    
        $i = 0;
        foreach($registros as $estudiante) {
            $responce->rows[$i]['id'] = $estudiante->numero_orden;
            $responce->rows[$i]['cell'] = [
                $estudiante->numero_orden,
                $estudiante->nombre_completo,
                $estudiante->seccion,
                $estudiante->bachillerato,
                $estudiante->nie,
                $estudiante->ano
            ];
            $i++;
        }
    
        // Enviar respuesta en formato JSON
        echo json_encode($responce);
    }
    
    public function guardar() {
        $accion = $_POST['accion'];
        $data = [
            'numero_orden' => $_POST['numero_orden'],
            'nombre_completo' => $_POST['nombre_completo'],
            'seccion' => $_POST['seccion'],
            'bachillerato' => $_POST['bachillerato'],
            'nie' => $_POST['nie'],
            'ano' => $_POST['anio']
        ];

        if ($accion == '0')
            $this->modelo->insert($data);
        else {
            unset($data['numero_orden']);
            $where = ['numero_orden' => $_POST['numero_orden']];
            $this->modelo->update($data, $where);
        }

        echo json_encode(['res' => true]);
    }

    public function editar() {
        $numero_orden = $_POST['id'];
        echo json_encode($this->modelo->where('numero_orden', $numero_orden)->first());
    }

    public function eliminar() {
        $numero_orden = $_POST['id'];
        $where = ['numero_orden' => $numero_orden];
        $this->modelo->delete($where);
        echo json_encode(['res' => true]);
    }

    // Método para verificar si el NRC ya existe en la tabla proveedores
    public function verificarNie() {
        $nrc = $_POST['nie'];
        $rec = $this->modelo->where('nie',$nrc)->first();
        if($rec)
            echo json_encode(['valid'=>false]);
        else
            echo json_encode(['valid'=>true]);
    }
    public function obtener_listaestudiantes() {
        $estudiantesModel = new EstudianteModel(); // Asumimos que tienes un modelo para estudiantes
        $estudiantes = $estudiantesModel->all(); // Obtener todos los estudiantes
        echo json_encode($estudiantes); // Devolver los estudiantes en formato JSON
    }
    public function informe() {
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->SetFont('Arial', '', 8);
        $pdf->AddPage();

        $pdf->Cell(15, 5, 'Nombres:', 0);
        $pdf->Cell(60, 5, 'Nombre del Estudiante', 'B');
        $pdf->Cell(15);
        $pdf->Cell(15, 5, 'Seccion:', 0);
        $pdf->Cell(60, 5, 'Seccion Estudiante', 'B', 1);

        $pdf->Output('I', 'informe_estudiante.pdf');
    }

    public function informetabla() {
        // Nuevas variables de filtro que recibirás del formulario o la solicitud
       $seccion = $_GET['seccion'] ?? null;
       $bachillerato = $_GET['bachillerato'] ?? null;
       $estudiantes = $this->modelo->getEstudiantes($seccion, $bachillerato);

        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->AddPage();

        $ancho = $pdf->GetPageWidth() - 20;

        $pdf->Cell($ancho, 7, 'LISTA DE ESTUDIANTES', 0, 0, 'C');
        $pdf->SetFont('Arial', '', 8);

        $pdf->Ln(14);
        $pdf->Cell($ancho * 0.25, 5, 'Nombre Completo', 1, 0, 'C');
        $pdf->Cell($ancho * 0.15, 5, 'Seccion', 1, 0, 'C');
        $pdf->Cell($ancho * 0.2, 5, 'Bachillerato', 1, 0, 'C');
        $pdf->Cell($ancho * 0.15, 5, 'NIE', 1, 0, 'C');
        $pdf->Cell($ancho * 0.15, 5, 'Periodo', 1, 1, 'C');

        foreach($estudiantes as $estudiante) {
            $pdf->Cell($ancho * 0.25, 5, $estudiante->nombre_completo, 1, 0);
            $pdf->Cell($ancho * 0.15, 5, $estudiante->seccion, 1, 0);
            $pdf->Cell($ancho * 0.2, 5, $estudiante->bachillerato, 1, 0);
            $pdf->Cell($ancho * 0.15, 5, $estudiante->nie, 1, 0);
            $pdf->Cell($ancho * 0.15, 5, $estudiante->ano, 1, 1);
        }

        $pdf->Output('I', 'estudiantes.pdf');
    }
}
