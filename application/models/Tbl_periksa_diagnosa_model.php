<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tbl_periksa_diagnosa_model extends CI_Model
{
    public $table = 'tbl_periksa_diagnosa';

    public function insert($val)
    {
        $this->db->insert($this->table, $val);
    }

    public function get_by_no_periksa($id)
    {
        $this->db->select('tbl_periksa_diagnosa.*, tbl_diagnosa_icd10.diagnosa');
        $this->db->from('tbl_periksa_diagnosa');
        $this->db->join('tbl_diagnosa_icd10', 'tbl_diagnosa_icd10.id_diagnosa = tbl_periksa_diagnosa.id_diagnosa');
        $this->db->where('tbl_periksa_diagnosa.no_periksa', $id);
        return $this->db->get();
    }
}
