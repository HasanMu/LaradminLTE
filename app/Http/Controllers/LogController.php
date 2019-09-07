<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Auth;
use Hash;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // if($request->ajax()){
            $activities = Activity::with('subject', 'causer')->latest()->paginate(4);

            // return response()->json($activities, 200);
        // }

        return view('admin.logs.index', compact('activities'));
    }

    public function destroy(Request $request, $id)
    {
        $activities = Activity::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'   => $validator->errors()->all()], 200);
        }

        if (!Hash::check($request->password, Auth::user()->password)) {
            // The passwords matches
            $response = [
                'success'  =>  false,
                'errors'   => ['Password anda salah!']
            ];

            return response()->json($response, 200);
        }

        $response = [
            'success' => true,
            'message' => 'Log berhasil dihapus!',
            'errors'  => false
        ];

        $activities->delete();

        return response()->json($response, 200);
    }
}
