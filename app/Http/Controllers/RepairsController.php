<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RepairsController extends Controller
{
    // GET /repairs            -> semua servis
    // GET /repairs?customer_id=1 -> servis milik pelanggan id 1
    public function index(Request $request)
    {
        $query = Repair::query();
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->query('customer_id'));
        }

        return ApiResponse::make($request, $query->get()->toArray(), 200, 'Daftar servis');
    }

    public function show(Request $request, $id)
    {
        $repair = Repair::find($id);
        if (!$repair) {
            return ApiResponse::make($request, null, 404, 'Data servis tidak ditemukan');
        }
        return ApiResponse::make($request, $repair->toArray(), 200, 'Detail servis');
    }

    public function store(Request $request)
    {
        $input = $request->only((new Repair)->getFillable());

        $v = Validator::make($input, $this->rules(true));
        if ($v->fails()) {
            return ApiResponse::make($request, $v->errors()->toArray(), 422, 'Validasi gagal');
        }

        $repair = Repair::create($input);
        return ApiResponse::make($request, $repair->fresh()->toArray(), 201, 'Data servis berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $repair = Repair::find($id);
        if (!$repair) {
            return ApiResponse::make($request, null, 404, 'Data servis tidak ditemukan');
        }

        $input = $request->only($repair->getFillable());
        $v = Validator::make($input, $this->rules(false));
        if ($v->fails()) {
            return ApiResponse::make($request, $v->errors()->toArray(), 422, 'Validasi gagal');
        }

        $repair->update($input);
        return ApiResponse::make($request, $repair->fresh()->toArray(), 200, 'Data servis berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $repair = Repair::find($id);
        if (!$repair) {
            return ApiResponse::make($request, null, 404, 'Data servis tidak ditemukan');
        }

        $repair->delete();
        return ApiResponse::make($request, null, 200, 'Data servis berhasil dihapus');
    }

    private function rules(bool $required): array
    {
        $r = $required ? 'required|' : 'sometimes|required|';
        return [
            'customer_id'   => $r . 'integer|exists:customers,id',
            'plate_number'  => $r . 'string|max:15',
            'vehicle_brand' => $r . 'string|max:50',
            'vehicle_model' => $r . 'string|max:50',
            'service_type'  => $r . 'string|max:100',
            'vehicle_year'  => 'nullable|integer|between:1950,2100',
            'complaint'     => 'nullable|string',
            'mechanic_name' => 'nullable|string|max:100',
            'cost'          => 'nullable|numeric|min:0',
            'status'        => 'nullable|in:menunggu,dikerjakan,selesai,diambil',
            'repair_date'   => 'nullable|date_format:Y-m-d',
        ];
    }
}
