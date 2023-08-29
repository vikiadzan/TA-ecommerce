<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Js;

class SubcategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function index()
    {
        $subcategories = Subcategory::with('category')->get();

        return response()->json([
            'data' => $subcategories
        ]);
    }

    public function list()
    {
        $categories = Category::all();

        return view('subkategori.index', compact('categories'));
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
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,webp'
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
        

        
        $subcategory = Subcategory::create($input);

        return response()->json([
            'success' => true,
            'data' => $subcategory
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        return response()->json([
            'success' => true,
            'data' => $subcategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validator = Validator::make($request->all(),[
            'id_kategori' => 'required',
            'nama_subkategori' => 'required',
            'deskripsi' => 'required'

        ]);

        if($validator->fails()){
            return response()->json(
                $validator->errors(), 422
            );
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            File::delete('uploads/' . $subcategory->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . '_' . preg_replace('/\s+/', '_', $gambar->getClientOriginalName());
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }else{
            unset($input['gambar']);
        }
        

        $subcategory->update($input);

        return response()->json([
            'success' => true,
            'massage' =>'update succses',
            'data'  => $subcategory
        ]);
    }

    

     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        File::delete('uploads/' . $subcategory->gambar);
        $subcategory->delete();

        return response()->json([
            'success' => true,
            // 'message' => 'success'
        ]);
    }
}

