<?php
class Mahasiswa extends CI_Controller {
    // public function __construct()
    // {
    //     // digunakan jika semua method ingin menggunakan database, karna semua sistem menggunakan database jadi database sudah ter autoload.php
    //     parent::__construct();
    //     $this->load->database();
    // }

    public function __construct()
    {
        // digunakan jika semua method ingin menggunakan model
        parent::__construct();
        $this->load->model('m_mahasiswa');
        $this->load->library('form_validation');
    }
    public function index()
    {
        // koneksi database
        // $this->load->database();
        
        $data['judul'] = 'Daftar Mahasiswa';
        $data['mahasiswa'] = $this->m_mahasiswa->getAllMahasiswa();
        $this->load->view('templates/header', $data);
        $this->load->view('mahasiswa/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['judul'] = 'Form Tambah Data Mahasiswa';
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nip', 'NIP', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if( $this->form_validation->run() == FALSE ) {
            $this->load->view('templates/header', $data);
            $this->load->view('mahasiswa/tambah');
            $this->load->view('templates/footer');
        } else {
            $this->m_mahasiswa->tambahDataMahasiswa();
            $this->session->set_flashdata('flash', 'Ditambahkan');
            redirect('mahasiswa');
        }
    }

    public function hapus($id)
    {
        $this->m_mahasiswa->hapusDataMahasiswa($id);
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('mahasiswa');
    }

    public function detail($id)
    {
        $data['judul'] = 'Detail Data Mahasiswa';
        $data['mahasiswa'] = $this->m_mahasiswa->getMahasiswaById($id);
        $this->load->view('templates/header', $data);
        $this->load->view('mahasiswa/detail', $data);
        $this->load->view('templates/footer');
    }

    public function ubah($id)
    {
        $data['judul'] = 'Form Ubah Data Mahasiswa';
        $data['mahasiswa'] = $this->m_mahasiswa->getMahasiswaById($id);
        $data['jurusan'] = ['Teknik Informatika', 'Sistem Informasi', 'Manajemen Akuntansi', 'Manajemen Pemasaran', 'Sastra Inggris', 'Sastra Korea'];

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('nip', 'NIP', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if( $this->form_validation->run() == FALSE ) {
            $this->load->view('templates/header', $data);
            $this->load->view('mahasiswa/ubah', $data);
            $this->load->view('templates/footer');
        } else {
            $this->m_mahasiswa->ubahDataMahasiswa();
            $this->session->set_flashdata('flash', 'Diubah');
            redirect('mahasiswa');
        }
    }
}