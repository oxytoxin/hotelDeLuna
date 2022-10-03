<?php

namespace App\Http\Livewire\BranchAdmin;

use App\Models\HotelItem;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;
class StainAndDamages extends Component
{
    use WithPagination, Actions;

    public $filter = ['search' => ''];

    public $modal = [
        'show' => false,
        'mode' => 'create',
    ];

    public $form = [
        'name'=>'',
        'price'=>'',
    ];

    public $hotel_item=null;

    public function getModalTitle()
    {
        return $this->modal['mode'] == 'create' ? 'Create Stain And Damage' : 'Edit Stain And Damage';
    }

    public function add()
    {
        $this->reset('form');
        $this->modal['mode'] = 'create';
        $this->modal['show'] = true;
    }

    public function create()
    {
        $this->validate([
            'form.name' => 'required|unique:hotel_items,name',
            'form.price' => 'required|numeric',
        ]);

        HotelItem::create([
            'branch_id' => auth()->user()->branch->id,
            'name' => $this->form['name'],
            'price' => $this->form['price'],
        ]);

        $this->notification()->success(
            $title = 'Success!',
            $message = 'Record has been created.'
        );
        $this->modal['show'] = false;
        $this->reset('form');
    }

    public function edit($hotel_item_id)
    {
        $this->modal['mode'] = 'edit';
        $this->hotel_item = HotelItem::find($hotel_item_id);
        $this->form['name'] = $this->hotel_item->name;
        $this->form['price'] = $this->hotel_item->price;
        $this->modal['show'] = true;
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|unique:hotel_items,name,'.$this->hotel_item->id,
            'form.price' => 'required|numeric',
        ]);

        $this->hotel_item->update([
            'name' => $this->form['name'],
            'price' => $this->form['price'],
        ]);

        $this->notification()->success(
            $title = 'Success!',
            $message = 'Record has been updated.'
        );
        $this->modal['show'] = false;
        $this->reset('form');
    }
    public function render()
    {
        return view('livewire.branch-admin.stain-and-damages',[
            'hotel_items'=>HotelItem::where('branch_id',auth()->user()->branch->id)
                            ->when($this->filter['search']!='', function ($query) {
                                return $query->where('name', 'like', '%'.$this->filter['search'].'%');
                            })
                            ->paginate(10),
        ]);
    }
}
