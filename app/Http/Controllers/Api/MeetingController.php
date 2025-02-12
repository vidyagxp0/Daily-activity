<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Capa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public  function create_action_item(Request $request)
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body'  => []
        ];

        try {

            $action_item = new ActionItem;
            $action_item->short_description = $request->short_description;
            $action_item->initiator_id = $request->initiator_id;
            $action_item->intiation_date = today()->format('d M Y');;
            $action_item->record = DB::table('record_numbers')->value('counter') + 1;
            $action_item->division_code = 'Corporate';
            $action_item->division_id = 1;
            $action_item->due_date = today()->addDays(30)->format('d M Y');
            $action_item->stage = 1;
            $action_item->status = 'Opened';
            $action_item->save();

            $counter = DB::table('record_numbers')->value('counter');
            $newCounter = $counter + 1;
            DB::table('record_numbers')->update(['counter' => $newCounter]);

        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }


}