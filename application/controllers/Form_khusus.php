<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Form_khusus extends CI_Controller
{
    public $id_klinik;
    
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Pendaftaran_model');
        $this->load->model('Pendaftaran_online_model');
		$this->load->model('Master_sequence_model');
		$this->load->model('Tbl_dokter_model');
		$this->load->model('Tbl_pasien_model');
		$this->load->model('User_model');
		$this->load->model('Tbl_wilayah_model');
		$this->load->library('form_validation');
		$this->load->library('datatables');
		
		$this->id_klinik = $this->session->userdata('id_klinik');
    }

    public function index()
    {
        $this->template->load('template','form_khusus/form_khusus_list');
    }
    public function preview($noDaftar)
    {
        $this->db->select('p.*');
        $this->db->from('tbl_pendaftaran pd');
        $this->db->join('tbl_pasien p','pd.no_rekam_medis = p.no_rekam_medis');
        $this->db->where('pd.no_pendaftaran',$noDaftar);
        $data['data'] = $this->db->get()->row();

        if($_GET['form']=='1'){
            $filename = "surat-rujukan";
        }
        else if($_GET['form']=='2'){
            $filename = "blanko-resep";
        }
        else if($_GET['form']=='3'){
            $filename = "kartu-pasien";
        }
        $this->load->view('form-khusus/'.$filename,$data);
        


        if($_GET['act']=='doc'){
            header("Content-type: application/msword");
            header("Content-disposition: inline; filename=$filename-$noDaftar.doc");
        }else if($_GET['act']=='print'){
            echo "<script>window.print()</script>";
        }
    }
}