<?php

namespace App\Livewire\Admin\Qualification;

use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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
    public $perPage;
    public $page = 1;
    public $minRows = 1;
    public $maxRows = 9;
    public $items = [
        ['name' => ''],
    ];
    public $key = 0;

    public function __construct()
    {
        $this->perPage = Config::get('constants.pagination');
    }

    public function addRow()
    {
        if (count($this->items) < $this->maxRows) {
            $this->key++;
            $this->items[] = [
                'name' => '',
                // Add other fields as needed
            ];
        } else {
            session()->flash('message', 'Maximum number of items reached.');
        }
    }

    public function removeRow($index)
    {
        if (count($this->items) > $this->minRows) {
            unset($this->items[$index]);
        } else {
            session()->flash('message', 'Minimum number of items required.');
        }
    }

    public function mount()
    {
        $currentPage = $this->page;
        if (empty($this->items)) {
            $this->items[] = [
                'name' => '',
                // Add other fields as needed
            ];
        }

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

    public function rules()
    {
        return
            [
                'items.*.name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:qualifications,name',
                ],
            ];
    }

    public function messages()
    {
        return [
            'items.*.name.required' => 'The qualification name is required',
            'items.*.name.string' => 'The qualification name must be a string',
            'items.*.name.max' => 'The qualification name must not be greater than 255 characters',
            'items.*.name.unique' => 'The qualification name is already taken',
        ];
    }

    public function store(Request $request)
    {
        $this->validate();
        try {
            $isCreated = Qualification::insert($this->items);

            if ($isCreated) {
                $this->reset();
                $this->mount();
                session()->flash('success', 'Qualification is created');
                return;
            } else {
                session()->flash('warning', 'Qualification is not created');
                return;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $this->resetErrorBag();
        $qualification = Qualification::where('id', $id)->first();
        if (!$qualification) {
            session()->flash('warning', 'Qualification is not found');
            return;
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
        $this->validate([
            'name' => 'required|string|max:255',
        ]);
        $data = [
            "name" => $this->name,
        ];
        $isUpdated = Qualification::where('id', $this->qualificationId)->update($data);
        if ($isUpdated) {
            $this->reset();
            $this->mount();
            session()->flash('success', 'Qualification is updated');
            return;
        } else {
            session()->flash('warning', 'Qualification is not updated');
            return;
        }
    }

    public function delete($id)
    {
        $qualification = Qualification::where('id', $id)->withCount('jobs')->first();
        if (!$qualification) {
            session()->flash('warning', 'Qualification is not found');
            return;
        }
        if ($qualification['jobs_count'] == 0) {
            $isDeleted = Qualification::where('id', $id)->delete();
            if ($isDeleted) {
                $this->mount();
                session()->flash('success', 'Qualification is deleted');
                return;
            } else {
                session()->flash('warning', 'Qualification is not deleted');
                return;
            }
        } else {
            session()->flash('warning', 'Qualification is not deleted, because it has jobs associated with it');
            return;
        }
    }

    public function searchQualification()
    {
        $this->resetPage();
        $this->qualifications = Qualification::where('name', 'like', '%' . $this->search . '%')->withCount('jobs')->paginate(
            $this->perPage,
            ['*'],
            'page',
            $this->page
        )->ToArray();
    }

    public function resetPage()
    {
        $this->page = 1;
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
