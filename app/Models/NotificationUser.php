<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    use HasFactory;
    protected $table = 'notification_users';
    protected $fillable = ['record_id', 'record_type', 'from_id', 'to_id', 'role_id'];
}
