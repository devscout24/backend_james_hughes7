<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\Lead;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LeadController extends Controller
{
  use ApiResponse;
public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'asset_id'     => 'nullable|exists:assets,id',
                'condition_id' => 'nullable|exists:conditions,id',
                'title_id'     => 'nullable|exists:title_situations,id',
                'year' => 'nullable|digits:4|integer|min:1900|max:' . date('Y'),
                'model'        => 'nullable|string|max:255',
                'mileage'      => 'nullable|string|max:255',
                'vin'          => 'nullable|string|max:255',
                'mainGoal'     => 'nullable|string|max:255',
                'sellerUpside' => 'nullable|string|max:255',
                'fullName'     => 'nullable|string|max:255',
                'phone'        => 'nullable|string|max:50',
                'email'        => 'nullable|email|max:255',
                'notes'        => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }


            if ($request->id) {
                $lead = Lead::find($request->id);
                if (!$lead) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Lead not found.'
                    ], 404);
                }
            } else {
                $lead = new Lead();
            }


            $lead->asset_id     = $request->asset_id;
            $lead->condition_id = $request->condition_id;
            $lead->title_id     = $request->title_id;
            $lead->year         = $request->year;
            $lead->model        = $request->model;
            $lead->mileage      = $request->mileage;
            $lead->vin          = $request->vin;
            $lead->mainGoal     = $request->mainGoal;
            $lead->make         = $request->make;
            $lead->sellerUpside = $request->sellerUpside;
            $lead->fullName     = $request->fullName;
            $lead->phone        = $request->phone;
            $lead->email        = $request->email;
            $lead->notes        = $request->notes;


            $lead->save();


            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $file = $image;
                    $filename = time() . '_' . uniqid() . $file->getClientOriginalName();
                    $filePath = 'uploads/lead/';
                    $file->move(public_path($filePath), $filename);

                    $LeadImage = new GalleryImage();
                    $LeadImage->image = $filePath . $filename;
                    $LeadImage->lead_id = $lead->id;
                    $LeadImage->save();
                }
            }










            return response()->json([
                'status'  => 'success',
                'message' => $request->id ? 'Lead updated successfully' : 'Lead created successfully',
                'data'    => $lead
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

}
