<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departamentos extends Model
{
    use HasFactory;
    //definir la llave primaria de nuestra tabla
    protected $primaryKey = 'idd';
    protected $fillable = ['idd','nombre'];
}
