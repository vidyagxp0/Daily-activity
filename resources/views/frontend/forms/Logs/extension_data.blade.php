@php
    use Carbon\Carbon;
@endphp
@forelse($extension as $root) 

        <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{$root->division ? $root->division->name : ' Not Applicable '}}/Ex/{{ date('Y') }}/{{ str_pad($root->record, 4, '0', STR_PAD_LEFT)}}</td>
                <td>{{$root->division ? $root->division->name : ' Not Applicable '}}</td>
                <td>{{ $root->priority_data ? $root->priority_data : ' Not Applicable ' }}</td>
                <td>{{$root->short_description}}</td>
                <td>{{$root->initiation_date ? Carbon::parse($root->initiation_date)->format('d-M-Y') : ' Not Applicable '}}</td>
                <td>{{$root->current_due_date ?  Carbon::parse($root->current_due_date)->format('d-M-Y'): ' Not Applicable'}}</td> 
                <td>{{$root->related_records ? $root->related_records : ' Not Applicable'}}</td> 
                <td>{{$root->qah_approval_completed_on ? Carbon::parse($root->qah_approval_completed_on)->format('d-M-Y') : ' Not Applicable '}}</td>
                <td>{{$root->status ? $root->status : ' Not Applicable '}}</td>    
           </tr>
    
@empty
    <tr>
        <td colspan="12" class="text-center">
            <div class="alert alert-warning my-2" style="--bs-alert-bg:#999793; --bs-alert-color:#060606 ">
                Data Not Found
            </div>
        </td>
    </tr>
@endforelse
