<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Condition;
use App\Models\TitleSituation;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LeadDataController extends Controller
{
    use ApiResponse;
    public function AssetData(){
        try{
           $data=Asset::with('property')->get();

           $data->map(function($item){
            $item->image=asset($item->image);
            return $item;
           });

           return $this->success($data);
        }
        catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function ConditionData(){
        try{
            $data=Condition::all();
                return $this->success($data);

        }
                catch(\Exception $e){
                    return $this->error($e->getMessage());
                }
    }


      public function TitleData(){
        try{
            $data=TitleSituation::all();
                return $this->success($data);

        }
                catch(\Exception $e){
                    return $this->error($e->getMessage());
                }
    }
}
