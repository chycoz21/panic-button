<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fitur extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->data_funding = $this->db->get_where('tb_laporan', array('laporan' => 'Funding Officer'))->result_array();
        $this->data_teller = $this->db->get_where('tb_laporan', array('laporan' => 'Teller'))->result_array();
        $this->data_other = $this->db->get_where('tb_laporan', array('laporan' => 'Other'))->result_array();

        $this->peta_funding = $this->db->get_where('tb_laporan', array('laporan' => 'Funding Officer'))->result();
        $this->peta_teller = $this->db->get_where('tb_laporan', array('laporan' => 'Teller'))->result();
        $this->peta_other= $this->db->get_where('tb_laporan', array('laporan' => 'Other'))->result();
    }

    public function funding()
    {
        $data = [
            'title' => 'Laporan Funding',
            'tombol' => 'Funding',
            'peta' => 'fitur/peta_funding/',
            'hapus' => 'hapus_funding/'
        ];
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        $data['data_laporan'] = $this->data_funding;

        $this->template->halaman('fitur/data_laporan', $data);
    }

    public function teller()
    {
        $data = [
            'title' => 'Laporan Teller',
            'tombol' => 'Teller',
            'peta' => 'fitur/peta_teller/',
            'hapus' => 'hapus_teller/'
        ];
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        $data['data_laporan'] = $this->data_teller;

        $this->template->halaman('fitur/data_laporan', $data);
    }

    public function other()
    {
        $data = [
            'title' => 'Pelayanan Other',
            'tombol' => 'Other',
            'peta' => 'fitur/peta_other/',
            'hapus' => 'hapus_other/'
        ];
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        $data['data_laporan'] = $this->data_other;

        $this->template->halaman('fitur/data_laporan', $data);
    }

    public function hapus_funding($id)
    {
        $this->Fitur_model->hapusLaporan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert-st-three alert-st-bg2" role="alert">
        <i class="fa fa-exclamation-triangle edu-warning-danger admin-check-pro admin-check-pro-clr2" aria-hidden="true"></i>
        <p class="message-mg-rt">Data Laporan berhasil dihapus!</p></div>');
        $this->session->set_flashdata('flash', 'Data Laporan berhasil dihapus!');
        redirect('fitur/funding');
    }

    public function hapus_teller($id)
    {
        $this->Fitur_model->hapusLaporan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert-st-three alert-st-bg2" role="alert">
        <i class="fa fa-exclamation-triangle edu-warning-danger admin-check-pro admin-check-pro-clr2" aria-hidden="true"></i>
        <p class="message-mg-rt">Data Laporan berhasil dihapus!</p></div>');
        $this->session->set_flashdata('flash', 'Data Laporan berhasil dihapus!');
        redirect('fitur/teller');
    }

    public function hapus_other($id)
    {
        $this->Fitur_model->hapusLaporan($id);
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert-st-three alert-st-bg2" role="alert">
        <i class="fa fa-exclamation-triangle edu-warning-danger admin-check-pro admin-check-pro-clr2" aria-hidden="true"></i>
        <p class="message-mg-rt">Data Laporan berhasil dihapus!</p></div>');
        $this->session->set_flashdata('flash', 'Data Laporan berhasil dihapus!');
        redirect('fitur/other');
    }

    public function peta_funding()
    {
        $data = [
            'title' => 'Peta Seluruh Laporan panic funding',
            'kembali' => 'fitur/funding/'
        ];
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        $config['zoom'] = 'auto';
        $config['map_type'] = 'HYBRID';
        $this->googlemaps->initialize($config);
        foreach ($this->peta_funding as $key => $value) :
            $marker = array();
            $marker['position'] = "{$value->latitude}, {$value->longitude}";
            $marker['infowindow_content'] = '<div class="media" style="width:300px;">';
            $marker['infowindow_content'] .= '<div class="media-left">';
            $marker['infowindow_content'] .= '</div>';
            $marker['infowindow_content'] .= '<div class="media-body">';
            $marker['infowindow_content'] .= '<h5 class="media-heading">Laporan ' . $value->laporan . '</h5>';
            $marker['infowindow_content'] .= '<p><b>Waktu Kejadian :</b> ' . $value->waktu . '</p>';
            $marker['infowindow_content'] .= '<p><b>Lokasi Kejadian :</b> ' . $value->lokasi . '</p>';
            $marker['infowindow_content'] .= '<p><b>Keterangan :</b> ' . $value->ket . '</p><br>';
            $marker['infowindow_content'] .= '</div>';
            $marker['infowindow_content'] .= '</div>';
            $marker['icon'] = '';
            $this->googlemaps->add_marker($marker);
        endforeach;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $this->template->halaman('fitur/peta_laporan', $data);
    }

    public function peta_teller()
    {
        $data = [
            'title' => 'Peta Seluruh Laporan Panic Teller',
            'kembali' => 'fitur/teller/'
        ];
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        $config['zoom'] = 'auto';
        $config['map_type'] = 'HYBRID';
        $this->googlemaps->initialize($config);
        foreach ($this->peta_kebakaran as $key => $value) :
            $marker = array();
            $marker['position'] = "{$value->latitude}, {$value->longitude}";
            $marker['infowindow_content'] = '<div class="media" style="width:300px;">';
            $marker['infowindow_content'] .= '<div class="media-left">';
            $marker['infowindow_content'] .= '</div>';
            $marker['infowindow_content'] .= '<div class="media-body">';
            $marker['infowindow_content'] .= '<h5 class="media-heading">Laporan ' . $value->laporan . '</h5>';
            $marker['infowindow_content'] .= '<p><b>Waktu Kejadian :</b> ' . $value->waktu . '</p>';
            $marker['infowindow_content'] .= '<p><b>Lokasi Kejadian :</b> ' . $value->lokasi . '</p>';
            $marker['infowindow_content'] .= '<p><b>Keterangan :</b> ' . $value->ket . '</p><br>';
            $marker['infowindow_content'] .= '</div>';
            $marker['infowindow_content'] .= '</div>';
            $marker['icon'] = '';
            $this->googlemaps->add_marker($marker);
        endforeach;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $this->template->halaman('fitur/peta_laporan', $data);
    }

    public function peta_other()
    {
        $data = [
            'title' => 'Peta Seluruh Layanan Panic Other',
            'kembali' => 'fitur/other/'
        ];
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        $config['zoom'] = 'auto';
        $config['map_type'] = 'HYBRID';
        $this->googlemaps->initialize($config);
        foreach ($this->peta_ambulans as $key => $value) :
            $marker = array();
            $marker['position'] = "{$value->latitude}, {$value->longitude}";
            $marker['infowindow_content'] = '<div class="media" style="width:300px;">';
            $marker['infowindow_content'] .= '<div class="media-left">';
            $marker['infowindow_content'] .= '</div>';
            $marker['infowindow_content'] .= '<div class="media-body">';
            $marker['infowindow_content'] .= '<h5 class="media-heading">Laporan ' . $value->laporan . '</h5>';
            $marker['infowindow_content'] .= '<p><b>Waktu Kejadian :</b> ' . $value->waktu . '</p>';
            $marker['infowindow_content'] .= '<p><b>Lokasi Kejadian :</b> ' . $value->lokasi . '</p>';
            $marker['infowindow_content'] .= '<p><b>Keterangan :</b> ' . $value->ket . '</p><br>';
            $marker['infowindow_content'] .= '</div>';
            $marker['infowindow_content'] .= '</div>';
            $marker['icon'] = '';
            $this->googlemaps->add_marker($marker);
        endforeach;

        $this->googlemaps->initialize($config);

        $data['map'] = $this->googlemaps->create_map();

        $this->template->halaman('fitur/peta_laporan', $data);
    }

    public function giat()
    {
        $data['title'] = 'Laporan Giat';
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
        $data['kendaraan'] = $this->db->get('tb_kendaraan')->result_array();
        $data['anggota'] = $this->db->get('tb_user')->result_array();
        $data['rumah_sakit'] = $this->db->get('tb_rs')->result_array();

        $this->form_validation->set_rules('kegiatan', 'Nama Kegiatan', 'required');
        $this->form_validation->set_rules('waktu', 'Tanggal dan Jam', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        $this->form_validation->set_rules('penanganan', 'Penanganan', 'required');
        $this->form_validation->set_rules('koordinator', 'Koordinator', 'required');
        $this->form_validation->set_rules('kendaraan', 'Kendaraan Operasional', 'required');

        if ($this->form_validation->run() == false) {
            $this->template->halaman('fitur/giat', $data);
        } else {
            $this->Fitur_model->tambahGiat();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-st-one alert-st-bg" role="alert">
            <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro-clr" aria-hidden="true"></i>
            <p class="message-mg-rt">Laporan giat berhasil ditambahkan!</p></div>');
            $this->session->set_flashdata('flash', 'Laporan giat berhasil ditambahkan!');
            redirect('fitur/data_giat');
        }
    }

    public function data_giat()
    {
        $data['title'] = 'Data Kegiatan';
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
        
        $data['laporan_giat'] = $this->Fitur_model->getDataGiat();
        
        $this->template->halaman('fitur/data_giat', $data);
    }

    public function hapus_giat($id)
    {
        $this->Fitur_model->hapusGiat($id);
        $this->session->set_flashdata('message', '<div class="alert alert-warning alert-st-three alert-st-bg2" role="alert">
        <i class="fa fa-exclamation-triangle edu-warning-danger admin-check-pro admin-check-pro-clr2" aria-hidden="true"></i>
        <p class="message-mg-rt">Data Giat berhasil dihapus!</p></div>');
        $this->session->set_flashdata('flash', 'Data Giat berhasil dihapus!');
        redirect('fitur/data_giat');
    }

    public function data_korban($id)
    {
        $data['title'] = 'Data Korban';
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
        
        $data['data_korban'] = $this->db->get_where('tb_korban', ['id_giat' => $id])->result_array();

        $this->template->halaman('fitur/data_korban', $data);
    }
}
