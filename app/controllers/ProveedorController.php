<?php

namespace App\Controllers;

use App\Models\ProveedorModel;
use App\Models\CocinaModel;
use App\Vendor\Fpdf\FPDF;

class ProveedorController extends Controller {
    protected $modelo;
    protected $modelo2;

    public function __construct() {
        $this->modelo = new ProveedorModel();
        $this->modelo2 = new CocinaModel();
    }

    public function index() {
        return $this->view('proveedor');
    }

    public function obtener_proveedores() {
        $page = $_POST['page'];
        $limit = $_POST['rows'];
        $sidx = $_POST['sidx'];
        $sord = $_POST['sord'];

        if (!$sidx) $sidx = 1;

        $registros = $this->modelo->all();
        $count = count($registros);
        $total_pages = $count > 0 ? ceil($count/$limit) : 0;

        if ($page > $total_pages) $page = $total_pages;
        $start = $limit * $page - $limit;
        if($start < 0) $start = 0;

        $responce = new \stdClass();
        $responce->page = $page;
        $responce->total = $total_pages;
        $responce->records = $count;

        $i = 0;
        foreach($registros as $proveedor) {
            $responce->rows[$i]['id'] = $proveedor->nrc;
            $responce->rows[$i]['cell'] = [
                $proveedor->nrc,
                $proveedor->nombre_empresa,
                $proveedor->razon_social,
                $proveedor->persona_contacto,
                $proveedor->telefono_contacto,
                $proveedor->correo_electronico,
                isset($proveedor->estado) ? $proveedor->estado : 'N/A',
                isset($proveedor->fecha) ? $proveedor->fecha : 'N/A'
            ];
            $i++;
        }

        echo json_encode($responce);
    }

    public function guardar() {
        $accion = $_POST['accion'];
        $data = [
            'nrc' => $_POST['nrc'],
            'nombre_empresa' => $_POST['nombre_empresa'],
            'razon_social' => $_POST['razon_social'],
            'persona_contacto' => $_POST['persona_contacto'],
            'telefono_contacto' => $_POST['telefono_contacto'],
            'direccion' => $_POST['direccion'],
            'correo_electronico' => $_POST['correo_electronico'],
            'estado' => $_POST['estado'],
            'fecha' => $_POST['fecha']
        ];

        if ($accion == '0')
            $this->modelo->insert($data);
        else {
            unset($data['nrc']);
            $where = ['nrc' => $_POST['nrc']];
            $this->modelo->update($data, $where);
        }

        echo json_encode(['res'=>true]);
    }

    public function editar() {
        $nrc = $_POST['id'];
        echo json_encode($this->modelo->where('nrc', $nrc)->first());
    }

    public function eliminar() {
        $nrc = $_POST['id'];
        $where = ['nrc' => $nrc];
        $this->modelo->delete($where);
        echo json_encode(['res'=>true]);
    }

    public function verificarNrc() {
        $nrc = $_POST['nrc'];
        $rec = $this->modelo->where('nrc', $nrc)->first();
        echo json_encode(['valid' => !$rec]);
    }

    public function informe() {
        $pdf = new FPDF('P', 'mm', 'Letter');
        $pdf->SetFont('Arial', '', 8);
        $pdf->AddPage();

        $pdf->Cell(15, 5, 'Nombres:', 0);
        $pdf->Cell(60, 5, 'Hugo Manuel', 'B');
        $pdf->Cell(15);
        $pdf->Cell(15, 5, 'Apellidos:', 0);
        $pdf->Cell(60, 5, utf8_decode('Canjura Ramirez'), 'B', 1);

        $pdf->Cell(15, 5, 'Nombres:', 0);
        $pdf->Cell(60, 5, 'Hugo Manuel', 'B');

        $pdf->Output('I', 'informe.pdf');
    }

    public function informetabla()
{
    // Usamos la función getEstudiantesConOT para obtener los datos
    $estudiantesConOT = $this->modelo->getEstudiantesConOT();
    
    $pdf = new FPDF('L', 'mm', 'Legal');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->AddPage();

    $ancho = $pdf->GetPageWidth() - 20;
    $pdf->Image('vendor/resources/img/logoinframen.png', 10, 5, -770);
    $pdf->Cell($ancho, 8, 'REGISTROS', 0, 0, 'C');
    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln(14);
    $pdf->Cell($ancho * 0.1, 5, 'numero de orden', 1, 0, 'C');
    $pdf->Cell($ancho * 0.15, 5, utf8_decode('nombre completo'), 1, 0, 'C');
    $pdf->Cell($ancho * 0.15, 5, utf8_decode('seccion'), 1, 0, 'C');
    $pdf->Cell($ancho * 0.15, 5, 'bachillerato', 1, 0, 'C');
    $pdf->Cell($ancho * 0.15, 5, utf8_decode('nie'), 1, 0, 'C');
    $pdf->Cell($ancho * 0.1, 5, utf8_decode('año'), 1, 0, 'C');
    $pdf->Cell($ancho * 0.1, 5, utf8_decode('estado'), 1, 0, 'C');
    $pdf->Cell($ancho * 0.1, 5, utf8_decode('fecha'), 1, 1, 'C');

    // Iteramos sobre los estudiantes y añadimos los datos al PDF
    foreach ($estudiantesConOT as $registro) {
        $pdf->Cell($ancho * 0.1, 5, utf8_decode($registro->numero_orden), 1, 0);
        $pdf->Cell($ancho * 0.15, 5, utf8_decode($registro->nombre_completo), 1, 0);
        $pdf->Cell($ancho * 0.15, 5, $registro->seccion, 1, 0);
        $pdf->Cell($ancho * 0.15, 5, utf8_decode($registro->bachillerato), 1, 0);
        $pdf->Cell($ancho * 0.15, 5, $registro->nie, 1, 0);
        $pdf->Cell($ancho * 0.1, 5, $registro->ano, 1, 0);
        $pdf->Cell($ancho * 0.1, 5, $registro->estado, 1, 0);
        $pdf->Cell($ancho * 0.1, 5, $registro->fecha, 1, 1);
    }

    $pdf->Output('I', 'estudiantes_ot.pdf');
}
}