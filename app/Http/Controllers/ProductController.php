<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('produk.index', compact('categories','subcategories'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
     // Mengambil 12 produk acak dengan relasi kategori dan subkategori
    $product = Product::with('category', 'subcategory')
    ->get();

        return response()->json([
            'data' => $product
        ]);

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
        $validator = Validator::make($request->all(),[
            
            'id_kategori' => 'required',
            'id_subkategori' => 'required',
            'nama_produk'=> 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,webp',
            'deskripsi'=> 'required',
            'qty'=> 'required',
            'harga'=> 'required',
            'berat'=> 'required',
            'tags'=> 'required',
            
        ]);

        if($validator->fails()){
            return response()->json(
                $validator->errors(), 422
            );
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '_' . preg_replace('/\s+/', '_', $gambar->getClientOriginalName());
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }
        

        
        $product = Product::create($input);

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'id_kategori' => 'required',
            'id_subkategori' => 'required',
            'nama_produk'=> 'required',
            'gambar' => 'sometimes|required|image|mimes:jpg,png,jpeg,webp',
            'deskripsi'=> 'required',
            'qty'=> 'required',
            'harga'=> 'required',
            'berat'=> 'required',
            'tags'=> 'required',
        ]);

        if($validator->fails()){
            return response()->json(
                $validator->errors(), 422
            );
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            File::delete('uploads/' . $product->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '_' . preg_replace('/\s+/', '_', $gambar->getClientOriginalName());
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
            // Jika gambar tidak dikirim, hapus 'gambar' dari array $input
        }
        
        

        $product->update($input);

        return response()->json([
            'success' => true,
            'massage' =>'update succses',
            'data'  => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        File::delete('uploads/' . $product->gambar);
        $product->delete();

        return response()->json([
            'success' => true,
            'massage' => 'update success',
            'data'  => $product
    
        ]);
    }
}
