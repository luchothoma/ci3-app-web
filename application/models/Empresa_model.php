<?php
class Empresa_model extends CI_Model {

    public $id_empresa;
    public $email_empresa;
    public $nombre_empresa;
    public $direccion_empresa;
    public $CUIT;
    public $fecha_registro;
    public $id_localidad;
    public $descuento_empresa;



    public function __construct()
    {
            parent::__construct();
            // Your own constructor code
    }

    // Construye un objecto empresa desde un array
    public function ConstructFromArray(Array $properties=array())
    {
        foreach($properties as $key => $value){
            $this->{$key} = $value;
        }
    }

    //Devuelve un objeto desde la base de datos con un determinado id
    public function get_by_id($id)
    {
        $this->db->from('empresas');
        $this->db->where('id_empresa',$id);
        $this->db->join('localidades', 'localidades.id_localidad = empresas.id_localidad');
        $this->db->join('departamentos', 'localidades.id_departamento = departamentos.id_departamento');
        $this->db->join('provincias', 'departamentos.id_provincia = provincias.id_provincia');
        $query = $this->db->get();
        return ($query->result()[0]);
    }

    //Me devuelve la lista de objetos desde la db
    public function get($hasta = null)
    {
        $this->db->from('empresas');
        $this->db->where('fecha_baja',null);
        $this->db->join('localidades', 'localidades.id_localidad = empresas.id_localidad');
        $this->db->join('departamentos', 'localidades.id_departamento = departamentos.id_departamento');
        $this->db->join('provincias', 'departamentos.id_provincia = provincias.id_provincia');
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

    private function existeMail($mail = null)
    {
        $valor = false;
        if($mail==null)
        {
            $mail = $this->email_empresa;
        }
        $this->db->where('email_empresa',$mail);
        $query = $this->db->get('empresas');
        if ($query->num_rows() > 0){
            // Si no es la misma empresa.
            if($query->result()[0]->id_empresa != $this->id_empresa)
            {
                $valor=true;
            }
        }
        return $valor;
    }

    // Guarda la instancia en la base de datos
    public function save()
    {
        if(!$this->existeMail())
        {
            $this->fecha_registro=date("Y-m-d H:i:s");
            $this->descuento_empresa = str_replace(",",".",$this->descuento_empresa);
            $this->db->insert('empresas', $this);
            $this->db->close();
            return ['success','La empresa ha sido registrado con éxito'];
        }
        else
        {
            return ['error','El email ya se encuentra registrado'];
        }
    }

    // Modifica una instancia en la base de datos
    public function update()
    {
        if(!$this->existeMail($this->email_empresa))
        {
            $this->db->set('nombre_empresa', $this->nombre_empresa);
            $this->db->set('email_empresa', $this->email_empresa);
            $this->db->set('direccion_empresa', $this->direccion_empresa);
            $this->db->set('descuento_empresa', str_replace(",",".",$this->descuento_empresa));
            $this->db->where('id_empresa',$this->id_empresa);
            $this->db->update('empresas');
            $this->db->close();
            return ['success','La empresa ha sido modificada con éxito'];
        }
        else
        {
            return ['error','El email ya se encuentra registrado'];
        }
    }


    // Ejecuta una baja lógica sobre la empresa correspondiente al ID pasado como parámetro
    public function delete($id)
    {
        $this->db->set('fecha_baja', date('Y-m-d'));
        $this->db->where('id_empresa',$id);
        $this->db->update('empresas');
        $this->db->close();
    }

}
?>