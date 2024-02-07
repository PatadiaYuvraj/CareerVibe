<?php

namespace App\Livewire\Admin\SubProfile;

use App\Models\ProfileCategory;
use App\Models\SubProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public bool $updateMode = false;
    public $subProfileId;
    public $name;
    public $profile_category_id;
    public $subProfiles;
    public $profileCategories;
    public $search;
    public $perPage;
    public $page = 1;
    public $minRows = 1;
    public $maxRows = 9;
    public $items = [
        [
            'name' => '',
            'profile_category_id' => ''
        ],
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
                'profile_category_id' => '',
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
        $this->subProfiles =  $this->toArray(SubProfile::with(['profileCategory'])
            ->withCount('jobs')
            ->paginate($this->perPage, ['*'], 'page', $currentPage));
        $this->profileCategories = ProfileCategory::orderBy('name')->pluck('name', 'id');
    }
    public function render()
    {
        return view('livewire.admin.sub-profile.index');
    }

    public function rules()
    {
        return [
            'items.*.name' => [
                'required',
                'max:255',
                'unique:sub_profiles,name'
            ],
            'items.*.profile_category_id' => [
                'required',
                'exists:profile_categories,id',

            ]
        ];
    }

    public function messages()
    {
        return [
            'items.*.name.required' => 'Name is required',
            'items.*.name.max' => 'Name should not be more than 255 characters',
            'items.*.name.unique' => 'Name already exists',
            'items.*.profile_category_id.required' => 'Profile Category is required',
            'items.*.profile_category_id.exists' => 'Profile Category does not exist',
        ];
    }

    public function store(Request $request)
    {
        $this->validate();

        SubProfile::insert($this->items);
        session()->flash('message', 'Sub Profile created successfully');
        $this->reset();
        // mount
        $this->mount();
    }

    public function edit($id)
    {
        $subProfile = SubProfile::where('id', $id)->first();
        $this->subProfileId = $id;
        $this->name = $subProfile->name;
        $this->profile_category_id = $subProfile->profile_category_id;
        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->name = '';
        $this->profile_category_id = '';
        $this->updateMode = false;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|max:255',
            'profile_category_id' => 'required|exists:profile_categories,id',
        ]);

        if ($this->subProfileId) {
            $subProfile = SubProfile::find($this->subProfileId);
            $subProfile->update([
                'name' => $this->name,
                'profile_category_id' => $this->profile_category_id,
            ]);
            $this->updateMode = false;
            session()->flash('message', 'Sub Profile updated successfully');
            $this->reset();
            // mount
            $this->mount();
        }
    }

    public function delete($id)
    {
        if ($id) {
            SubProfile::where('id', $id)->delete();
            session()->flash('message', 'Sub Profile deleted successfully');
            // mount
            $this->mount();
        }
    }

    // public function searching()
    // {
    //     $this->resetPage();
    //     $this->locations = Location::where('city', 'like', '%' . $this->search . '%')
    //         ->orWhere('state', 'like', '%' . $this->search . '%')
    //         ->orWhere('country', 'like', '%' . $this->search . '%')
    //         ->orWhere('pincode', 'like', '%' . $this->search . '%')
    //         ->withCount('jobs')
    //         ->paginate($this->perPage, ['*'], 'page', $this->page)->ToArray();
    // }


    public function searching()
    {
        $this->subProfiles = SubProfile::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('profile_category_id', 'like', '%' . $this->search . '%')
            ->withCount('jobs')
            ->paginate($this->perPage, ['*'], 'page', $this->page)->ToArray();
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
        $total_pages =  $this->subProfiles['last_page'];
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

    public function toArray($subProfiles): array
    {
        return json_decode(json_encode($subProfiles), true);
    }
}
