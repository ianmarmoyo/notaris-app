<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MyApplication extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value'];
}
