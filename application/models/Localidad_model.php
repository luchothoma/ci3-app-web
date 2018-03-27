<?php
class Localidad_model extends CI_Model {

        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }

    public function get($hasta = null)
    {
        $this->db->from('localidades');
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
}
?>