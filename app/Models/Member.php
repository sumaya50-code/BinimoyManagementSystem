<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'nid', 'phone', 'nominee_name', 'nominee_relation', 'status'
    ];

    
}
