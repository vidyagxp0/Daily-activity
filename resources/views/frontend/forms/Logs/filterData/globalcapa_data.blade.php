@php
    use Carbon\Carbon;

@endphp

@forelse ($gcapas as $index => $doc)  
    

        <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $doc->intiation_date ? \Carbon\Carbon::parse($doc->intiation_date)->format('d-M-Y') : 'Not Applicable' }}</td>
                <!-- <td><a  href="{{ route('CC.show', $doc->id) }}" style="color: blue;"> -->
                <td>
                    <a href="{{ route('globalCapaShow', $doc->id) }}" style="color: black;" onmouseover="this.style.color='red'" target = '_blank' onmouseout="this.style.color='black'">
               {{ $doc->division ? $doc->division->name : ' Not Applicable ' }}/Global CAPA/{{ date('Y') }}/{{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}</a></td>
                <td>{{ $doc->division ? $doc->division->name : ' Not Applicable ' }}</td>
                <td>{{ $doc->initiator_Group ?: ' Not Applicable ' }}</td>
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
