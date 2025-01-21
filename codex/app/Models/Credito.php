<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credito extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "crediti";
    protected $primaryKey = "idCredito";
    protected $fillable = [
        "idContatto",
        "credito"
    ];
}
