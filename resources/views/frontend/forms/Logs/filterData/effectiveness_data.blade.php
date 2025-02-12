@php
    use Carbon\Carbon;
@endphp
@forelse($effectivness as $action_item) 
    <tr>
        <td>{{$loop->index + 1}}</td>
        <td>{{$action_item->division ? $action_item->division->name : ' Not Applicable '}}/EC/{{ date('Y') }}/{{ str_pad($action_item->record, 4, '0', STR_PAD_LEFT)}}</td>
        <td>{{$action_item->intiation_date ? $action_item->intiation_date:'Not Applicable'}}</td>
        <td>{{$action_item->division ? $action_item->division->name : ' Not Applicable '}}</td>
        <td>{{$action_item->short_description}}</td>
        <td>{{$action_item->due_date ? Carbon::parse($action_item->due_date)->format('d-M-Y') : ' Not Applicable '}}</td>
        <td>{{$action_item->initiator ? $action_item->initiator->name : ' Not Applicable '}}</td>
        <td>{{$action_item->effective_approval_complete_on ? Carbon::parse($action_item->effective_approval_complete_on)->format('d-M-Y') : ' Not Applicable '}}</td>
        <td>{{$action_item->status ? $action_item->status : ' Not Applicable '}}</td>
    </tr>
@empty
    <tr>
        <td colspan="9" class="text-center">
            <div class="alert alert-warning my-2">
                No records found for the selected date range or criteria.
            </div>
        </td>
    </tr>
@endforelse
