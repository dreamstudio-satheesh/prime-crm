<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Addresstype;

class AddresstypeMaster extends Component
{
    use WithPagination;

    public $product_id;
    public $name, $description;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
     
        'name' => 'required|string|max:255',
        'description' => 'nullable|string', 
    ];

    public function render()
    {
        $addresstype = Addresstype::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.addresstype-master', compact('addresstype'));
    }

    public function resetInputFields()
    {
        $this->addresstype_id = null;
        $this->name = '';
        $this->description = '';     
        
    }

    public function store()
    {
        $this->validate();

        Product::updateOrCreate(['id' => $this->addresstype_id], [
            'name' => $this->name,
            'description' => $this->description,            
             
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Address Type '.($this->addresstype_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
     
    }

    public function delete($id)
    {
      //  Addresstype::findOrFail($id)->delete();
        session()->flash('success', 'Address Type Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}