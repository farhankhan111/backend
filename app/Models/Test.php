<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Test extends Model
{
    use HasFactory;
    protected $table = 'sql_inj';

    protected $fillable = ['name'];

    public $timestamps = false;






}
