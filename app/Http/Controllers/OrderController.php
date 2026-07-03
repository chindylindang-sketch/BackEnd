<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Order::with('service');

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        return $this->successResponse($orders, 'Data pesanan berhasil diambil');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'layanan_id' => 'required|exists:services,id',
            'nama_pelanggan' => 'required|string|max:255',
            'no_hp' => 'required|string',
            'berat_kg' => 'nullable|numeric',
            'jumlah' => 'nullable|integer',
            'tanggal_masuk' => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['status'] = 'diterima';

        $order = Order::create($data);

        // Load service relation to match frontend expectation
        $order->load('service');

        return $this->successResponse($order, 'Pesanan berhasil dibuat', 201);
    }

    public function show($id)
    {
        $order = Order::with('service')->find($id);

        if (!$order) {
            return $this->errorResponse('Pesanan tidak ditemukan', 404);
        }

        return $this->successResponse($order, 'Detail pesanan berhasil diambil');
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->errorResponse('Pesanan tidak ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'layanan_id' => 'sometimes|required|exists:services,id',
            'nama_pelanggan' => 'sometimes|required|string|max:255',
            'no_hp' => 'sometimes|required|string',
            'berat_kg' => 'nullable|numeric',
            'jumlah' => 'nullable|integer',
            'tanggal_masuk' => 'sometimes|required|date',
            'estimasi_selesai' => 'nullable|date',
            'catatan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $order->update($request->all());
        $order->load('service');

        return $this->successResponse($order, 'Pesanan berhasil diperbarui');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->errorResponse('Pesanan tidak ditemukan', 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:diterima,diproses,selesai,diambil',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validasi gagal', 422, $validator->errors());
        }

        $order->update(['status' => $request->status]);
        $order->load('service');

        return $this->successResponse($order, 'Status pesanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->errorResponse('Pesanan tidak ditemukan', 404);
        }

        $order->delete();

        return $this->successResponse(null, 'Pesanan berhasil dihapus');
    }
}
