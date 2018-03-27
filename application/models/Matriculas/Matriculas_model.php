<?php
class Matriculas_model extends CI_Model {

    public $id_matricula;
    public $id_empleado;
    public $de_empresa;
    public $denominacion_matricula;
    public $tipo_vehiculo;
    public $estado;
    public $fecha_baja;



    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }

    // Construye un objecto desde un array
    public function ConstructFromArray(Array $properties=array())
    {
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }

    //Devuelve un objeto desde la base de datos con un determinado id
    public function get_by_id($id)
    {
        $this->db->from('matriculas');
        $this->db->where('id_matricula',$id);
        $this->db->join('empleados', 'empleados.id_empleado = matriculas.id_empleado');
        $query = $this->db->get();
        return ($query->result()[0]);
    }

    //Devuelve todas las entradas de la base de datos
    public function get($hasta = null, $whereArray = null)
    {
        $this->db->select('m.id_matricula, m.denominacion_matricula, e.nombre_empleado, m.de_empresa, m.tipo_vehiculo, m.estado');
        $this->db->from('matriculas m');
        $this->db->where('m.fecha_baja',null);
        $this->db->join('empleados e', 'e.id_empleado = m.id_empleado');

        if( ! is_null($whereArray) )
            $this->db->where( $whereArray );

        if( ! is_null($hasta) )
            $this->db->limit( $hasta );
        
        $query = $this->db->get();
        return $query->result();
    }

    //Devuelve todas las entradas de la base de datos SIN hacer JOIN con empleados
    public function getWhere($hasta = null, $whereArray = null)
    {
        $this->db->select('m.id_matricula, m.denominacion_matricula, m.de_empresa, m.tipo_vehiculo, m.estado');
        $this->db->from('matriculas m');
        $this->db->where('m.fecha_baja',null);

        if( ! is_null($whereArray) )
            $this->db->where( $whereArray );

        if( ! is_null($hasta) )
            $this->db->limit( $hasta );
        
        $query = $this->db->get();
        return $query->result();
    }

    //Control de duplicados
    private function ExisteMatricula($denominacion, $id = null)
    {
        if ($id != null) {
            $this->db->where('id_matricula !=',$id);
        }
        $this->db->where('m.denominacion_matricula',$denominacion);
        $this->db->where('m.fecha_baja',null);
        $query = $this->db->get('matriculas m');
        if ($query->num_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    // Guarda la matricula en la base de datos
    public function save()
    {
        if(!$this->ExisteMatricula($this->denominacion_matricula))
        {
            $this->denominacion_matricula = strtoupper($this->denominacion_matricula);
            $this->db->insert('matriculas', $this);
            $this->db->close();
            return ['success','Operacion realizada con éxito'];
        }
        else
            return ['error','La matricula a registrar ya existe'];
    }

    // Modifica una matricula en la base de datos
    public function update()
    {
        if(!$this->ExisteMatricula($this->denominacion_matricula, $this->id_matricula))
        {
            $this->db->set('de_empresa', $this->de_empresa);
            $this->db->set('denominacion_matricula', strtoupper($this->denominacion_matricula));
            $this->db->set('tipo_vehiculo', $this->tipo_vehiculo);
            $this->db->set('estado', $this->estado);
            $this->db->set('id_empleado', $this->id_empleado);
            $this->db->where('id_matricula',$this->id_matricula);
            $this->db->update('matriculas');
            $this->db->close();
            return ['success','Operacion realizada con éxito'];
        }
        else
            return ['error','El producto a registrar ya existe', $this->id_matricula];    }

    // Aprobar una matricula
    public function approve($id)
    {
        $this->db->set('estado', "Aprobada");
        $this->db->where('id_matricula',$id);
        $this->db->update('matriculas');
        $this->db->close();
        return ['success','Operacion realizada con éxito'];
    }


    // Baja logicamente una matricula en la base de datos
    public function delete($id)
    {
        $this->db->set('m.fecha_baja', date('Y-m-d'));
        $this->db->where('m.id_matricula',$id);
        $this->db->update('matriculas m');
        $this->db->close();
        return ['success','Operacion realizada con éxito'];
    }
}
?>