<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AssetController extends Controller
{
    public function index()
    {
        return view("backend.layouts.Asset.index");
    }

    public function getData()
    {
        $assets = Asset::with('property')->latest()->get();

        return datatables()->of($assets)
            ->addIndexColumn()

            ->addColumn('image', function ($row) {
                if ($row->image && File::exists(public_path($row->image))) {
                    return '<img src="' . asset($row->image) . '" width="60" class="rounded">';
                }
                return 'No Image';
            })

            ->addColumn('properties', function ($row) {
                if ($row->property->count() > 0) {
                    return $row->property->pluck('property_name')->implode(', ');
                }
                return 'No Properties';
            })

            ->addColumn('action', function ($row) {

                $properties = $row->property->pluck('property_name');

                return '
                    <button class="btn btn-outline-primary btn-sm edit"
                        data-id="'.$row->id.'"
                        data-asset_name="'.$row->assetType.'"
                        data-description="'.$row->description.'"
                        data-image="'.asset($row->image).'"
                        data-properties=\''.json_encode($properties).'\'>
                        <i class="fas fa-edit"></i>
                    </button>

                    <button class="btn btn-outline-danger btn-sm delete"
                        data-id="'.$row->id.'">
                        <i class="fas fa-trash"></i>
                    </button>
                ';
            })

            ->rawColumns(['image','action'])
            ->make(true);
    }

   public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'asset_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        'properties.*' => 'nullable|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('assets', 'public');
    }

    $asset = Asset::create([
        'assetType' => $request->asset_name,
        'description'=> $request->description,
        'image' => $imagePath,
    ]);

    // Save properties
    if ($request->properties) {
        foreach ($request->properties as $property) {
            if ($property) {
                AssetProperty::create([
                    'asset_id' => $asset->id,
                    'property_name' => $property
                ]);
            }
        }
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Asset created successfully.'
    ]);
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'properties.*' => 'nullable|string'
        ]);

        $asset = Asset::findOrFail($id);

        // Update Image if new uploaded
        if ($request->hasFile('image')) {

            if ($asset->image && File::exists(public_path($asset->image))) {
                File::delete(public_path($asset->image));
            }

            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/assets'), $filename);
            $asset->image = 'uploads/assets/'.$filename;
        }

        // Update Main Data
        $asset->update([
            'assetType'   => $request->asset_name,
            'description' => $request->description,
        ]);

        // Delete old properties
        AssetProperty::where('asset_id', $asset->id)->delete();

        // Insert new properties
        if ($request->properties) {
            foreach ($request->properties as $property) {
                if (!empty($property)) {
                    AssetProperty::create([
                        'asset_id' => $asset->id,
                        'property_name' => $property
                    ]);
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Asset updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);

        // Delete Image
        if ($asset->image && File::exists(public_path($asset->image))) {
            File::delete(public_path($asset->image));
        }

        $asset->delete(); // properties auto delete (cascade)

        return response()->json([
            'status' => 'success',
            'message' => 'Asset deleted successfully.'
        ]);
    }
}
