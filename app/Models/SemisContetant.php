<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SemisContetant extends Model
{
    use HasFactory;
    protected $table = "semis_contestant";

    protected $fillable = [
        "contestantID",
        "eventID",
        "rank",
        "category"
    ];
}
