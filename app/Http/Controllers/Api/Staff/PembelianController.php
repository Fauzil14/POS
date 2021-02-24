<?php

namespace App\Http\Controllers\Api\Staff;

use App\Models\Product;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\KeuanganBusiness;
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
        ]);

        $product = Product::find($validatedData['product_id']);

        $pembelian = Pembelian::find($validatedData['pembelian_id']);
        $pembelian->detail_pembelian()->updateOrCreate([
            'product_id'     => $validatedData['product_id'],
        ],[ 
            'quantity'       => $validatedData['quantity'],
            'harga_beli'     => $validatedData['harga_beli'] ?? $product->harga_beli,
            'subtotal_harga' => $validatedData['quantity'] * ($validatedData['harga_beli'] ?? $product->harga_beli),
        ]);
        $pembelian->total_price = $pembelian->detail_pembelian()->sum('subtotal_harga');
        $pembelian->update();
        $data = $pembelian->refresh();
        $data = new PembelianResource($pembelian->refresh());

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
                    if(Auth::user()->roles->first()->role_name == 'admin') {
                        $error = array_merge($error, [                        
                            'saldo_business' => $pembelian->business->keuangan->saldo,
                            'kekurangan' => $pembelian->total_price - $pembelian->business->keuangan->saldo
                        ]);
                    }
                    throw ValidationException::withMessages($error);
                }
                $pembelian->status = 'finished';
                $pembelian->update();
                $pembelian->staff->increment('number_of_transaction', 1);
                $pembelian->staff->increment('total_pembelian', $pembelian->total_price);
                $pembelian->business->keuangan->increment('pengeluaran', $pembelian->total_price);
                $pembelian->business->keuangan->increment('saldo', $pembelian->total_price);

            DB::commit();

            $data = new PembelianResource($pembelian->refresh());

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
}
