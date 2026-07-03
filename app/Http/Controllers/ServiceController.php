<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $services = Service::all();
        return $this->successResponse($services, 'Data layanan berhasil diambil');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga_per_kg' => 'nullable|numeric',
            'harga_satuan' => 'nullable|numeric',
            'estimasi_waktu' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $service = Service::create($request->all());

        return $this->successResponse($service, 'Layanan berhasil ditambahkan', 201);
    }

    public function show($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return $this->errorResponse('Layanan tidak ditemukan', 404);
        }

        return $this->successResponse($service, 'Data layanan berhasil diambil');
    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);

        if (!$service) {
            return $this->errorResponse('Layanan tidak ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'sometimes|required|string|max:255',
            'kategori' => 'sometimes|required|string',
            'harga_per_kg' => 'nullable|numeric',
            'harga_satuan' => 'nullable|numeric',
            'estimasi_waktu' => 'sometimes|required|string',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $service->update($request->all());

        return $this->successResponse($service, 'Layanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return $this->errorResponse('Layanan tidak ditemukan', 404);
        }

        $service->delete();

        return $this->successResponse(null, 'Layanan berhasil dihapus');
    }
}
