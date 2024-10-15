<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Appuserdevice extends Model
{

    public $table = 'appuser_device';
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['appuser_id ', 'jwt_token','device_unique_id','device_type','os_version','app_version','device_token'];

    protected $primaryKey = 'id';

}
