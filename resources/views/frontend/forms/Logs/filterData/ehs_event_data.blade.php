@php
    use Carbon\Carbon;

@endphp

@forelse ($ehs as $index => $doc)  
    

        <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $doc->intiation_date ? \Carbon\Carbon::parse($doc->intiation_date)->format('d-M-Y') : 'Not Applicable' }}</td>
                <td>
                    <a href="{{ route('showEhs_event', $doc->id) }}" target ="_blank" style="color: black;" onmouseover="this.style.color='red'" onmouseout="this.style.color='black'">
               {{ $doc->division ? $doc->division->name : ' Not Applicable ' }}/EHS/{{ date('Y') }}/{{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}</a></td>
                <td>{{ $doc->division ? $doc->division->name : ' Not Applicable ' }}</td>
                <td>{{ Helpers::getFullDepartmentName($doc->Initiator_Group) ?: ' Not Applicable ' }}</td>
                <td>{{ $doc->short_description ?: ' Not Applicable ' }}</td>
                <td>{{ $doc->due_date ? \Carbon\Carbon::parse($doc->due_date)->format('d-M-Y') : ' Not Applicable ' }}</td>
                <td>{{ $doc->initiator ? $doc->initiator->name : ' Not Applicable ' }}</td>
                <td>{{ $doc->status ?: ' Not Applicable ' }}</td>
                
    
        </tr>
    
@empty
    <tr>
        <td colspan="12" class="text-center">
            <div class="alert alert-dark my-2" style="--bs-alert-bg:#999793; --bs-alert-color:#999793">
                Data Not Available
            </div>
        </td>
    </tr>
@endforelse
