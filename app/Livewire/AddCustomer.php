<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Licence;
use App\Models\Product;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Location;
use App\Models\AddressBook;
use App\Models\CustomerType;
use App\Models\MobileNumber;

class AddCustomer extends Component
{
    public $products;
    public $locations;
    public $licences;
    public $users;

    public $customer_name;
    public $tally_serial_no;
    public $licence_editon_id;
    public $primary_address_id;
    public $product_id;
    public $location_id;
    public $staff_id;
    public $amc = 'no';
    public $tss_status = 'inactive';
    public $tss_adminemail;
    public $tss_expirydate;
    public $profile_status;
    public $remarks;
    public $whatsapp_telegram_group;
    public $tdl_addons;
    public $auto_backup = false;
    public $cloud_user = false;
    public $mobile_app = false;
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

        // AMC validation rules
        'amc_from_date' => 'nullable|date',
        'amc_to_date' => 'nullable|date',
        'amc_renewal_date' => 'nullable|date',
        'no_of_visits' => 'nullable|integer',
        'amc_amount' => 'nullable|numeric',
        'amc_last_year_amount' => 'nullable|numeric',
    ];

    public function save()
    {
        $this->validate();

        // Filter out empty addresses
        $this->addresses = array_filter($this->addresses, function ($address) {
            return !empty($address['customer_type_id']);
        });

        $customer = Customer::create([
            'customer_name' => $this->customer_name,
            'tally_serial_no' => $this->tally_serial_no,
            'licence_editon_id' => $this->licence_editon_id,
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

        if ($this->amc === 'yes') {
            $customer->amc()->create([
                'customer_id' => $customer->customer_id,
                'amc_from_date' => $this->amc_from_date,
                'amc_to_date' => $this->amc_to_date,
                'amc_renewal_date' => $this->amc_renewal_date,
                'no_of_visits' => $this->no_of_visits,
                'amc_amount' => $this->amc_amount,
                'amc_last_year_amount' => $this->amc_last_year_amount,
            ]);
        }

        $primaryAddressId = null;
        if ($this->addresses) {
            foreach ($this->addresses as $index => $address) {
                $addressData = [
                    'customer_type_id' => $address['customer_type_id'],
                    'contact_person' => $address['contact_person'],
                    'phone_no' => $address['phone_no'],
                    'email' => $address['email'],
                    'customer_id' => $customer->customer_id,
                ];

                $createdAddress = AddressBook::create($addressData);

                foreach ($address['mobile_no'] as $mobileNo) {
                    if (!is_null($mobileNo) && $mobileNo !== '') {
                        MobileNumber::create([
                            'address_id' => $createdAddress->address_id,
                            'mobile_no' => $mobileNo,
                        ]);
                    }
                }

                if ($index === 0) {
                    $primaryAddressId = $createdAddress->address_id;
                }
            }
        }

        if ($primaryAddressId) {
            $customer->update(['primary_address_id' => $primaryAddressId]);
        }

        session()->flash('message', 'Customer added successfully.');
        return redirect()->route('customers.index');
    }

    public function addAddress()
    {
        $this->addresses[] = [
            'customer_type_id' => '',
            'contact_person' => '',
            'mobile_no' => [''], // Initialize with one empty mobile number
            'phone_no' => '',
            'email' => '',
        ];
    }

    public function addMobileNumber($index)
    {
        $this->addresses[$index]['mobile_no'][] = ''; // Add a new empty mobile number field
    }

    public function removeMobileNumber($addressIndex, $mobileIndex)
    {
        unset($this->addresses[$addressIndex]['mobile_no'][$mobileIndex]);
        $this->addresses[$addressIndex]['mobile_no'] = array_values($this->addresses[$addressIndex]['mobile_no']);
    }

    public function removeAddress($index)
    {
        unset($this->addresses[$index]);
        $this->addresses = array_values($this->addresses);
    }

    public function mount()
    {
        $this->products = Product::all();
        $this->locations = Location::all();
        $this->licences = Licence::all();
        $this->users = User::all();
        $this->addressTypes = CustomerType::orderBy('name', 'asc')->get();
        $this->addAddress();
    }

    public function render()
    {
        return view('livewire.add-customer');
    }
}
