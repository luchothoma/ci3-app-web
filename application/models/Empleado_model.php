<?php
class Empleado_model extends CI_Model {

    public $id_empleado;
    public $DNI;
    public $nombre_empleado;
    public $fecha_registro;
    public $id_empresa;
    public $descuento_empresa;
    public $descuento_personal;
    public $fecha_baja;
    public $codigo;

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
        $this->db->from('empleados');
        $this->db->where('id_empleado',$id);
        $query = $this->db->get();
        return ($query->result()[0]);
    }

    //Me devuelve la lista de objetos desde la db
    public function get($hasta = null, $whereArray = null)
    {
        $this->db->from('empleados');
        $this->db->where('empleados.fecha_baja',NULL);
        $this->db->join('empresas', 'empleados.id_empresa = empresas.id_empresa');
        if( ! is_null($whereArray) )
        {
            $this->db->where($whereArray);
        }
        if( ! is_null($hasta) )
        {
            $this->db->limit($hasta);
        }
        $query = $this->db->get();
        return $query->result();
    }

    // Guarda la instancia en la base de datos
    public function save()
    {
        if(!$this->existeDNI())
        {
            $this->fecha_registro=date("Y-m-d H:i:s");
            $this->descuento_empresa = str_replace(",",".",$this->descuento_empresa);
            $this->descuento_personal = str_replace(",",".",$this->descuento_personal);
            $this->db->insert('empleados', $this);
            $this->db->close();
            return ['success','El empleado ha sido registrado con éxito'];
        }
        else
        {
            return ['error','El DNI ya se encuentra registrado'];
        }

    }

    // Modifica una instancia en la base de datos
    public function update()
    {
        if(!$this->existeDNI())
        {
            $this->db->set('codigo', $this->codigo);
            $this->db->set('DNI', $this->DNI);
            $this->db->set('nombre_empleado', $this->nombre_empleado);
            $this->db->set('descuento_personal', str_replace(",",".",$this->descuento_personal));
            $this->db->set('descuento_empresa', str_replace(",",".",$this->descuento_empresa));
            $this->db->where('id_empleado',$this->id_empleado);
            $this->db->update('empleados');
            $this->db->close();
            return ['success','El empleado ha sido modificado con éxito'];
        }
        else {
            return ['error', 'El DNI ya se encuentra registrado'];
        }
    }


    // Ejecuta una baja lógica sobre la empresa correspondiente al ID pasado como parámetro
    public function delete($id)
    {
        $this->db->set('fecha_baja', date('Y-m-d'));
        $this->db->where('id_empleado',$id);
        $this->db->update('empleados');
        $this->db->close();
    }


    //Verifica el DNI con el objeto instanciado.
    private function existeDNI()
    {
        $valor = false;
        $this->db->where('DNI',$this->DNI);
        $this->db->where('fecha_baja',null);
        $query = $this->db->get('empleados');
        if ($query->num_rows() > 0){
            // Si no es el mismo empleado.
            if($query->result()[0]->id_empleado != $this->id_empleado)
            {
                $valor=true;
            }
        }
        return $valor;
    }

}
?>