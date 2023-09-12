<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empleados extends Model
{
    use HasFactory;
    protected $primaryKey = 'ide';
    protected $fillable = ['idd','nombre','apellido','sexo','idd','descripcion','email','celular'];
}
