<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {
        return view('ajax/index', ['title' => 'Data Artikel (AJAX)']);
    }

    public function getData()
    {
        $model = new ArtikelModel();
        $data = $model->findAll();

        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }

    public function add()
    {
        helper('url');
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
            'slug'  => url_title($this->request->getVar('judul'), '-', true),
            'status' => 0,
        ];
        $model->insert($data);

        return $this->response->setJSON([
            'status'  => 'OK',
            'message' => 'Data berhasil ditambahkan.'
        ]);
    }

    public function update($id)
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getVar('judul'),
            'isi'   => $this->request->getVar('isi'),
        ];
        $model->update($id, $data);

        return $this->response->setJSON([
            'status'  => 'OK',
            'message' => 'Data berhasil diubah.'
        ]);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        return $this->response->setJSON([
            'status' => 'OK',
            'message' => 'Data berhasil dihapus.'
        ]);
    }
}
