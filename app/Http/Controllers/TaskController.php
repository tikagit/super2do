<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Task;
use DB;

// use App\;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function simpanData(Request $request)
    {
        $all_data = $request->all();
        // dd($all_data['nilai']);
        DB::beginTransaction();
        try {
                $data = array(
                  'task' => $all_data['nilai'],
                  'status' => 'aktif',
                );
                $act = Task::create($data);

                $status = array(
                    'status' => true,
                    'msg' => 'Data berhasil disimpan',
                    'data_swal' => [
                        'nilai' => $all_data['nilai'],
                    ],
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }

    public function getData()
    {
        DB::beginTransaction();
        try {
                $data = DB::table('task')->select('*')->orderBy('created_at', 'desc')->get();
                $status = array(
                    'status' => true,
                    'data' => $data,
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }

    public function hapus(Request $request)
    {
        $all_data = $request->all();
        $id = $all_data['id'];
        DB::beginTransaction();
        try {
            // dd($id);
                $task = Task::find($id);
                $act = $task->delete();
                $status = array(
                    'status' => true,
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }

    public function ubah(Request $request)
    {
        $all_data = $request->all();
        $id = $all_data['id'];
        DB::beginTransaction();
        try {
                $task = Task::find($id);
                $data = ['status' => 'complete'];
                $act = $task->update($data);
                $status = array(
                    'status' => true,
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }

    public function aktifData()
    {
        DB::beginTransaction();
        try {
                $data = DB::table('task')->select('*')->where('status', 'aktif')->orderBy('created_at', 'desc')->get();
                $status = array(
                    'status' => true,
                    'data' => $data,
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }

    public function completedData()
    {
        DB::beginTransaction();
        try {
                $data = DB::table('task')->select('*')->where('status', 'complete')->orderBy('created_at', 'desc')->get();
                $status = array(
                    'status' => true,
                    'data' => $data,
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }

    public function markDataTrue(Request $request)
    {
        DB::beginTransaction();
        try {
                DB::table('task')->update(array('status' => 'aktif'));
                $status = array(
                    'status' => true,
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }


    public function markDataFalse(Request $request)
    {
        DB::beginTransaction();
        try {
                DB::table('task')->update(array('status' => 'complete'));
                $status = array(
                    'status' => true,
                );
        } catch (Exception $e) {
            $status = array(
                'status' => false,
                'msg' => $e->getMessage(),
            );
            DB::rollback();
        }
        DB::commit();

        return response()->json($status);
    }

}
