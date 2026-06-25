<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title   = 'Daftar Artikel';
        $model   = new ArtikelModel();
        $artikel = $model->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
            ->where('artikel.status', 1)
            ->get()
            ->getResultArray();
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function view($slug)
    {
        $model           = new ArtikelModel();
        $data['artikel'] = $model->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
            ->where('artikel.slug', $slug)
            ->get()
            ->getRowArray();

        if (empty($data['artikel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan.');
        }
        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }

    public function admin_index()
    {
        $title       = 'Daftar Artikel (Admin)';
        $model       = new ArtikelModel();
        $q           = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page        = (int)($this->request->getVar('page') ?? 1);
        $sort        = $this->request->getVar('sort') ?? 'id';
        $order       = $this->request->getVar('order') ?? 'DESC';

        // Validasi sort field
        $allowedSort = ['id', 'judul', 'nama_kategori', 'status'];
        if (!in_array($sort, $allowedSort)) {
            $sort = 'id';
        }
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $builder = $model->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }
        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $builder->orderBy($sort, $order);

        $perPage     = 10;
        $total       = $builder->countAllResults(false);
        $offset      = ($page - 1) * $perPage;
        $artikel     = $builder->limit($perPage, $offset)->get()->getResultObject();
        $pager       = \Config\Services::pager();

        $kategoriModel = new KategoriModel();

        $data = [
            'title'       => $title,
            'q'           => $q,
            'kategori_id' => $kategori_id,
            'artikel'     => $artikel,
            'kategori'    => $kategoriModel->findAll(),
            'pager'       => $pager->makeLinks($page, $perPage, $total),
            'sort'        => $sort,
            'order'       => $order,
            'total'       => $total,
            'currentPage' => $page,
            'perPage'     => $perPage,
        ];

        // Modul 9: Support AJAX response
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        $kategoriModel = new KategoriModel();

        // validasi data
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            helper('url');
            $model = new ArtikelModel();
            $insertData = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'slug'        => url_title($this->request->getPost('judul'), '-', true),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'status'      => 0,
            ];

            // Handle file upload gambar
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $newName);
                $insertData['gambar'] = $newName;
            }

            $model->insert($insertData);
            return redirect()->to('/admin/artikel');
        }

        return view('artikel/form_add', [
            'title'    => 'Tambah Artikel',
            'kategori' => $kategoriModel->findAll(),
        ]);
    }

    public function edit($id)
    {
        $model         = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($this->request->getMethod() == 'post' && $isDataValid) {
            $updateData = [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
            ];

            // Handle file upload gambar
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/gambar', $newName);
                $updateData['gambar'] = $newName;
            }

            $model->update($id, $updateData);
            return redirect()->to('/admin/artikel');
        }

        return view('artikel/form_edit', [
            'title'    => 'Edit Artikel',
            'artikel'  => $model->find($id),
            'kategori' => $kategoriModel->findAll(),
        ]);
    }

    public function delete($id)
    {
        (new ArtikelModel())->delete($id);
        return redirect()->to('/admin/artikel');
    }
}