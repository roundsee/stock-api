<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        return response()->json(Gudang::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_gudang' => 'required|unique:gudang,nama_gudang',
        ]);

        $gudang = Gudang::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Gudang berhasil ditambahkan',
            'data' => $gudang
        ], 201);
    }
}