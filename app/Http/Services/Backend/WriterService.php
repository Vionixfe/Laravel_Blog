<?php

namespace App\Http\Services\Backend;

use App\Models\User;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class WriterService
{
    public function dataTable($request)
    {

        if ($request->ajax()) {
            $totalData = User::count();
            $totalFiltered = $totalData;

            $limit = $request->length;
            $start = $request->start;

            if (empty($request->search['value'])) {
                $data = User::offset($start)
                    ->limit($limit)
                    ->get(['id', 'name', 'email', 'created_at', 'is_verified']);
            } else {
                $data = User::filter($request->search['value'])
                    ->offset($start)
                    ->limit($limit)
                    ->get(['id', 'name', 'email', 'created_at', 'is_verified']);

                $totalFiltered = $data->count();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->setOffset($start)
                ->editColumn('created_at', function ($data) {
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })

                ->editColumn('is_verified', function ($data) {

                    if ($data->is_verified == 1) {
                        return '<span class="badge bg-success">Verified</span>';
                    } else {
                        return '<span class="badge bg-danger">UnVerified</span>';
                    }

            })
                ->addColumn('action', function ($data) {
                    $actionBtn = '
                    <div class="text-center" width="10%">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-warning" onclick="editVerified(this)" data-id="' . $data->id . '">
                                <i class="fas fa-user-check"></i>
                            </button>
                            <a href="' . route('admin.writers.edit', $data->id) . '"  class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteData(this)" data-id="' . $data->id . '">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                ';

                    return $actionBtn;
                })
                ->with([
                    'recordsTotal' => $totalData,
                    'recordsFiltered' => $totalFiltered,
                    'start' => $start
                ])
                ->rawColumns(['action', 'is_verified'])
                ->make();
        }
    }

    public function getFirstBy(string $column, string $value)
    {
        return User::where($column, $value)->firstOrFail();
    }

    public function update(array $data, string $id)
{
    return User::where('id', $id)->update($data);
}

}

 // public function getFirstBy(string $column, string $value)
    // {
    //     return Writer::where($column, $value)->firstOrFail();
    // }

    // public function create(array $data)
    // {
    //     $data['slug'] = Str::slug($data['name']);
    //     return Writer::create($data);
    // }
