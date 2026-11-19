<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        return ApiResponse::make($request, Customer::all()->toArray(), 200, 'Daftar pelanggan');
    }

    public function show(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return ApiResponse::make($request, null, 404, 'Pelanggan tidak ditemukan');
        }
        return ApiResponse::make($request, $customer->toArray(), 200, 'Detail pelanggan');
    }

    public function store(Request $request)
    {
        $input = $request->only((new Customer)->getFillable());
        $v = Validator::make($input, $this->rules(true));
        if ($v->fails()) {
            return ApiResponse::make($request, $v->errors()->toArray(), 422, 'Validasi gagal');
        }

        $customer = Customer::create($input);
        return ApiResponse::make($request, $customer->fresh()->toArray(), 201, 'Pelanggan berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return ApiResponse::make($request, null, 404, 'Pelanggan tidak ditemukan');
        }

        $input = $request->only($customer->getFillable());
        $v = Validator::make($input, $this->rules(false));
        if ($v->fails()) {
            return ApiResponse::make($request, $v->errors()->toArray(), 422, 'Validasi gagal');
        }

        $customer->update($input);
        return ApiResponse::make($request, $customer->fresh()->toArray(), 200, 'Pelanggan berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (!$customer) {
            return ApiResponse::make($request, null, 404, 'Pelanggan tidak ditemukan');
        }

        $customer->delete(); // riwayat servis ikut terhapus (cascade)
        return ApiResponse::make($request, null, 200, 'Pelanggan berhasil dihapus');
    }

    private function rules(bool $required): array
    {
        $r = $required ? 'required|' : 'sometimes|required|';
        return [
            'name'        => $r . 'string|max:255',
            'phone'       => $r . 'regex:/^[0-9+\-\s]{6,20}$/',
            'email'       => 'nullable|email|max:255',
            'address'     => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'gender'      => 'nullable|in:L,P',
            'birth_date'  => 'nullable|date_format:Y-m-d',
            'occupation'  => 'nullable|string|max:100',
            'membership'  => 'nullable|in:reguler,silver,gold',
            'notes'       => 'nullable|string',
        ];
    }
}
