<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class empleados extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'ide';
    // cada que agregemos una columna a la BD hay que agregarla al modelo
    protected $fillable = ['idd','nombre','apellido','sexo','idd','descripcion',
                            'email','celular','edad','salario','img'];
}
