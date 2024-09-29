<?php

namespace App\Models;

class ProveedorModel extends Model {
    protected $table = "estudiantes";

    // Método para obtener los estudiantes con OT
    public function getEstudiantesConOT()
    {
        // Consulta SQL para unir las tablas 'estudiantes' y 'ot'
        $sql = "SELECT e.numero_orden, e.nombre_completo, e.seccion, e.bachillerato, e.nie, e.ano, o.estado, o.fecha
                FROM estudiantes e
                LEFT JOIN ot o ON e.nie = o.nie";

        // Ejecuta la consulta SQL
        return $this->query($sql)->get();
    }
}