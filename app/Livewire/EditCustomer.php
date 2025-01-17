<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Licence;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Location;
use App\Models\CustomerType;
use App\Models\MobileNumber;

class EditCustomer extends Component
{
    public $customer;
    public $products;
    public $locations;
    public $licences;
    public $users;

    // Customer properties
    public $customer_name;
    public $tally_serial_no;
    public $licence_editon_id;
    public $primary_address_id;
    public $product_id;
    public $location_id;
    public $staff_id;
    public $amc;
    public $tss_status;
    public $tss_adminemail;
    public $tss_expirydate;
    public $profile_status;
    public $remarks;
    public $whatsapp_telegram_group;
    public $tdl_addons;
    public $auto_backup;
    public $cloud_user;
    public $mobile_app;
    public $gst_no;
    public $map_location;
    public $latitude;
    public $longitude;

    public $addresses = [];
    public $addressTypes;

    // AMC fields
    public $amc_from_date;
    public $amc_to_date;
    public $amc_renewal_date;
    public $no_of_visits;
    public $amc_amount;
    public $amc_last_year_amount;

    protected $rules = [
        'customer_name' => 'required|string|max:191',
        'tally_serial_no' => 'nullable|string|max:191',
        'primary_address_id' => 'nullable|exists:address_books,address_id',
        'licence_editon_id' => 'nullable|exists:licences,id',
        'product_id' => 'nullable|exists:products,id',
        'location_id' => 'nullable|exists:locations,id',
        'staff_id' => 'nullable|exists:users,id',
        'amc' => 'required|in:yes,no',
        'tss_status' => 'required|in:active,inactive',
        'tss_adminemail' => 'nullable|email|max:191',
        'tss_expirydate' => 'nullable|date',
        'profile_status' => 'nullable|in:Followup,Others',
        'remarks' => 'nullable|string|max:191',
        'whatsapp_telegram_group' => 'nullable|boolean',
        'tdl_addons' => 'nullable|string|max:191',
        'auto_backup' => 'nullable|boolean',
        'cloud_user' => 'nullable|boolean',
        'mobile_app' => 'nullable|boolean',
        'gst_no' => 'nullable|string|max:191',
        'map_location' => 'nullable|string|max:191',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'amc_from_date' => 'nullable|date',
        'amc_to_date' => 'nullable|date',
        'amc_renewal_date' => 'nullable|date',
        'no_of_visits' => 'nullable|integer',
        'amc_amount' => 'nullable|numeric',
        'amc_last_year_amount' => 'nullable|numeric',
    ];

    public function mount(Customer $customer)
    {
        $this->customer = $customer;
        $this->customer_name = $customer->customer_name;
        $this->tally_serial_no = $customer->tally_serial_no;
        $this->licence_editon_id = $customer->licence_editon_id;
        $this->primary_address_id = $customer->primary_address_id;
        $this->product_id = $customer->product_id;
        $this->location_id = $customer->location_id;
        $this->staff_id = $customer->staff_id;
        $this->amc = $customer->amc;
        $this->tss_status = $customer->tss_status;
        $this->tss_adminemail = $customer->tss_adminemail;
        $this->tss_expirydate = $customer->tss_expirydate;
        $this->profile_status = $customer->profile_status;
        $this->remarks = $customer->remarks;
        $this->whatsapp_telegram_group = $customer->whatsapp_telegram_group;
        $this->tdl_addons = $customer->tdl_addons;
        $this->auto_backup = $customer->auto_backup;
        $this->cloud_user = $customer->cloud_user;
        $this->mobile_app = $customer->mobile_app;
        $this->gst_no = $customer->gst_no;
        $this->map_location = $customer->map_location;
        $this->latitude = $customer->latitude;
        $this->longitude = $customer->longitude;
        $this->addresses = $customer->addresses()->get()->map(function ($address) {
            return [
                'address_id' => $address->address_id,
                'customer_type_id' => $address->customer_type_id,
                'contact_person' => $address->contact_person,
                'mobile_no' => MobileNumber::where('address_id', $address->address_id)->pluck('mobile_no')->toArray(),
                'phone_no' => $address->phone_no,
                'email' => $address->email,
            ];
        })->toArray();

        // Load AMC details
        $amcRecord = $customer->amc()->first();
        if ($amcRecord) {
            $this->amc_from_date = $amcRecord->amc_from_date;
            $this->amc_to_date = $amcRecord->amc_to_date;
            $this->amc_renewal_date = $amcRecord->amc_renewal_date;
            $this->no_of_visits = $amcRecord->no_of_visits;
            $this->amc_amount = $amcRecord->amc_amount;
            $this->amc_last_year_amount = $amcRecord->amc_last_year_amount;
        }


        $this->products = Product::all();
        $this->locations = Location::all();
        $this->licences = Licence::all();
        $this->users = User::all();
        $this->addressTypes = CustomerType::orderBy('name', 'asc')->get();
    }

