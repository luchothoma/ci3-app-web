<?php
class Rubros_model extends CI_Model {

    public $id_rubro;
    public $nombre_rubro;



    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }

    // Construye un objecto rubro desde un array
    public function ConstructFromArray(Array $properties=array())
    {
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }

    //Devuelve un objeto desde la base de datos con un determinado id
    public function get_by_id($id)
    {
        $this->db->from('rubros');
        $this->db->where('id_rubro',$id);
        $query = $this->db->get();
        return ($query->result()[0]);
    }

    //Devuelve todas las entradas de la base de datos
    public function get($hasta = null)
    {
        $this->db->select('r.id_rubro, r.nombre_rubro');
        $this->db->from('rubros r');
        $query = $this->db->get();
        return $query->result();
    }

    // Guarda el rubro en la base de datos
    public function save()
    {
        $this->fecha_registro=date("Y-m-d H:i:s");
        $this->db->insert('rubros', $this);
        $this->db->close();
        return ['success','Operacion realizada con éxito'];
    }

    // Modifica un rubro en la base de datos
    public function update()
    {
            $this->db->set('nombre_rubro', $this->nombre_producto);
            $this->db->where('id_rubro', $this->id_rubro);
            $this->db->update('rubros');
            $this->db->close();
            return ['success','Operacion realizada con éxito'];
    }


    // Baja fisicamente un rubro en la base de datos
    public function delete($id)
    {
        $this->db->where('id_rubro',$id);
        $this->db->delete('rubros');
        $this->db->close();
        return ['success','Operacion realizada con éxito'];
    }
}
?>