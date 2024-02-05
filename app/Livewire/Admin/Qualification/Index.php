<?php

namespace App\Livewire\Admin\Qualification;

use App\Models\Qualification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $updateMode = false;
    public $qualificationId;
    public $name;
    public $qualifications;
    public $search;
    public $perPage = 2;
    public $page = 1;
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
        $currentPage = $this->page;

        $this->qualifications = Qualification::withCount('jobs')->paginate(
            $this->perPage,
            ['*'],
            'page',
            $currentPage
        )->ToArray();
    }
    public function render()
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
        $this->name = '';
        $this->qualificationId = '';
        $this->updateMode = false;
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

    public function searchQualification()
    {
        // $this->qualifications = Qualification::where('name', 'like', '%' . $this->search . '%')->withCount('jobs')->get();
        $this->qualifications = json_decode(json_encode(Qualification::where('name', 'like', '%' . $this->search . '%')->withCount('jobs')->paginate(
            $this->perPage,
            ['*'],
            'page',
            $this->page
        )), true);
    }

    public function prevPage()
    {
        if ($this->page > 1) {
            $this->page--;
        }
        // mount
        $this->mount();
    }

    public function nextPage()
    {
        $total_pages =  $this->qualifications['last_page'];
        if ($this->page < $total_pages) {
            $this->page++;
        }
        // mount
        $this->mount();
    }

    public function gotoPage($page)
    {
        $this->page = $page;

        $this->mount();
    }
}
