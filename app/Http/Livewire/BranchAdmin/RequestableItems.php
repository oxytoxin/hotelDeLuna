<?php

namespace App\Http\Livewire\BranchAdmin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RequestableItem;
use WireUi\Traits\Actions;
class RequestableItems extends Component
{
    use WithPagination, Actions;
    
    public $filter = ['search' => ''];

    public $showModal = false;

    public $form = [
        'name'=>'',
        'price'=>'',
    ];

    public $mode = 'create';

    public $requestable_item = null;

    protected $validationAttributes = [
        'form.name' => 'name',
        'form.price' => 'price',
    ];

    public function getModalTitle()
    {
        return $this->mode == 'create' ? 'Create Amenities' : 'Edit Amenities';
    }

    public function add()
    {
        $this->reset('form');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function edit($requestable_item_id)
    {
        $this->mode = 'edit';
        $this->requestable_item = RequestableItem::find($requestable_item_id);
        $this->form['name'] = $this->requestable_item->name;
        $this->form['price'] = $this->requestable_item->price;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|unique:requestable_items,name,'.$this->requestable_item->id,
            'form.price' => 'required|numeric',
        ]);

        $this->requestable_item->update([
            'name' => $this->form['name'],
            'price' => $this->form['price'],
        ]);

        $this->notification()->success(
            $title = 'Success!',
            $message = 'Requestable Item Updated Successfully!'
        );
        $this->reset('form');
        $this->showModal = false;
    }

    public function create()
    {
        $this->validate([
            'form.name' => 'required|unique:requestable_items,name',
            'form.price' => 'required|numeric',
        ]);

        RequestableItem::create([
            'branch_id' => auth()->user()->branch_id,
            'name' => $this->form['name'],
            'price' => $this->form['price'],
        ]);

        $this->notification()->success(
            $title = 'Success!',
            $message = 'Requestable Item has been created.'
        );
        $this->reset('form');
        $this->showModal = false;
    }


    public function render()
    {
        return view('livewire.branch-admin.requestable-items',[
            'requestable_items' =>RequestableItem::query()
                ->when($this->filter['search']!='', fn($query) => $query->where('name', 'like', '%'.$this->filter['search'].'%'))
                ->where('branch_id', auth()->user()->branch_id)
                ->paginate(10)
        ]);
    }
}
