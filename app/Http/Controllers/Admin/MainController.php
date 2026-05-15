<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function template($page, $data)
    {
        $data['comp'] =getSetting('app_name');
        if (!isset($data['title'])) {
            $data['title'] = $data['comp'];
        }
        $data['user'] = Auth::user();
        return view($page, $data);
    }
    public function userData(){
        return Auth::user();
    }
    public function changeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = explode(',', $request->input('data'));
            $id = $data[0];
            $table = $data[1];
            $id_column = $data[2];
            $status_column = $data[3];
            $updateData = [
                $status_column => $request->input('value'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ];
            DB::table($table)->where($id_column, $id)->update($updateData);
            $status = DB::table($table)->where($id_column, $id)->value($status_column);
            if ($status == 1) {
                return response()->json([
                    'html' => "<span class='changeStatus' data-toggle='change-status' value='0' data='{$id},{$table},{$id_column},{$status_column}' title='Click to change status'><i class='fa-solid fa-circle-check'></i></span>",
                    'message' => 'Status changed to Active'
                ]);
            } else {
                return response()->json([
                    'html' => "<span class='changeStatus' data-toggle='change-status' value='1' data='{$id},{$table},{$id_column},{$status_column}' title='Click to change status'><i class='fa-solid fa-circle-xmark'></i></span>",
                    'message' => 'Status changed to Inactive'
                ]);
            }
        }
    }


        public function changeIndexing(Request $request)
        {
            $request->validate([
                'data' => 'required|string',
                'value' => 'required|numeric',
            ]);

            if ($request->ajax()) {
                $data = explode(',', $request->input('data'));
                $id = $data[0];
                $table = $data[1];
                $id_column = $data[2];
                $val_column = $data[3];
                $updateData = [
                    $val_column => $request->input('value'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                ];
                $updateSuccess = DB::table($table)->where($id_column, $id)->update($updateData);
                if ($updateSuccess) {
                    return response()->json([
                    'res' => 'success',
                    'msg' => 'Saved Indexing'
                    ]);
                } else {
                    return response()->json([
                        'res' => 'error',
                        'msg' => 'Failed to update indexing.'
                    ], 500);
                }
            }
            return response()->json([
                'res' => 'error',
                'msg' => 'Invalid request.'
            ], 400);
    }

}
