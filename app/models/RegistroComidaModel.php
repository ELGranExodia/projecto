<?php

    namespace App\Models;

    use App\Models\Model;

    class RegistroComidaModel extends Model {
        protected $table = "registro_comida";
        public function getMenu($start = 0, $limit = 10, $sidx = 'numero_orden', $sord = 'asc', $fecha_inicio = null, $fecha_fin = null)
        {
            // Inicializa la consulta SQL
            $sql = "SELECT date_format(e.fecha_preparacion, '%d-%m-%Y') as fecha_preparacion,
             e.nombre_platillo, e.tipo_comida, e.ingredientes, 
            e.porciones_preparadas, e.responsable, e.id_comida FROM registro_comida e ";

            // Aplica el filtro por fechas si ambas fechas están presentes
            if (!empty($fecha_inicio) && !empty($fecha_fin)) {
                $sql .= "WHERE e.fecha_preparacion BETWEEN '$fecha_inicio' AND '$fecha_fin' ";
            }

            // Agrega la cláusula de ordenamiento
            $sql .= "ORDER BY $sidx $sord ";

            // Agrega la cláusula LIMIT para la paginación
            $sql .= "LIMIT $start, $limit;";

            // Ejecuta la consulta SQL
            return $this->query($sql)->get();
        }
        public function getRegistros() {
            // Consulta SQL para unir las tablas 'estudiantes' y 'entrega_comida'
            $sql = "SELECT id_comida, fecha_preparacion, nombre_platillo, tipo_comida, ingredientes, porciones_preparadas, responsable
                    FROM registro_comida ;";
            // Ejecuta la consulta SQL
            return $this->query($sql)->get();
        }
    }