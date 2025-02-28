<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;   
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'm_kategori'; // Sesuaikan dengan nama tabel di database

    protected $fillable = [
        'kategori',
        'kategori_nama',
        'created_at'
    ];
}
