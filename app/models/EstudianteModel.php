<?php

    namespace App\Models;

    use App\Models\Model;

    class EstudianteModel extends Model {
        protected $table = "estudiantes";
        public function getEstudianteSeccion()
        {
            // Consulta SQL para unir las tablas 'estudiantes' y 'entrega_comida'
            $sql = "SELECT distinct e.seccion FROM estudiantes e ;";
            // Ejecuta la consulta SQL
            return $this->query($sql)->get();
        }
        public function getEstudianteBachillerato()
        {
            // Consulta SQL para unir las tablas 'estudiantes' y 'entrega_comida'
            $sql = "SELECT distinct e.bachillerato FROM estudiantes e ;";
            // Ejecuta la consulta SQL
            return $this->query($sql)->get();
        }
        public function getEstudiantes($seccion, $bachillerato)
        {
            // Consulta SQL básica
            $sql = "SELECT e.numero_orden, e.nombre_completo, e.seccion, e.bachillerato, e.nie, e.ano 
            FROM estudiantes e";
            if(!empty($seccion) ){
                $sql .= " where e.seccion = '$seccion';";
            }else if(!empty($bachillerato)){
                $sql .= " where e.bachillerato = '$bachillerato';";
            }
            // Ejecuta la consulta SQL con los parámetros
            return $this->query($sql)->get();
        }
        
    }