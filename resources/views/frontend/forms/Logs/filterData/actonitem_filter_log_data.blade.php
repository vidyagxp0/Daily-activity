<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

@php
    use Carbon\Carbon;
@endphp
@forelse($actionitem as $action_item) 

        <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{$action_item->intiation_date ? $action_item->intiation_date:'Not Applicable'}}</td>
                <td>
                    <a href="{{ route('actionItem.show', $action_item->id) }}" 
                       style="color: rgb(236,160,53); font-weight: bold; font-size: 16px;" 
                       onmouseover="this.style.color='orange'" 
                       onmouseout="this.style.color='rgb(236,160,53)'">
                      {{$action_item->division ? $action_item->division->name : ' Not Applicable '}}/AI/{{ date('Y') }}/{{ str_pad($action_item->record, 4, '0', STR_PAD_LEFT)}}
                    </a>
                  </td>
                  
                <td>{{$action_item->division ? $action_item->division->name : ' Not Applicable '}}</td>
                <td>{{ Helpers::getFullDepartmentName($action_item->departments) ? Helpers::getFullDepartmentName($action_item->departments) : ' Not Applicable ' }}</td>
                <td>{{$action_item->short_description}}</td>
                <td>{{$action_item->due_date ? Carbon::parse($action_item->due_date)->format('d-M-Y') : ' Not Applicable '}}</td>
                <td>{{$action_item->initiator ? $action_item->initiator->name : ' Not Applicable '}}</td>
                <td>{{$action_item->status ? $action_item->status : ' Not Applicable '}}</td>    
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
        <div style="font-size: 60px; margin-bottom: 15px; display: inline-block; position: relative; padding: 20px; border-radius: 15px; background: linear-gradient(135deg, #bfd0f2, #66bb6a); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); transition: all 0.3s ease; width: 100px;">
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
      
    </div>
</td>

    </tr>
@endforelse
