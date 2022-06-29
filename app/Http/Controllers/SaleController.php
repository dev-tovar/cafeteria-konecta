<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Sale::withCount('productos')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $data = $request->form_data;
            $total_compra = $request->total_compra;

            $devueltos = [];

            // return $data;
            $insertSale = new Sale();
            $insertSale->numero_referencia = date('YmdHis');
            $insertSale->total = $total_compra;
            $insertSale->save();

            foreach ($data as $key => $producto) {

                $validar_cantidad = Product::select('id', 'stock', 'nombre')->where('id', $producto['id'])
                // ->where('stock', '>=',  $producto['cantidad'])
                ->first();
                if (isset($validar_cantidad) && $validar_cantidad->stock >= $producto['cantidad']) {
                    //SI TIENE STOCK, INSERTA 
                    $inserSaleProduct = new SaleProduct();
                    $inserSaleProduct->id_sale = $insertSale->id;
                    $inserSaleProduct->id_product = $producto['id'];
                    $inserSaleProduct->cantidad = $producto['cantidad'];
                    $inserSaleProduct->valor_unitaro = $producto['precio'];
                    $inserSaleProduct->save();

                    $restarStock = Product::where('id', $producto['id'])
                        ->update(['stock' => (DB::raw('stock - ' . $producto["cantidad"]))]);
                } else {
                    $devueltos[$key] = [
                        "id_product" => $producto['id'],
                        "nombre" => $validar_cantidad->nombre,
                        "stock" => $validar_cantidad->stock
                    ];
                    //HACE UN ROLLBACK Y DEVUELVE LA VENTA

                    
                }
            }

            if(count($devueltos) > 0){
                DB::rollback();
                return  response()->json(['status' => 'error_stock', 'products' => $devueltos], 500);
            }

            DB::commit();
            return ['status' => 'ok'];
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
