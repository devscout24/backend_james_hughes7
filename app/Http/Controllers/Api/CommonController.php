<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Models\Faq;
use App\Models\SupportAndHelp;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CommonController extends Controller
{


 use ApiResponse;



 public function privacyPolicy(){
        $privacy = DynamicPage::where('slug', 'like','privacy-policy')
                              ->orWhere('slug', 'like','privacy')
                              ->orWhere('slug', 'like','privacy-and-policy')
                               ->where('status', 1)
                              ->first();

        $data = [
            'privacy' => $privacy
        ];

        return $this->success($data, "Privacy Policy retrieved successfully");
    }

    // Fetch Terms and Conditions
    public function termCondition(){
          $term_condition = DynamicPage::where('slug', 'like', 'term-and-condition%')
                            ->orWhere('slug', 'like', 'terms-and-conditions%')
                            ->orWhere('slug', 'like', '%terms-and-condition%')
                            ->orWhere('slug','like','terms')
                            ->first();




        $data = [
            'term_condition' => $term_condition
        ];

        return $this->success($data, "Terms and Conditions retrieved successfully"); // Correct message
    }




 public function allNotificationList(){
        try{
              $user=Auth::guard('api')->user();

              if(!$user){
                return $this->unauthorized([],"Unauthorized");
              }

              $notifications = $user->notifications()->get();

            return $this->success($notifications, "Notifications retrieved successfully");
        }
        catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }


    public function markAllReadNotification(){
        try{
              $user=Auth::guard('api')->user();
             $user->notifications()->where('is_read', false)->get();

              foreach($user->notifications as $notification){
                  $notification->is_read = true;
                  $notification->save();
              }

              $data= $user->notifications()->where('is_read', true)->get();
            return $this->success($data, "All notifications marked as read successfully");
        }
        catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function readNotification($id){
        try{
              $user=Auth::guard('api')->user();
             $user->notifications()->where('id', $id)->update(['is_read' => true]);
            return $this->success([], "Notification marked as read successfully");
        }
        catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }



}
