<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = ['customer_id'];

    protected $primaryKey = 'customer_id';

     protected $fillable = [
        'customer_name', 
    ];  

    
}
