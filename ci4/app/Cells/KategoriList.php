<?php

namespace App\Cells;

use App\Models\KategoriModel;

class KategoriList
{
    public function render()
    {
        $model = new KategoriModel();
        $kategori = $model->findAll();
        
        return view('components/kategori_list', ['kategori' => $kategori]);
    }
}
