<?php

namespace App\Controllers;

use App\Models\BukuModel;

class BukuController extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    public function index()
    {
        $data['buku'] = $this->bukuModel->findAll();

        return view('buku/index', $data);
    }

    public function create()
    {
        return view('buku/create');
    }

    public function store()
{
    $rules = [

        'judul' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Judul wajib diisi'
            ]
        ],

        'penulis' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Penulis wajib diisi'
            ]
        ],

        'penerbit' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Penerbit wajib diisi'
            ]
        ],

        'tahun_terbit' => [
            'rules' => 'required|integer|greater_than[1799]|less_than[2025]',
            'errors' => [
                'required' => 'Tahun terbit wajib diisi',
                'integer' => 'Tahun harus berupa angka',
                'greater_than' => 'Tahun harus lebih dari 1799',
                'less_than' => 'Tahun harus kurang dari 2025'
            ]
        ]
    ];

    if (!$this->validate($rules))
    {
        return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
    }

    $this->bukuModel->save([

        'judul' => $this->request->getPost('judul'),

        'penulis' => $this->request->getPost('penulis'),

        'penerbit' => $this->request->getPost('penerbit'),

        'tahun_terbit' => $this->request->getPost('tahun_terbit')
    ]);

    return redirect()
        ->to('/buku')
        ->with(
            'success',
            'Data buku berhasil ditambahkan'
        );
    }

    public function edit($id)
    {
        $data['buku'] = $this->bukuModel->find($id);

        return view('buku/edit', $data);
    }

    public function update($id)
    {
    $rules = [

        'judul' => 'required',

        'penulis' => 'required',

        'penerbit' => 'required',

        'tahun_terbit' =>
            'required|integer|greater_than[1799]|less_than_equal_to[2025]'
    ];

    if (!$this->validate($rules))
    {
        return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
    }

    $this->bukuModel->update($id, [

        'judul' => $this->request->getPost('judul'),

        'penulis' => $this->request->getPost('penulis'),

        'penerbit' => $this->request->getPost('penerbit'),

        'tahun_terbit' => $this->request->getPost('tahun_terbit')
    ]);

    return redirect()
        ->to('/buku')
        ->with(
            'success',
            'Data buku berhasil diperbarui'
            );
    }

    public function delete($id)
    {
        $buku = $this->bukuModel->find($id);

        if (!$buku)
        {
            return redirect()
                    ->to('/buku')
                    ->with(
                        'error',
                        'Data buku tidak ditemukan'
                    );
        }

        $this->bukuModel->delete($id);

        return redirect()
                ->to('/buku')
                ->with(
                    'success',
                    'Data buku berhasil dihapus'
                );
    }
}