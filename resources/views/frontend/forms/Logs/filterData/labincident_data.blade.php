@forelse ($labincident as $lablog)
@php
$incidentReportsCollection = collect($lablog->incidentInvestigationReports);
$firstLablogPrinted = false;
$rowSpanCount = $incidentReportsCollection->sum(function($secondIncident) {
    return collect($secondIncident['data'])->count();
});
@endphp

@foreach($incidentReportsCollection as $secondIncident)
@foreach(collect($secondIncident['data']) as $dataaas)
<tr>
    @if (!$firstLablogPrinted)
    <td rowspan="{{ $rowSpanCount }}">{{ $loop->parent->parent->index + 1 }}</td> <!-- Adjusted to get the index from the parent loop -->
    <td rowspan="{{ $rowSpanCount }}">{{ $lablog->intiation_date }}</td>
    <td rowspan="{{ $rowSpanCount }}">{{ $lablog->Initiator_Group}}/LI/{{ date('Y') }}/{{ str_pad($lablog->record, 4, '0', STR_PAD_LEFT) }}</td>
    <td rowspan="{{ $rowSpanCount }}">{{ $lablog->initiator ? $lablog->initiator->name : '-' }}</td>
    <td rowspan="{{ $rowSpanCount }}">{{ $lablog->Initiator_Group }}</td>
    <td rowspan="{{ $rowSpanCount }}">{{ $lablog->division ? $lablog->division->name : '-' }}</td>
    <td rowspan="{{ $rowSpanCount }}">{{ $lablog->short_desc }}</td>
    <td rowspan="{{ $rowSpanCount}}">{{$lablog->type_incidence_ia;}}</td>
    @php
        $firstLablogPrinted = true;
    @endphp
<td>{{ isset($dataaas['name_of_product']) ? $dataaas['name_of_product'] : '' }}</td>
<td>{{ isset($dataaas['batch_no']) ? $dataaas['batch_no'] : '' }}</td>


                <td>{{ $lablog->due_date }}</td>
                <td>{{ $lablog->closure_completed_on }}</td>
                <td>{{ $lablog->status }}</td>
                @endif
            </tr>
            @endforeach
            @endforeach
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
        <!-- Pharma Icon -->
        <div style="font-size: 60px; margin-bottom: 15px; display: inline-block; position: relative; padding: 20px; border-radius: 15px; background: linear-gradient(135deg, #42a5f5, #66bb6a); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; width: 100px;">
  <i class="fas fa-file-alt" style="color: white;"></i>
</div>



        <!-- Main Message -->
        <div style="font-size: 24px; font-weight: bold; color: #003366; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);">
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