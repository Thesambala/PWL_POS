<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;   
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    
    protected $table = 'm_level'; // Pastikan nama tabel benar
    protected $primaryKey = 'level_id'; // Tentukan Primary Key
}
