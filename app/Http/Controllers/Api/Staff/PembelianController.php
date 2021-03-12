<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Product;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\DetailPembelian;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PembelianResource;
use Illuminate\Validation\ValidationException;

class PembelianController extends Controller
{
    public function createDetailPembelian(Request $request) 
    {
        $validatedData = $request->validate([
            'pembelian_id'   => ['required', Rule::exists('pembelians','id')->where('status','unfinished') ],
            'product_id'     => ['required', 'exists:products,id'],
            'quantity'       => ['required_with:product_id', 'integer'],
            'harga_beli'     => ['required'],
            'harga_jual'     => ['sometimes'],
        ]);

        $pembelian = Pembelian::find($validatedData['pembelian_id']);
        $pembelian->detail_pembelian()->updateOrCreate([
            'product_id'     => $validatedData['product_id'],
        ],[ 
            'quantity'       => $validatedData['quantity'],
            'harga_beli'     => $validatedData['harga_beli'],
            'harga_jual'     => isset($validatedData['harga_jual']) ? $validatedData['harga_jual'] : null ,
            'subtotal_harga' => $validatedData['quantity'] * $validatedData['harga_beli'],
        ]);

        $data = new PembelianResource($pembelian->fresh());

        return response()->json($data);
    }
    
    public function finishPembelian(Request $request) 
    {
        $validatedData = $request->validate([
            'pembelian_id'     => ['required', Rule::exists('pembelians','id')->where('status', 'unfinished')],
        ]);

        $pembelian = Pembelian::findOrFail($validatedData['pembelian_id']);

        try {
            DB::beginTransaction();
                if($pembelian->business->keuangan->saldo < $pembelian->total_price) {  
                    $error = [
                        'message' => 'Jumlah saldo yang anda miliki tidak mencukupi untuk menyelesaikan transaksi',
                    ];
                    
                    if( $this->checkAuthRole('admin') ) {
                        $error = array_merge($error, [                        
                            'saldo_business' => $pembelian->business->keuangan->saldo,
                            'kekurangan' => $pembelian->total_price - $pembelian->business->keuangan->saldo
                        ]);
                    }
                    throw ValidationException::withMessages($error);
                }
                $pembelian->status = 'finished';
                $pembelian->update();

            DB::commit();

            $data = new PembelianResource($pembelian);

            return $this->sendResponse('success', 'Transaksi berhasil', $data, 200);
        } catch(ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'error' => $e->errors()
            ]);
        } catch(\Throwable $e) {
            DB::rollback();
            return $this->sendResponse('failed', 'Transaksi gagal', $e->getMessage(), 200);
        }
    }

    public function deleteDetailPembelian($detail_pembelian_id) 
    {
        $detail_pembelian = DetailPembelian::find($detail_pembelian_id);
        $pembelian_id = $detail_pembelian->id;
        $detail_pembelian->delete();
 
        $data = new PembelianResource(Pembelian::find($pembelian_id));

    return $this->sendResponse('success', 'Detail pembelian berhasil di hapus', $data, 200);
    }
}
