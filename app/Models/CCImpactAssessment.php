<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CCImpactAssessment extends Model
{
    use HasFactory;
    protected $table = "cc_impact_assessments";
    protected $fillable = [
       'cc_id', 'remark_que1', 'remark_que2', 'remark_que3', 'remark_que4', 
        'remark_que5', 'remark_que6', 'remark_que7', 'remark_que8',
        'remark_que9', 'remark_que10', 'remark_que11', 'remark_que12',
        'remark_que13', 'remark_que14', 'remark_que15', 'remark_que16',
        'remark_que17', 'remark_que18', 'remark_que19', 'remark_que20',
        'remark_que21', 'remark_que22', 'remark_que23', 'remark_que24',
        'remark_que25', 'remark_que26', 'remark_que27', 'remark_que28',
        'remark_que29', 'remark_que30', 'remark_que31', 'remark_que32',
        'remark_que33',
    ];
}
