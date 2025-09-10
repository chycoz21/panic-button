<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Layanan extends CI_Controller
{
    public function index()
    {
    $data['title'] = 'PANIC BUTTON';
    
    $this->template->layanan('layanan/index', $data);
    }

    public function funding()
    {
        $data = [
            'title' => 'Funding Panic',
            'info' => 'Tetap tenang dan laporkan kejadian.',
            'laporan' => 'Funding Officer',
            'lokasi' => 'Komplek Villa 1 dekat indomaret km 15',
            'ket' => 'Korban 2 orang mengalami luka luka nama officer:'
        ];
        
        $this->form_validation->set_rules('lokasi', 'Lokasi Kejadian', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'required');
        
        $idTerakhir = $this->Layanan_model->getIdTerakhir();
        $id = $idTerakhir + 1;
        
        if ($this->form_validation->run() == false) {
            $this->template->layanan('layanan/form_laporan', $data);
        } else {
            $this->Layanan_model->tambahLaporan($data);
            $this->session->set_flashdata('message', '<div class="alert alert-info alert-st-two" role="alert">
            <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro" aria-hidden="true"></i>
            <p class="message-mg-rt" style="font-size: 18px;"><b>Laporan anda berhasil dikirim!</b></p></div>');
            $this->session->set_flashdata('flash', 'Laporan anda berhasil dikirim!');
            redirect('layanan/hasil_laporan/'.$id);
        }
    }

    public function teller()
    {
        $data = [
            'title' => 'Teller Panic',
            'info' => 'Tetap tenang dan laporkan kejadian.',
            'laporan' => 'Teller',
            'lokasi' => '', // Lokasi akan dipilih melalui radio button
            'lokasi_options' => [ // Pilihan lokasi untuk radio button
                'Bank IBU Pusat Kota Bangun',
                'Bank IBU Cabang Samarinda',
                'Bank IBU cabang Kembang Janggut',
            ],
            'ket' => '', // Lokasi akan dipilih melalui radio button
            'ket_options' => [ // Pilihan lokasi untuk radio button
                'Perampokan',
                'Ancaman dengan senjata',
                'Pemerasan / Penipuan',
                'Butuh Bantuan Keamanan (urgent)'
            ]
        ];
        
        $this->form_validation->set_rules('lokasi', 'Lokasi Kejadian', 'required');
    
        $idTerakhir = $this->Layanan_model->getIdTerakhir();
        $id = $idTerakhir + 1;
    
        if ($this->form_validation->run() == false) {
            $this->template->layanan('layanan/form_laporan', $data);
        } else {
            $data_input = [
                'laporan' => 'Teller',
                'lokasi' => $this->input->post('lokasi'),
                'ket' => $this->input->post('ket'),
            ];
            
            $this->Layanan_model->tambahLaporan($data_input);
            $this->session->set_flashdata('message', '<div class="alert alert-info alert-st-two" role="alert">
            <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro" aria-hidden="true"></i>
            <p class="message-mg-rt" style="font-size: 18px;"><b>Laporan anda berhasil dikirim!</b></p></div>');
            redirect('layanan/hasil_laporan/'.$id);
        }
    }
    

    public function other()
    {
        $data = [
            'title' => 'Other Panic',
            'info' => 'Tetap tenang dan laporkan kejadian.',
            'laporan' => 'Other',
            'lokasi' => 'Terjadi kebakaran dekat kantor',
            'ket' => 'Dibutuhkan pemadam kebakaran'
        ];
        
        $this->form_validation->set_rules('lokasi', 'Lokasi Kejadian', 'required');
        $this->form_validation->set_rules('ket', 'Keterangan', 'required');
        
        $idTerakhir = $this->Layanan_model->getIdTerakhir();
        $id = $idTerakhir + 1;
        
        if ($this->form_validation->run() == false) {
            $this->template->layanan('layanan/form_laporan', $data);
        } else {
            $this->Layanan_model->tambahLaporan($data);
            $this->session->set_flashdata('message', '<div class="alert alert-info alert-st-two" role="alert">
            <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro" aria-hidden="true"></i>
            <p class="message-mg-rt" style="font-size: 18px;"><b>Laporan anda berhasil dikirim!</b></p></div>');
            $this->session->set_flashdata('flash', 'Laporan anda berhasil dikirim!');
            redirect('layanan/hasil_laporan/'.$id);
        }
    }

    public function hasil_laporan($id)
    {
        $data['title'] = 'Hasil Laporan';
        $data['laporan'] = $this->Layanan_model->getLaporanById($id);

        $config['zoom'] = 'auto';
        $config['map_height'] = '500px';
        $config['map_type'] = 'HYBRID';
        $this->googlemaps->initialize($config);
        foreach ($this->Layanan_model->maps($id) as $key => $value) :
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

        $this->template->layanan('layanan/hasil_laporan', $data);
    }

    public function telegram($id)
    {
        $row = $this->Layanan_model->getLaporanById($id);
        if(isset($row))
        {
            $data = [
                "id" => $id,
                "laporan" => $row['laporan'],
                "waktu" => $row['waktu'],
                "latitude" => $row['latitude'],
                "longitude" => $row['longitude'],
                "lokasi" => $row['lokasi'],
                "ket" => $row['ket']
            ];
            $this->Layanan_model->Telegram_api($data);
        } else {
            return redirect('/');
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-st-one" role="alert">
        <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro" aria-hidden="true"></i>
        <p class="message-mg-rt" style="font-size: 18px;"><b>Laporan anda berhasil dikirim lewat telegram kami!</b></p></div>');
        $this->session->set_flashdata('flash', 'Laporan anda berhasil dikirim!');
        redirect('layanan/hasil_laporan/'.$id);
    }

    public function whatsapp($id)
    {
        $row = $this->Layanan_model->getLaporanById($id);
        if(isset($row))
        {
            $data = [
                "id" => $id,
                "laporan" => $row['laporan'],
                "waktu" => $row['waktu'],
                "latitude" => $row['latitude'],
                "longitude" => $row['longitude'],
                "lokasi" => $row['lokasi'],
                "ket" => $row['ket']
            ];
            $this->Layanan_model->WhatsApp_api($data);
        } else {
            return redirect('/');
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-st-one" role="alert">
        <i class="fa fa-check edu-checked-pro admin-check-pro admin-check-pro" aria-hidden="true"></i>
        <p class="message-mg-rt" style="font-size: 18px;"><b>Laporan anda berhasil dikirim lewat WhatsApp!</b></p></div>');
        $this->session->set_flashdata('flash', 'Laporan anda berhasil dikirim!');
        redirect('layanan/hasil_laporan/'.$id);
    }
}