    public function save()
    {
        $this->validate();

        // Update customer details without primary_address_id
        $this->customer->update([
            'customer_name' => $this->customer_name,
            'tally_serial_no' => $this->tally_serial_no,
            'product_id' => $this->product_id,
            'location_id' => $this->location_id,
            'staff_id' => $this->staff_id,
            'amc' => $this->amc,
            'tss_status' => $this->tss_status,
            'tss_adminemail' => $this->tss_adminemail,
            'tss_expirydate' => $this->tss_expirydate,
            'profile_status' => $this->profile_status,
            'remarks' => $this->remarks,
            'whatsapp_telegram_group' => $this->whatsapp_telegram_group,
            'tdl_addons' => $this->tdl_addons,
            'auto_backup' => $this->auto_backup,
            'cloud_user' => $this->cloud_user,
            'mobile_app' => $this->mobile_app,
            'gst_no' => $this->gst_no,
            'map_location' => $this->map_location,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        // Update AMC details
        if ($this->amc === 'yes') {
            $this->customer->amc()->updateOrCreate(
                ['customer_id' => $this->customer->customer_id],
                [
                    'amc_from_date' => $this->amc_from_date,
                    'amc_to_date' => $this->amc_to_date,
                    'amc_renewal_date' => $this->amc_renewal_date,
                    'no_of_visits' => $this->no_of_visits,
                    'amc_amount' => $this->amc_amount,
                    'amc_last_year_amount' => $this->amc_last_year_amount,
                ]
            );
        } else {
            $this->customer->amc()->delete();
        }

        // Update addresses
        foreach ($this->addresses as $address) {
            if (!empty($address['customer_type_id'])) {
                $addressData = [
                    'customer_type_id' => $address['customer_type_id'],
                    'contact_person' => $address['contact_person'],
                    'phone_no' => $address['phone_no'],
                    'email' => $address['email'],
                    'customer_id' => $this->customer->customer_id,
                ];

                $createdAddress = $this->customer->addresses()->updateOrCreate(
                    ['address_id' => $address['address_id']],
                    $addressData
                );

                // Save mobile numbers
                MobileNumber::where('address_id', $createdAddress->address_id)->delete();
                foreach ($address['mobile_no'] as $mobileNo) {
                    if (!empty($mobileNo)) {
                        MobileNumber::create([
                            'address_id' => $createdAddress->address_id,
                            'mobile_no' => $mobileNo,
                        ]);
                    }
                }

                // Check if this address is the primary address
                if ($address['address_id'] == $this->primary_address_id) {
                    $this->primary_address_id = $createdAddress->address_id;
                }
            }
        }

        // Update the customer with the primary_address_id
        if ($this->primary_address_id) {
            $this->customer->update(['primary_address_id' => $this->primary_address_id]);
        }

        session()->flash('message', 'Customer updated successfully.');
        return redirect()->route('customers.index');
    }

    public function addAddress()
    {
        $this->addresses[] = [
            'address_id' => uniqid(),
            'customer_type_id' => '',
            'contact_person' => '',
            'mobile_no' => [''],
            'phone_no' => '',
            'email' => '',
        ];
    }

    public function removeAddress($index)
    {
        unset($this->addresses[$index]);
        $this->addresses = array_values($this->addresses);
    }

    public function addMobileNo($addressIndex)
    {
        $this->addresses[$addressIndex]['mobile_no'][] = '';
    }

    public function removeMobileNo($addressIndex, $mobileIndex)
    {
        unset($this->addresses[$addressIndex]['mobile_no'][$mobileIndex]);
        $this->addresses[$addressIndex]['mobile_no'] = array_values($this->addresses[$addressIndex]['mobile_no']);
    }

    public function render()
    {
        return view('livewire.edit-customer');
    }
}
