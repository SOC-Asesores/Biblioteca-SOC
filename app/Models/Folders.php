<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
    	'img',
    	'url',
    	'id_folder'
    ];
}
