<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Yajra\DataTables\Facades\DataTables;

class LeadManage extends Controller
{
    public function index()
    {
        return view('backend.layouts.leads.index');
    }




  public function getData()
{
    $leads = Lead::with(['asset','condition'])->latest();

    return DataTables::of($leads)
        ->addIndexColumn()

        ->addColumn('asset_name',fn($row)=>$row->asset->assetType ?? 'N/A')
        ->addColumn('condition_name',fn($row)=>$row->condition->condition ?? 'N/A')

        ->addColumn('status',function($row){

            return '
            <select class="form-select form-select-sm change-status"
                    data-id="'.$row->id.'">
                <option value="pending" '.($row->status=='pending'?'selected':'').'>Pending</option>
                <option value="contacted_by_mail" '.($row->status=='contacted_by_mail'?'selected':'').'>Mail</option>
                <option value="contacted_by_message" '.($row->status=='contacted_by_message'?'selected':'').'>Message</option>
                <option value="not_interested" '.($row->status=='not_interested'?'selected':'').'>Not Interested</option>
            </select>
            ';
        })

       ->addColumn('action',function($row){
    return '
        <a href="'.route('leads.manage.show',$row->id).'"
           class="btn btn-sm btn-outline-info me-1 mt-2"
           title="View">
           <i class="fas fa-eye"></i>
        </a>

        <a href="'.route('leads.manage.mail',$row->id).'"
           class="btn btn-sm btn-outline-primary me-1 mt-2"
           title="Send Mail">
           <i class="fas fa-envelope"></i>
        </a>

        <button class="btn btn-sm btn-outline-danger delete mt-2"
                data-id="'.$row->id.'"
                title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    ';
})

        ->rawColumns(['status','action'])
        ->make(true);
}

public function statusUpdate(Request $request)
{
    $lead = Lead::findOrFail($request->id);
    $lead->status = $request->status;
    $lead->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Lead status updated successfully.',
    ]);


}

public function destroy($id)
{

    $lead = Lead::findOrFail($id);
    $lead->delete();

    return response()->json([
        'status' => 'success',
        'message' => 'Lead deleted successfully.',
    ]);
}

public function show($id)
{
    $lead = Lead::with(['asset','condition','title',])->findOrFail($id);
    return view('backend.layouts.leads.view',compact('lead'));
}

public function mail($id)
{
    $lead = Lead::with(['asset','condition','title',])->findOrFail($id);
    return view('backend.layouts.leads.mail',compact('lead'));
}

public function sendEmail(Request $request, $id)
{

    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'attachment' => 'nullable|file|max:5120',
    ]);


    $lead = Lead::findOrFail($id);
    $lead->status = 'contacted_by_mail';
    $lead->save();

    $mailData = [
        'subject' => $request->subject,
        'message' => $request->message,
        'lead' => $lead,
    ];

$email = $lead->email;

Mail::to($email)->send(new \App\Mail\ClientMail($mailData, $request->file('attachment')));

    return response()->json([
        'status' => 'success',
        'message' => 'Email sent successfully to ' . $lead->email,
    ]);
}

}
