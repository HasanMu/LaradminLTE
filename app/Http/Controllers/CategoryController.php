<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Spatie\Activitylog\Models\Activity;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()) {

            $category = Category::all();
            return Datatables::of($category)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<button type="button" id="edit-data" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEdit" data-id="'.$row->id.'"><i class="fa fa-edit"></i></button>';
                        $btn = $btn.' <button type="button" id="hapus-data" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus" data-id="'.$row->id.'" data-nama="'.$row->nama.'"><i class="fa fa-trash-o"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.category.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama'  => 'required|unique:categories'
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $newCat = new Category;

        $newCat->nama = $request->nama;
        $newCat->slug = str_slug($request->nama);
        $newCat->save();

        $response = [
            'errors'    => false,
            'message'   => 'Data berhasil di simpan!'
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $catId = Category::findOrFail($id);

        $response = [
            'data'      => $catId,
            'message'   => 'Data kategori dengan nama '.$catId->nama.'!'
        ];

        return response()->json($response, 200);
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
        $catId = Category::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'nama'  => 'required|unique:categories,nama,'.$catId->id
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $catId->nama = $request->nama;
        $catId->slug = str_slug($request->nama);
        $catId->save();

        $response = [
            'data'      => $catId,
            'message'   => 'Data kategori berhasil diubah menjadi '.$catId->nama.'!'
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $catId = Category::findOrFail($id);

        $catId->delete();

        $response = [
            'message'   => 'Data kategori berhasil dihapus!'
        ];

        return response()->json($response, 200);
    }
}
