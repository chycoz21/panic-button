<?php 

class Layanan_model extends CI_Model
{
    public function getIdTerakhir(){
        $this->db->select_max('id');
        $query = $this->db->get('tb_laporan');
		$ret = $query->row();
		$idTerakhir = $ret->id;
		return $idTerakhir;
	}

    public function tambahLaporan($data)
    {
        $this->db->select_max('id');
        $query = $this->db->get('tb_laporan');
		$ret = $query->row();
		$idTerakhir = $ret->id;
        $id_laporan = $idTerakhir + 1;

        $laporan = $data['laporan'];
        $waktu = waktu();
        $latitude = $this->input->post('latitude', true);
        $longitude = $this->input->post('longitude', true);
        $lokasi = $this->input->post('lokasi', true);
        $ket = $this->input->post('ket', true);

        $data = [
            "id" => $id_laporan,
            "laporan" => htmlspecialchars($laporan),
            "waktu" => $waktu,
            "latitude" => htmlspecialchars($latitude),
            "longitude" => htmlspecialchars($longitude),
            "lokasi" => htmlspecialchars($lokasi),
            "ket" => htmlspecialchars($ket)
        ];

        /*
        | ---------------------------------------------------------------
        | Kirim notifikasi ke Telegram & WhatsApp
        | ---------------------------------------------------------------
        */
        $this->Telegram_api($data);
        $this->WhatsApp_api($data);

        $this->db->insert('tb_laporan', $data);
    }

    public function getLaporanById($id)
    {
        $data = $this->db->get_where('tb_laporan', array('id' => $id));
        if ($data->num_rows() == 0) {
            echo '<script>window.history.back()</script>';
        } else {
            return $this->db->get_where('tb_laporan', ['id' => $id])->row_array();
        }
    }

    public function maps($id)
    {
        return $this->db->get_where('tb_laporan', ['id' => $id])->result();
    }

    public function Telegram_api($data)
    {
        $id_laporan = $data['id'];
        $laporan = $data['laporan'];
        $waktu = $data['waktu'];
        $lokasi = $data['lokasi'];
        $ket = $data['ket'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $link = base_url('layanan/hasil_laporan/' . $id_laporan);
        $bot['api'] = $this->db->get_where('tb_pengaturan', ['id' => '2'])->row_array();
        /*
        | ---------------------------------------------------------------
        | API Telegram Untuk Notifikasi
        | ---------------------------------------------------------------
        */
        if($bot['api']['bot_active'] == 1){
        $token = $bot['api']['token'];
        $pesan = [
        'text' => "Laporan Masuk Dari Panic Button BANK IBU\n===========================\nKode Laporan = $id_laporan\nJenis Laporan = $laporan\nWaktu Kejadian = $waktu\nLokasi Kejadian = $lokasi\nKeterangan = $ket\nLink Laporan = $link\n\nBuka Google Maps = https://www.google.com/maps/place/$latitude+$longitude/@$latitude,$longitude,15z\n===========================",
        'chat_id' => $bot['api']['chat_id']
        ];
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($pesan));
        };
    }

    public function WhatsApp_api($data)
    {
        $id_laporan = $data['id'];
        $laporan = $data['laporan'];
        $waktu = $data['waktu'];
        $lokasi = $data['lokasi'];
        $ket = $data['ket'];
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];
        $link = base_url('layanan/hasil_laporan/' . $id_laporan);
        
        // Ambil konfigurasi bot dari database
        $bot = $this->db->get_where('tb_pengaturan', ['id' => '3'])->row_array();
    
        if ($bot && isset($bot['bot_active']) && $bot['bot_active'] == 1) {
            $pesan_wa = "Laporan Masuk Dari Panic Button BANK IBU\n===========================\n"
                . "Kode Laporan = $id_laporan\nJenis Laporan = $laporan\n"
                . "Waktu Kejadian = $waktu\nLokasi Kejadian = $lokasi\n"
                . "Keterangan = $ket\nLink Laporan = $link\n\n"
                . "Buka Google Maps = https://www.google.com/maps/place/$latitude+$longitude/@$latitude,$longitude,15z\n"
                . "===========================";
            
            $token = isset($bot['token']) ? $bot['token'] : null;
            $target = isset($bot['chat_id']) ? $bot['chat_id'] : null;
    
            if (!$token || !$target) {
                die("Token atau chat_id tidak ditemukan!"); // Debugging jika token tidak ada
            }
    
            $curl = curl_init();
            
            // Data yang akan dikirim
            $postData = [
                'target' => $target,
                'message' => $pesan_wa,
                'countryCode' => '62', // Optional
            ];
    
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30, // Perbaikan timeout
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($postData), // Pastikan format benar
                CURLOPT_HTTPHEADER => [
                    "Authorization: $token",
                    "Content-Type: application/x-www-form-urlencoded"
                ],
            ]);
            
            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                curl_close($curl);
                die("cURL Error: " . $error_msg); // Debugging
            }
    
            curl_close($curl);
    
            // Debugging response dari API
            echo "HTTP Code: " . $http_code . "<br>";
            echo "Response: " . $response;
        } else {
            die("Bot tidak aktif atau konfigurasi tidak ditemukan.");
        }
    }
    

    public function getAPItelegram()
    {
        return $this->db->get_where('tb_pengaturan', ['id' => '2'])->row_array();
    }

    public function getAPIwa()
    {
        return $this->db->get_where('tb_pengaturan', ['id' => '3'])->row_array();
    }
}