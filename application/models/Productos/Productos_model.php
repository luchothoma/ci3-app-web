<?php
class productos_model extends CI_Model {

    public $id_producto;
    public $nombre_producto;
    public $costo_producto;
    public $id_rubro;



    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }

    // Construye un objecto producto desde un array
    public function ConstructFromArray(Array $properties=array())
    {
        foreach($properties as $key => $value){
            if ($key == "costo_producto") {
                $value = str_replace(".", "", $value);
                $value = str_replace(",", ".", $value);
            }
            $this->{$key} = $value;
        }
    }

    //Devuelve un objeto desde la base de datos con un determinado id
    public function get_by_id($id)
    {
        $this->db->from('productos');
        $this->db->where('id_producto',$id);
        $this->db->join('rubros', 'rubros.id_rubro = productos.id_rubro');
        $query = $this->db->get();
        return ($query->result()[0]);
    }

    //Devuelve todas las entradas de la base de datos
    public function get($hasta = null)
    {
        $this->db->select('p.id_producto, p.nombre_producto, p.costo_producto, r.nombre_rubro');
        $this->db->from('productos p');
        $this->db->where('fecha_baja',null);
        $this->db->join('rubros r', 'r.id_rubro = p.id_rubro');
        $query = $this->db->get();
        return $query->result();
    }

    //Devuelve todos los productos de un rubro particular
    public function getByRubro( $idRubro )
    {
        $this->db->select('p.id_producto, p.nombre_producto, p.costo_producto');
        $this->db->from('productos p');
        $this->db->where('fecha_baja', null);
        $this->db->where('p.id_rubro', $idRubro);
        $query = $this->db->get();
        return $query->result();
    }

    //Control de duplicados
    private function ExisteProducto($nombre, $id = null)
    {
        if ($id != null) {
            $this->db->where('id_producto !=',$id);
        }
        $this->db->where('nombre_producto',$nombre);
        $this->db->where('fecha_baja',null);
        $query = $this->db->get('productos');
        if ($query->num_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    // Guarda el producto en la base de datos
    public function save()
    {
        if(!$this->ExisteProducto($this->nombre_producto))
        {
            $this->db->insert('productos', $this);
            $this->db->close();
            return ['success','Operacion realizada con éxito'];
        }
        else
            return ['error','El producto a registrar ya existe'];
    }

    // Modifica un producto en la base de datos
    public function update()
    {
        if(!$this->ExisteProducto($this->nombre_producto, $this->id_producto))
        {
            $this->db->set('nombre_producto', $this->nombre_producto);
            $this->db->set('costo_producto', $this->costo_producto);
            $this->db->set('id_rubro', $this->id_rubro);
            $this->db->where('id_producto',$this->id_producto);
            $this->db->update('productos');
            $this->db->close();
            return ['success','Operacion realizada con éxito'];
        }
        else
            return ['error','El producto a registrar ya existe', $this->id_producto];    }


    // Baja logicamente un producto en la base de datos
    public function delete($id)
    {
        $this->db->set('fecha_baja', date('Y-m-d'));
        $this->db->where('id_producto',$id);
        $this->db->update('productos');
        $this->db->close();
        return ['success','Operacion realizada con éxito'];
    }
}
?>