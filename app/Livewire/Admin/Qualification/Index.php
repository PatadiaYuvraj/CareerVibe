<?php

namespace App\Livewire\Admin\Qualification;

use App\Models\Qualification;
use Livewire\Component;

class Index extends Component
{
    public bool $updateMode = false;
    public $qualificationId;
    public $name;
    public $qualifications;
    public $search;

    // rules
    protected $rules = [
        'name' => [
            'required',
            'string',
            'max:255',
            'unique:qualifications,name',
        ],
    ];

    // listeners
    protected $listeners = [];

    // messages
    protected $messages = [
        'name.required' => 'The qualification name cannot be empty.',
        'name.string' => 'The qualification name must be a string.',
        'name.max' => 'The qualification name cannot be more than 255 characters.',
        'name.unique' => 'The qualification name has already been taken.',
    ];

    public function mount()
    {
        $this->qualifications = Qualification::withCount('jobs')->get();
    }
    public function render(Qualification $qualification)
    {

        return view('livewire.admin.qualification.index');
    }

    public function store()
    {
        $this->validate();
        $data = [
            "name" => $this->name,
        ];
        $isCreated = Qualification::create($data);
        if ($isCreated) {
            $this->reset();
            $this->mount();
            session()->flash('success', 'Qualification is created');
        } else {
            session()->flash('warning', 'Qualification is not created');
        }
    }

    public function edit($id)
    {
        $qualification = Qualification::where('id', $id)->first();
        if (!$qualification) {
            session()->flash('warning', 'Qualification is not found');
        }
        $this->qualificationId = $qualification->id;
        $this->name = $qualification->name;
        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $data = [
            "name" => $this->name,
        ];
        $isUpdated = Qualification::where('id', $this->qualificationId)->update($data);
        if ($isUpdated) {
            $this->reset();
            $this->mount();
            session()->flash('success', 'Qualification is updated');
        } else {
            session()->flash('warning', 'Qualification is not updated');
        }
    }

    public function delete($id)
    {
        $qualification = Qualification::where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$qualification) {
            session()->flash('warning', 'Qualification is not found');
        }
        $qualification =  $qualification[0];
        if ($qualification['jobs_count'] == 0) {
            $isDeleted = Qualification::where('id', $id)->delete();
            if ($isDeleted) {
                $this->mount();
                session()->flash('success', 'Qualification is deleted');
            } else {
                session()->flash('warning', 'Qualification is not deleted');
            }
        } else {
            session()->flash('warning', 'Qualification is not deleted, because it has jobs associated with it');
        }
    }

    // search
    /*
    <div class="input-group mb-3 col">
        <input type="text" class="form-control" placeholder="Search" wire:model="search">
        <button class="btn btn-primary" type="button" wire:click="searchQualification">
            <i class="bi bi-search"></i>
        </button>
    </div>
    */



    public function searchQualification()
    {
        $this->qualifications = Qualification::where('name', 'like', '%' . $this->search . '%')->withCount('jobs')->get();
    }
}
