<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    public function index()
    {
        return view("backend.layouts.Condition.index");
    }

    public function getData()
    {
        $conditions = Condition::latest()->get();

        return datatables()->of($conditions)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<a href="javascript:void(0)"
                            class="btn btn-outline-primary btn-sm edit"
                            data-id="'.$row->id.'"
                            data-condition="'.htmlspecialchars($row->condition, ENT_QUOTES).'"
                            data-describtion="'.htmlspecialchars($row->describtion, ENT_QUOTES).'">
                            <i class="fas fa-edit"></i>
                        </a>';

                $deleteBtn = '<a href="javascript:void(0)"
                            class="btn btn-outline-danger btn-sm delete"
                            data-id="'.$row->id.'">
                            <i class="fas fa-trash"></i>
                        </a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'condition'   => 'required|string|max:255',
            'describtion' => 'nullable|string',
        ]);

        Condition::create([
            'condition'   => $request->condition,
            'describtion' => $request->describtion,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Condition created successfully.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'condition'   => 'required|string|max:255',
            'describtion' => 'nullable|string',
        ]);

        $condition = Condition::findOrFail($id);

        $condition->update([
            'condition'   => $request->condition,
            'describtion' => $request->describtion,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Condition updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $condition = Condition::findOrFail($id);
        $condition->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Condition deleted successfully.',
        ]);
    }
}
