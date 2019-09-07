<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use DataTables;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {

            $tag = Tag::all();
            return Datatables::of($tag)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '<button type="button" id="edit-data" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEdit" data-id="'.$row->id.'"><i class="fa fa-edit"></i></button>';
                        $btn = $btn.' <button type="button" id="hapus-data" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalHapus" data-id="'.$row->id.'" data-nama="'.$row->nama.'"><i class="fa fa-trash-o"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.tag.index');
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
            'nama' => 'required|unique:tags',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $tag_all = Tag::all();
        $newTag = new Tag;

        $newTag->nama = $request->nama;
        $newTag->slug = str_slug($request->nama);
        $newTag->save();

        $response = [
            'errors'  => false,
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
        $tagId = Tag::findOrFail($id);

        $response = [
            'data'      => $tagId,
            'message'   => 'Data tag dengan nama '.$tagId->nama.'!'
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
        $tagId = Tag::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'nama'  => 'required|unique:tags,nama,'.$tagId->id
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $tagId->nama = $request->nama;
        $tagId->slug = str_slug($request->nama);
        $tagId->save();

        $response = [
            'data'      => $tagId,
            'message'   => 'Data tag berhasil diubah menjadi '.$tagId->nama.'!',
            'errors'    => false
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
        $tagId = Tag::findOrFail($id);

        $tagId->delete();

        $response = [
            'message'   => 'Data tag berhasil dihapus!'
        ];

        return response()->json($response, 200);
    }
}
