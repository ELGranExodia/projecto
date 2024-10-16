<?php

    namespace App\Models;
    use App\Models\Model;

    class EntregaComidaModel extends Model {
        protected $table = "entrega_comida";
        public function getEstudiantesConOT($start = 0, $limit = 10, $sidx = 'numero_orden', $sord = 'asc', $fecha = null
        , $seccion = null, $bachillerato = null)
        {
            // Consulta SQL para unir las tablas 'estudiantes' y 'entrega_comida'
            $sql = "SELECT o.id_entrega, e.numero_orden, e.nombre_completo, e.seccion, 
                    e.bachillerato, e.nie, e.ano, date_format(o.fecha, '%d-%m-%Y') as fecha, rc.nombre_platillo,
                    rc.porciones_preparadas, rc.responsable
                    FROM entrega_comida o 
                    LEFT JOIN estudiantes e ON e.numero_orden = o.numero_orden
                    left join registro_comida rc on rc.id_comida = o.id_comida and o.numero_orden = e.numero_orden
                   ";
            if(!empty($fecha)){
                $sql .= " where date_format(o.fecha, '%Y-%m-%d') = '$fecha' ";
            }
            if(!empty($seccion)){
                $sql .= " where e.seccion = '$seccion' ";
            }
            if(!empty($bachillerato)){
                $sql .= " where e.bachillerato = '$bachillerato' ";
            }
            $sql .= " ORDER BY {$sidx} {$sord}
                    LIMIT {$start}, {$limit};";
            // Ejecuta la consulta SQL
            return $this->query($sql)->get();
        }
        public function getMenu($start = 0, $limit = 10, $sidx = 'numero_orden', $sord = 'asc')
        {
            // Consulta SQL para unir las tablas 'estudiantes' y 'entrega_comida'
            $sql = "SELECT date_format(e.fecha_preparacion, '%d-%m-%Y') as fecha, e.nombre_platillo, e.tipo_comida, e.ingredientes, 
                    e.porciones_preparadas, e.responsable
                    FROM registro_comida e;";
            // Ejecuta la consulta SQL
            return $this->query($sql)->get();
        }
        public function getTotalRegistros() {
            // Realiza la consulta para contar el número total de registros
            $sql = "SELECT COUNT(*) AS total FROM entrega_comida o 
                    LEFT JOIN estudiantes e ON e.numero_orden = o.numero_orden";
           
              return  $this->query($sql)->get();
        }
        
    }