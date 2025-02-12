@php
    use Carbon\Carbon;

@endphp

@forelse ($auditprogram as $index => $doc)  
    

        <tr>
                <td>{{ $index + 1 }}</td>
                        <td>{{ $doc->intiation_date ? \Carbon\Carbon::parse($doc->intiation_date)->format('d-M-Y') : 'Not Applicable' }}</td>

                <!-- <td><a  href="{{ route('CC.show', $doc->id) }}" style="color: blue;"> -->
                {{-- <td>
                    <a href="{{ route('ShowAuditProgram', $doc->id) }}"      style="color: rgb(236,160,53); font-weight: bold; font-size: 16px;" onmouseover="this.style.color='red'" onmouseout="this.style.color='rgb(236,160,53)'">
                        
               {{ $doc->division ? $doc->division->name : ' Not Applicable ' }}/AP/{{ date('Y') }}/{{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}</a></td> --}}
               <td>
                <a href="{{ route('ShowAuditProgram', $doc->id) }}" 
                   target="_blank" 
                   style="color: rgb(236,160,53); font-weight: bold; font-size: 13px;" 
                   onmouseover="this.style.color='orange'" 
                   onmouseout="this.style.color='orange'">
                   {{ $doc->division ? $doc->division->name : ' Not Applicable ' }}/AP/{{ date('Y') }}/{{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}
                </a>
            </td>
            
                <td>{{ $doc->division ? $doc->division->name : ' Not Applicable ' }}</td>
                <td>{{ Helpers::getInitiatorGroupFullName($doc->Initiator_Group) ?: ' Not Applicable ' }}</td>
                <td>{{ $doc->short_description ?: ' Not Applicable ' }}</td>
                <td>{{ $doc->due_date ? \Carbon\Carbon::parse($doc->due_date)->format('d-M-Y') : ' Not Applicable ' }}</td>
                <td>{{ $doc->initiator ? $doc->initiator->name : ' Not Applicable ' }}</td>
                <td>{{ $doc->status ?: ' Not Applicable ' }}</td>
                
    
        </tr>
    
@empty
<tr>
    <td colspan="12" class="text-center">
    <div class="alert my-3" 
         style="background: linear-gradient(135deg, #e3f2fd, #ffffff); 
                border: 1px solid #bfd0f2; 
                border-radius: 16px; 
                padding: 30px; 
                box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);">
        <!-- Pharma Icon -->
        <div style="font-size: 60px; margin-bottom: 15px; display: inline-block; position: relative; padding: 20px; border-radius: 15px; background: linear-gradient(135deg, #42a5f5, #66bb6a); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; width: 100px;">
  <i class="fas fa-file-alt" style="color: white;"></i>
</div>



        <!-- Main Message -->
        <div style="font-size: 24px; font-weight: bold; color: #bfd0f2; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">
            No Data Available
        </div>
        <!-- Sub-Message -->
        <p style="margin-top: 10px; font-size: 16px; color: #616161;">
            We couldn't find any records. Please check your filters or try again later.
        </p>
        <!-- Pharma Logo (Optional) -->
        <!-- <div style="margin-top: 20px;">
            <img src="path/to/pharma-logo.png" alt="Pharma Logo" 
                 style="width: 80px; height: auto; opacity: 0.8;">
        </div> -->
    </div>
</td>

    </tr>
@endforelse
