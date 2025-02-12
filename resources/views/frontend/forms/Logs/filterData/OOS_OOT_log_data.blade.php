@php
    use Carbon\Carbon;
@endphp

{{-- Display OOT Data --}}
@forelse ($oots as $index => $doc)  
    <tr>
        <td>{{ $loop->iteration }}</td> {{-- Correctly indexing across all iterations --}}
        <td>{{ $doc->intiation_date ? (\Carbon\Carbon::parse($doc->intiation_date)->format('d-M-Y')) : 'Not Applicable' }}</td>
        <td>
            <a href="{{ route('rcms/oot_view', $doc->id) }}" target="_blank" style="color: rgb(236,160,53); font-weight: bold; font-size: 16px;">
               {{ $doc->division ? $doc->division->name : 'Not Applicable' }}/OOT/{{ date('Y') }}/{{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}
            </a>
        </td>
        <td>{{ $doc->division ? $doc->division->name : 'Not Applicable' }}</td>
        <td>{{ Helpers::getInitiatorGroupFullName($doc->initiator_group) ?: 'Not Applicable' }}</td>
        <td>{{ $doc->short_description ?: 'Not Applicable' }}</td>
        <td>{{ $doc->due_date ? (\Carbon\Carbon::parse($doc->due_date)->format('d-M-Y')) : 'Not Applicable' }}</td>
        <td>{{ $doc->initiator ? $doc->initiator->name : 'Not Applicable' }}</td>
        <td>{{ $doc->status ?: 'Not Applicable' }}</td>
    </tr>
@empty
<tr>
    <td colspan="12" class="text-center">
        <div class="alert my-3" 
             style="background: linear-gradient(135deg, #e3f2fd, #ffffff); 
                    border: 1px solid #90caf9; 
                    border-radius: 16px; 
                    padding: 30px; 
                    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);">
            <div style="font-size: 60px; margin-bottom: 15px; display: inline-block; position: relative; padding: 20px; border-radius: 15px; background: linear-gradient(135deg, #42a5f5, #66bb6a); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; width: 100px;">
                <i class="fas fa-file-alt" style="color: white;"></i>
            </div>
            <div style="font-size: 24px; font-weight: bold; color: #003366; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">
                No OOT Data Available
            </div>
            <p style="margin-top: 10px; font-size: 16px; color: #616161;">
                We couldn't find any OOT records. Please check your filters or try again later.
            </p>
        </div>
    </td>
</tr>
@endforelse

{{-- Display OOS Data --}}
@forelse ($oos as $index => $doc)  
    <tr>
        <td>{{ $loop->iteration + count($oots) }}</td> {{-- Continuing numbering after OOT data --}}
        <td>{{ $doc->intiation_date ? (\Carbon\Carbon::parse($doc->intiation_date)->format('d-M-Y')) : 'Not Applicable' }}</td>
        <td>
            <a href="{{ route('oos.oos_view', $doc->id) }}" target="_blank" style="color: rgb(236,160,53); font-weight: bold; font-size: 16px;">
               {{ $doc->division ? $doc->division->name : 'Not Applicable' }}/OOS/{{ date('Y') }}/{{ str_pad($doc->id, 4, '0', STR_PAD_LEFT) }}
            </a>
        </td>
        <td>{{ $doc->division ? $doc->division->name : 'Not Applicable' }}</td>
        <td>{{ Helpers::getInitiatorGroupFullName($doc->initiator_group) ?: 'Not Applicable' }}</td>
        <td>{{ $doc->description_gi ?: 'Not Applicable' }}</td>
        <td>{{ $doc->due_date ? (\Carbon\Carbon::parse($doc->due_date)->format('d-M-Y')) : 'Not Applicable' }}</td>
        <td>{{ $doc->initiator ? $doc->initiator->name : 'Not Applicable' }}</td>
        <td>{{ $doc->status ?: 'Not Applicable' }}</td>
    </tr>
@empty
<tr>
    <td colspan="12" class="text-center">
        <div class="alert my-3" 
             style="background: linear-gradient(135deg, #e3f2fd, #ffffff); 
                    border: 1px solid #90caf9; 
                    border-radius: 16px; 
                    padding: 30px; 
                    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);">
            <div style="font-size: 60px; margin-bottom: 15px; display: inline-block; position: relative; padding: 20px; border-radius: 15px; background: linear-gradient(135deg, #42a5f5, #66bb6a); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; width: 100px;">
                <i class="fas fa-file-alt" style="color: white;"></i>
            </div>
            <div style="font-size: 24px; font-weight: bold; color: #003366; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">
                No OOS Data Available
            </div>
            <p style="margin-top: 10px; font-size: 16px; color: #616161;">
                We couldn't find any OOS records. Please check your filters or try again later.
            </p>
        </div>
    </td>
</tr>
@endforelse
