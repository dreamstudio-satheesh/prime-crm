<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;
   
    protected $table = 'address_books'; 

    protected $primaryKey = 'address_id'; // Primary key should match the primary key column name in the table

    protected $fillable = [
        'customer_id', 'customer_code', 'customer_type_id', 'index', 
        'contact_person', 'mobile_no', 'phone_no', 'email'
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
