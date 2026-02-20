<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Asset;

use Illuminate\Http\Request;


class AssetController extends Controller
{
    public function index()
    {
        return view("backend.layouts.Asset.index");
    }

    public function getData()
    {
        $assets = Asset::latest()->get();

        return Datatables()->of($assets)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<a href="javascript:void(0)"
                            class="btn btn-outline-primary btn-sm edit"
                            data-id="'.$row->id.'"
                            data-asset_name="'.$row->assetType.'"
                            data-description="'.$row->description.'"
                            >

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
            'asset_name' => 'required|string|max:255',
        ]);

        Asset::create([
            'assetType' => $request->asset_name,
            'description'=> $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Asset created successfully.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_name' => 'required|string|max:255',
        ]);

        $asset = Asset::findOrFail($id);

        $asset->update([
            'assetType' => $request->asset_name,
            'description'=> $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Asset updated successfully.',
        ]);
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Asset deleted successfully.',
        ]);
    }
}
