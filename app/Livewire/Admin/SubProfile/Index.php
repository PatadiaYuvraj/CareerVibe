<?php

namespace App\Livewire\Admin\SubProfile;


use App\Models\SubProfile as ProfileCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $updateMode = false;
    public $profileCategoryId;
    public $name;
    public $profileCategories;
    public $search;
    public $selectedProfileCategories = [];
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


        $this->profileCategories = ProfileCategory::withCount('jobs')->paginate(
            $this->perPage,
            ['*'],
            'page',
            $currentPage
        )->ToArray();
    }
    public function render()
    {
        return view('livewire.admin.sub-profile.index');
    }

    public function rules()
    {
        return
            [
                'items.*.name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:profile_categories,name',
                ],
            ];
    }

    public function messages()
    {
        return [
            'items.*.name.required' => 'Name is required',
            'items.*.name.string' => 'Name must be a string',
            'items.*.name.max' => 'Name must not be greater than 255 characters',
            'items.*.name.unique' => 'Name must be unique',
        ];
    }

    public function store(Request $request)
    {
        dd($request->all());
        $this->validate();
        try {
            $isCreated = ProfileCategory::insert($this->items);

            if ($isCreated) {
                $this->reset();
                $this->mount();
                session()->flash('success', 'ProfileCategory is created');
                return;
            } else {
                session()->flash('warning', 'ProfileCategory is not created');
                return;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $this->resetErrorBag();
        $profileCategory
            = ProfileCategory::where('id', $id)->first();
        if (!$profileCategory) {
            session()->flash('warning', 'ProfileCategory is not found');
            return;
        }
        $this->profileCategoryId = $profileCategory->id;
        $this->name = $profileCategory->name;
        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->name = '';
        $this->profileCategoryId = '';
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
        $isUpdated = ProfileCategory::where(
            'id',
            $this->profileCategoryId
        )->update($data);
        if ($isUpdated) {
            $this->reset();
            $this->mount();
            session()->flash('success', 'ProfileCategory is updated');
            return;
        } else {
            session()->flash('warning', 'ProfileCategory is not updated');
            return;
        }
    }


    public function deleteSelected()
    {
        if (count($this->selectedProfileCategories) > 0) {
            ProfileCategory::whereIn('id', $this->selectedProfileCategories)->delete();

            $this->selectedProfileCategories = [];
            $this->mount();
            session()->flash('success', 'ProfileCategory is deleted');
            return;
        } else {
            session()->flash('warning', 'ProfileCategory is not deleted');
            return;
        }
    }


    public function delete($id)
    {
        $profileCategory = ProfileCategory::where('id', $id)->withCount('jobs')->first();
        if (!$profileCategory) {
            session()->flash('warning', 'ProfileCategory is not found');
            return;
        }
        if ($profileCategory['jobs_count'] == 0) {
            $isDeleted = ProfileCategory::where('id', $id)->delete();
            if ($isDeleted) {
                $this->mount();
                session()->flash('success', 'ProfileCategory is deleted');
                return;
            } else {
                session()->flash('warning', 'ProfileCategory is not deleted');
                return;
            }
        } else {
            session()->flash('warning', 'ProfileCategory is not deleted, because it has jobs associated with it');
            return;
        }
    }

    public function searching()
    {
        $this->resetPage();
        $this->profileCategories = ProfileCategory::where('name', 'like', '%' . $this->search . '%')->withCount('jobs')->paginate(
            $this->perPage,
            ['*'],
            'page',
            $this->page
        )->ToArray();
    }

    public function resetPage()
    {
        $this->setTimeOut(function () {
            $this->page = 1;
        });



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
        $total_pages =  $this->profileCategories['last_page'];
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
