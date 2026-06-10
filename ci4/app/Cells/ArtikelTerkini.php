<?php

namespace App\Cells;

use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function render(string $kategori = 'teknologi')
    {
        $model = new ArtikelModel();
        $artikel = $model
            ->select('artikel.*')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->where('kategori.slug_kategori', $kategori)
            ->orderBy('artikel.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        return view('components/artikel_terkini', [
            'artikel'  => $artikel,
            'kategori' => $kategori,
        ]);
    }
}