<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Periksa_model extends CI_Model
{

    public $table = 'tbl_periksa';
    public $id = 'no_periksa';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    function get_all_by_id($id)
    {
        $this->db->where('no_rekam_medis', $id);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id, $select = "")
    {
        if ($select != "") {
            $this->db->select($select);
        }
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_d_fisik_by_id($id, $tipe = null)
    {
        if ($tipe != null) {
            $this->db->where($this->id, $id);
            $this->db->where('nama_periksa_fisik', $tipe);
        } else {
            $this->db->where($this->id, $id);
        }

        return $this->db->get('tbl_periksa_d_fisik')->result();
    }

    function get_d_obat_by_id($id, $identify = false)
    {
        $this->db->select('*');
        // $this->db->select('tbl_periksa_d_obat.*, tbl_obat_alkes_bhp.nama_barang');
        $this->db->from('tbl_periksa_d_obat');
        $this->db->join('tbl_obat_alkes_bhp', 'tbl_periksa_d_obat.kode_barang = tbl_obat_alkes_bhp.kode_barang');
        $this->db->where($this->id, $id);
        if ($identify == true) {
            return $this->db->get();
        } else {
            return $this->db->get()->result();
        }
    }

    function get_d_obat_tebus_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_periksa_d_obat');
        $this->db->join('tbl_obat_alkes_bhp', 'tbl_periksa_d_obat.kode_barang = tbl_obat_alkes_bhp.kode_barang');
        $this->db->where($this->id, $id);
        $this->db->where('is_tebus', 1);
        return $this->db->get()->result();
    }

    function get_d_alkes_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_periksa_d_alkes');
        $this->db->join('tbl_obat_alkes_bhp', 'tbl_periksa_d_alkes.kode_barang = tbl_obat_alkes_bhp.kode_barang');
        $this->db->where($this->id, $id);
        return $this->db->get()->result();
    }

    function insert($data, $data_d_alkes, $data_d_obat, $data_d_fisik)
    {
        if ($data != null) {
            $this->db->insert($this->table, $data);
        }

        for ($i = 0; $i < count($data_d_alkes); $i++) {
            $this->db->insert('tbl_periksa_d_alkes', $data_d_alkes[$i]);
        }

        for ($i = 0; $i < count($data_d_obat); $i++) {
            $this->db->insert('tbl_periksa_d_obat', $data_d_obat[$i]);
        }

        for ($i = 0; $i < count($data_d_fisik); $i++) {
            $this->db->insert('tbl_periksa_d_fisik', $data_d_fisik[$i]);
        }
    }
    public function getLastNomor()
    {
        $this->db->select('nomor_skt');
        $this->db->order_by('nomor_skt', 'desc');
        $this->db->limit(1);
        return $this->db->get($this->table, ['MONTH(dtm_crt)' => date('m'), 'YEAR(dtm_crt)' => date('Y')])->result();
    }

    function insert_periksa_d_alkes($data)
    {
        $this->db->insert('tbl_periksa_d_alkes', $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function update_periksa_d_obat($id, $data)
    {
        $this->db->where('id_periksa_d_obat', $id);
        $this->db->update('tbl_periksa_d_obat', $data);
    }

    // datatables
    function json($no_rekam_medis = null)
    {
        $this->datatables->select('dtm_crt as tgl_periksa, no_periksa,anamnesi,diagnosa,obat_detail');
        $this->datatables->from('tbl_periksa');

        if ($no_rekam_medis != null)
            $this->datatables->where('no_rekam_medis', $no_rekam_medis);
        // $this->datatables->add_column('action',anchor(site_url('periksamedis/detail?id=$1'),'Detail', array('class' => 'btn btn-danger btn-sm','target'=>'_blank')),'no_periksa');
        return $this->datatables->generate();
    }

    function json_riwayat($id_dokter = null)
    {
        // $this->datatables->select('MAX(p.no_rekam_medis) AS no_rekam_medis, MAX(p.no_periksa) as no_periksa, MAX(ps.nama_lengkap) as nama_pasien, MAX(k.nama) as klinik, MAX(d.nama_dokter) as nama_dokter, MAX(p.anamnesi) AS anamnesi, MAX(p.diagnosa) AS diagnosa, MAX(p.tindakan) AS tindakan, MAX(p.obat_detail) AS obat_detail, MAX(p.dtm_crt) as tgl_periksa,(CASE MAX(p.is_ambil_obat) WHEN 1 THEN "Selesai" ELSE "Obat Belum Diambil" END) as status, (CASE MAX(p.is_surat_ket_sakit) WHEN 1 THEN "" ELSE "disabled" END) as is_cetak');
        // $this->datatables->from('tbl_periksa p');
        // $this->datatables->join('tbl_pasien ps','p.no_rekam_medis=ps.no_rekam_medis','left');
        // $this->datatables->join('tbl_pendaftaran pd','p.no_pendaftaran=pd.no_pendaftaran','left');
        // $this->datatables->join('tbl_klinik k','pd.id_klinik=k.id_klinik','left');
        // $this->datatables->join('tbl_dokter d','p.id_dokter=d.id_dokter','left');
        // $this->datatables->group_by('p.no_rekam_medis');
        // $this->datatables->add_column('action',anchor(site_url('periksamedis/riwayat_detail/$1'),'Detail', array('class' => 'btn btn-info btn-sm')),'no_rekam_medis');

        // if($id_dokter != null)
        //     $this->datatables->where('p.id_dokter',$id_dokter);
        // return $this->datatables->generate();
        // $data=$this->db->query('SELECT MAX(p.no_rekam_medis) AS no_rekam_medis, MAX(p.no_periksa) AS no_periksa, MAX(ps.nama_lengkap) as nama_pasien, MAX(k.nama) as klinik, MAX(d.nama_dokter) as nama_dokter, MAX(p.anamnesi) AS anamnesi, MAX(p.diagnosa) AS diagnosa, MAX(p.tindakan) AS tindakan, MAX(p.obat_detail) AS obat_detail, MAX(p.dtm_crt) as tgl_periksa,(CASE MAX(p.is_ambil_obat) WHEN 1 THEN "Selesai" ELSE "Obat Belum Diambil" END) as status, (CASE MAX(p.is_surat_ket_sakit) WHEN 1 THEN "" ELSE "disabled" END) as is_cetak
        //     FROM `tbl_periksa` `p`
        //     LEFT JOIN `tbl_pasien` `ps` ON `p`.`no_rekam_medis`=`ps`.`no_rekam_medis`
        //     LEFT JOIN `tbl_pendaftaran` `pd` ON `p`.`no_pendaftaran`=`pd`.`no_pendaftaran`
        //     LEFT JOIN `tbl_klinik` `k` ON `pd`.`id_klinik`=`k`.`id_klinik`
        //     LEFT JOIN `tbl_dokter` `d` ON `p`.`id_dokter`=`d`.`id_dokter`
        //     '.($id_dokter != 0 ? "WHERE `p`.`id_dokter` = ".$id_dokter : "").'
        //     GROUP BY `p`.`no_rekam_medis`')->result();
        // return $data;
        // $this->datatables->select('MAX(p.no_rekam_medis) AS no_rekam_medis, MAX(p.no_periksa) AS no_periksa, MAX(ps.nama_lengkap) as nama_pasien, MAX(k.nama) as klinik, MAX(d.nama_dokter) as nama_dokter, MAX(p.anamnesi) AS anamnesi, MAX(p.diagnosa) AS diagnosa, MAX(p.tindakan) AS tindakan, MAX(p.obat_detail) AS obat_detail, MAX(DATE_FORMAT(p.dtm_crt, "%Y-%m-%d")) as tgl_periksa,(CASE MAX(p.is_ambil_obat) WHEN 1 THEN "Selesai" ELSE "Obat Belum Diambil" END) as status, (CASE MAX(p.is_surat_ket_sakit) WHEN 1 THEN "" ELSE "disabled" END) as is_cetak, ps.nama_lengkap');
        $this->datatables->select('p.no_rekam_medis, DATE_FORMAT(p.dtm_crt, "%Y-%m-%d") as tgl_periksa, p.diagnosa, d.nama_dokter, k.nama as klinik,ps.nama_lengkap');
        $this->datatables->from('tbl_periksa p');
        $this->datatables->join('tbl_pasien ps', 'p.no_rekam_medis = ps.no_rekam_medis', 'left');
        $this->datatables->join('tbl_pendaftaran pd', 'p.no_pendaftaran = pd.no_pendaftaran', 'left');
        $this->datatables->join('tbl_klinik k', 'pd.id_klinik = k.id_klinik', 'left');
        $this->datatables->join('tbl_dokter d', 'p.id_dokter = d.id_dokter', 'left');
        // $this->datatables->add_column('action',anchor(site_url('periksamedis/riwayat_detail/$1'),'View', array('class' => 'btn waves-effect waves-light btn-xs btn-success')),'no_rekam_medis');
        $this->datatables->add_column(
            'action',
            anchor(site_url('periksamedis/edit?id=$2'), 'Edit', array('class' => 'btn btn-warning btn-sm')) . " " . anchor(site_url('periksamedis/viewRiwayat?tipe=view&id=$1&no_periksa=$2'), 'View', 'class="btn btn-info btn-sm" target="_blank"') . " " . anchor(site_url('periksamedis/viewRiwayat?tipe=print&id=$1&no_periksa=$2'), 'Print', 'class="btn btn-success btn-sm" target="_blank"'),
            'no_rekam_medis,no_periksa'
        );
        if ($id_dokter != 0 && $id_dokter != null) {
            $this->datatables->where('p.id_dokter', $id_dokter);
        }
        $this->datatables->group_by('p.no_rekam_medis');
        return $this->datatables->generate();
    }

    function json_riwayat_detail($id_dokter = null, $no_rekam_medis)
    {
        $this->datatables->select('p.no_periksa, ps.nama_lengkap as nama_pasien, k.nama as klinik, d.nama_dokter as nama_dokter, p.anamnesi, p.diagnosa, p.tindakan, p.obat_detail,p.dtm_crt as tgl_periksa,(CASE p.is_ambil_obat WHEN 1 THEN "Selesai" ELSE "Obat Belum Diambil" END) as status, (CASE p.is_surat_ket_sakit WHEN 1 THEN "" ELSE "hidden" END) as is_cetak');
        $this->datatables->from('tbl_periksa p');
        $this->datatables->join('tbl_pasien ps', 'p.no_rekam_medis=ps.no_rekam_medis', 'left');
        $this->datatables->join('tbl_pendaftaran pd', 'p.no_pendaftaran=pd.no_pendaftaran', 'left');
        $this->datatables->join('tbl_klinik k', 'pd.id_klinik=k.id_klinik', 'left');
        $this->datatables->join('tbl_dokter d', 'p.id_dokter=d.id_dokter', 'left');
        $this->datatables->where('p.no_rekam_medis', $no_rekam_medis);
        $this->datatables->add_column('action',/*anchor(site_url('periksamedis/detail?id=$1'),'Detail', array('class' => 'btn btn-danger btn-sm','target'=>'_blank')) ." ".*/ anchor(site_url('periksamedis/cetak_surat_ket_sakit?id=$1'), 'Cetak Surat Ket. Sakit', array('class' => 'btn btn-info btn-sm $2', 'target' => '_blank')), 'no_periksa,is_cetak');

        if ($id_dokter != 0)
            $this->datatables->where('p.id_dokter', $id_dokter);
        return $this->datatables->generate();
    }

    function get_cek_fisik()
    {
        $this->db->select('*');
        $this->db->from('tbl_cek_fisik');
        return $this->db->get()->result();
    }

    function get_edit($id)
    {
        $this->db->select('tbl_periksa.*, tbl_pendaftaran.id_klinik, tbl_pasien.nama_lengkap, tbl_pasien.alamat, tbl_pasien.kabupaten, tbl_pasien.rt, tbl_pasien.rw');
        $this->datatables->from('tbl_periksa');
        $this->datatables->join('tbl_pasien', 'tbl_periksa.no_rekam_medis=tbl_pasien.no_rekam_medis', 'left');
        $this->datatables->join('tbl_pendaftaran', 'tbl_periksa.no_pendaftaran=tbl_pendaftaran.no_pendaftaran', 'left');
        $this->db->where('tbl_periksa.no_periksa', $id);
        return $this->db->get($this->table)->row();
    }

    // get data by id
    function get_by_id_limit_1($id)
    {
        $this->db->order_by('no_pendaftaran', $this->order);
        $this->db->where('no_pendaftaran', $id);
        return $this->db->get($this->table)->row();
    }
}
