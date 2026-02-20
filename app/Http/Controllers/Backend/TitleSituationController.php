<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TitleSituation;
use Illuminate\Http\Request;

class TitleSituationController extends Controller
{
    // Index page
    public function index()
    {
        return view('backend.layouts.TitleSituation.index'); // Blade file path
    }

    // DataTable server-side
    public function getData()
    {
        $titleSituations = TitleSituation::latest()->get();

        return datatables()->of($titleSituations)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<a href="javascript:void(0)"
                            class="btn btn-outline-primary btn-sm edit"
                            data-id="'.$row->id.'"
                            data-titlesituation="'.htmlspecialchars($row->titleSituation, ENT_QUOTES).'"
                            data-description="'.htmlspecialchars($row->description, ENT_QUOTES).'">
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

    // Store new record
    public function store(Request $request)
    {
        $request->validate([
            'titleSituation' => 'required|string|max:255',
            'description'    => 'nullable|string',
        ]);

        TitleSituation::create([
            'titleSituation' => $request->titleSituation,
            'description'    => $request->description,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Title Situation created successfully.',
        ]);
    }

    // Update existing record
    public function update(Request $request, $id)
    {
        $request->validate([
            'titleSituation' => 'required|string|max:255',
            'description'    => 'nullable|string',
        ]);

        $titleSituation = TitleSituation::findOrFail($id);

        $titleSituation->update([
            'titleSituation' => $request->titleSituation,
            'description'    => $request->description,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Title Situation updated successfully.',
        ]);
    }

    // Delete record
    public function destroy($id)
    {
        $titleSituation = TitleSituation::findOrFail($id);
        $titleSituation->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Title Situation deleted successfully.',
        ]);
    }
}
