<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendado extends Model
{
    use HasFactory;

    protected $fillable = ['acess_number', 'dados'];
}
