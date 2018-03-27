<?php
class Comprobante_model extends CI_Model {

    public $id_comprobante;
    public $fecha_emision;
    public $turno_comprobante;
    public $total_comprobante;
    public $id_matricula;
    public $fecha_baja;
    public $fecha_pago;

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

    // Construye un objecto empleado desde un array
    public function ConstructFromArray(Array $properties=array())
    {
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }

    //Devuelve un objeto desde la base de datos con un determinado id
    public function get_by_id($id)
    {
        $this->db->from('comprobantes');
        $this->db->join('matriculas', 'matriculas.id_matricula = comprobantes.id_matricula');
        $this->db->join('empleados', 'empleados.id_empleado = matriculas.id_empleado');
        $this->db->join('empresas', 'empleados.id_empresa = empresas.id_empresa');
        $this->db->where('id_comprobante',$id);
        $query = $this->db->get();
        return ($query->result()[0]);
    }

    //Me devuelve la lista de objetos desde la db
    public function get($hasta = null,$fechaDesde = null, $fechaHasta = null)
    {
        $this->db->from('comprobantes');
        $this->db->where('comprobantes.fecha_baja',NULL);
        if($fechaDesde!=null && $fechaHasta!=null)
        {
            $this->db->where('fecha_emision BETWEEN "'.$fechaDesde. '" and "'.$fechaHasta.'"');
        }
        $this->db->join('matriculas', 'matriculas.id_matricula = comprobantes.id_matricula');
        $this->db->join('empleados', 'empleados.id_empleado = matriculas.id_empleado');
        $this->db->join('empresas', 'empleados.id_empresa = empresas.id_empresa');
        if($hasta!=null)
        {
            $this->db->limit($hasta);
            $query = $this->db->get();
        }
        else
        {
            $query = $this->db->get();
        }
        return $query->result();
    }

    // Ejecuta una baja lógica sobre la empresa correspondiente al ID pasado como parámetro
    public function delete($id)
    {
        $this->db->set('fecha_baja', date('Y-m-d'));
        $this->db->where('id_comprobante',$id);
        $this->db->update('comprobantes');
        $this->db->close();
    }


    // Marca como paga el id pasado como parámetro
    public function ModificarPago($id)
    {
        $MComprobante = $this->get_by_id($id);
        //Si está paga la marco como impaga
        if($MComprobante->fecha_pago!=null)
        {
            $this->db->set('fecha_pago', null);

        }
        else
        {
            $this->db->set('fecha_pago', date('Y-m-d'));
        }
        $this->db->where('id_comprobante',$id);
        $this->db->update('comprobantes');
        $this->db->close();
    }

    public function GetLineasComprobantes($id)
    {
        $this->db->from('lineas_comprobantes');
        $this->db->where('lineas_comprobantes.id_comprobante',$id);
        $query = $this->db->get();
        return $query->result();
    }

    public function nuevo( $data ){
        return (
            $this->db->insert('comprobantes', $data) ?
            $this->db->insert_id() :
            FLASE;
        );
    }

}
?>