<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Product::orderBy('created_at', 'DESC')->where('activo', true)->get();
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

        $rules =
            [
                'form_data.nombre' => 'required|max:255',
                'form_data.referencia' => 'required|unique:products,referencia|max:255',
                'form_data.precio' => 'required|max:11',
                'form_data.peso' => 'required|max:11',
                'form_data.categoria' => 'required|max:255',
                'form_data.stock' => 'required|max:11'
            ];

        $niceNames = array(
            'form_data.nombre' => 'NOMBRE',
            'form_data.referencia' => 'REFERENCIA',
            'form_data.precio' => 'PRECIO',
            'form_data.peso' => 'PESO',
            'form_data.categoria' => 'CATEGORÍA',
            'form_data.stock' => 'STOCK',
        );

        $this->validate($request, $rules, [], $niceNames);


        DB::beginTransaction();
        try {

            $data = $request->form_data;

            $insertProduct = new Product();
            $insertProduct->nombre = $data['nombre'];
            $insertProduct->referencia = $data['referencia'];
            $insertProduct->precio = $data['precio'];
            $insertProduct->peso = $data['peso'];
            $insertProduct->categoria = $data['categoria'];
            $insertProduct->stock = $data['stock'];
            $insertProduct->save();

            DB::commit();
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
        return Product::find($id);
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

        $rules =
            [
                'form_data.nombre' => 'required|max:255',
                'form_data.referencia' => 'required|unique:products,referencia,' . $id . ',id||max:255',
                'form_data.precio' => 'required|max:11',
                'form_data.peso' => 'required|max:11',
                'form_data.categoria' => 'required|max:255',
                'form_data.stock' => 'required|max:11'
            ];

        $niceNames = array(
            'form_data.nombre' => 'NOMBRE',
            'form_data.referencia' => 'REFERENCIA',
            'form_data.precio' => 'PRECIO',
            'form_data.peso' => 'PESO',
            'form_data.categoria' => 'CATEGORÍA',
            'form_data.stock' => 'STOCK',
        );

        $this->validate($request, $rules, [], $niceNames);


        DB::beginTransaction();
        try {

            $data = $request->form_data;


            $updateProduct = Product::where('id', $id)->first();
            $updateProduct->nombre = $data['nombre'];
            $updateProduct->referencia = $data['referencia'];
            $updateProduct->precio = $data['precio'];
            $updateProduct->peso = $data['peso'];
            $updateProduct->categoria = $data['categoria'];
            $updateProduct->stock = $data['stock'];
            $updateProduct->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $updateProduct = Product::where('id', $id)->first();
        $updateProduct->activo = false;
        $updateProduct->save();
    }


    public function searchProduct(Request $request)
    {
        $search = $request->search;

        $products = Product::select('nombre', 'precio', 'referencia', 'peso', 'stock', 'id')->orWhere('nombre', 'LIKE', '%' . $search . '%')
            ->orWhere('referencia', 'LIKE', '%' . $search . '%')->where('activo', true)->get();

        return $products;
    }
}
