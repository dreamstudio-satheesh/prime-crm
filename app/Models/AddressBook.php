<?php

namespace App\Models;

use App\Models\MobileNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddressBook extends Model
{
    use HasFactory;
   
    protected $table = 'address_books'; 

    protected $primaryKey = 'address_id'; // Primary key should match the primary key column name in the table

    protected $fillable = [
        'customer_id', 
        'index', 
        'customer_code', 
        'customer_type_id', 
        'contact_person', 
        'email', 
        'address', 
        'pin_code', 
        'state', 
        'country'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }


    public function mobileNumbers()
    {
        return $this->hasMany(MobileNumber::class, 'address_id', 'address_id');
    }
}
