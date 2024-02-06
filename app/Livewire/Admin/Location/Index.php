<?php

namespace App\Livewire\Admin\Location;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public bool $updateMode = false;
    public $locations;
    public $city;
    public $state;
    public $country;
    public $pincode;
    public $locationId;
    public $search;
    public $perPage;
    public $page = 1;
    public $minRows = 1;
    public $maxRows = 9;
    public $items = [
        ['city' => null, 'state' => null, 'country' => null, 'pincode' => null,],
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
                'city' => null,
                'state' => null,
                'country' => null,
                'pincode' => null,
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
                'city' => null,
                'state' => null,
                'country' => null,
                'pincode' => null,
            ];
        }
        $this->locations = Location::withCount('jobs')->paginate($this->perPage, ['*'], 'page', $currentPage)->ToArray();
    }

    public function rules()
    {
        return [
            'items.*.city' => ['required', 'string', 'max:255'],
            'items.*.state' => ['nullable', 'string', 'max:255'],
            'items.*.country' => ['nullable', 'string', 'max:255'],
            'items.*.pincode' => ['nullable', 'string', 'max:10'],
        ];
    }

    public function messages()
    {
        return [
            'items.*.city.required' => 'The city is required',
            'items.*.city.string' => 'The city must be a string',
            'items.*.city.max' => 'The city must not be greater than 255 characters',
            'items.*.city.unique' => 'The city has already been taken',
            'items.*.state.string' => 'The state, if provided, must be a string',
            'items.*.country.string' => 'The country, if provided, must be a string',
            'items.*.pincode.string' => 'The pincode, if provided, must be a string',
        ];
    }


    public function render()
    {
        return view('livewire.admin.location.index');
    }

    public function store()
    {
        $this->validate();

        $data = [];
        foreach ($this->items as $item) {
            if ($item['city'] != null) {
                $data[] = [
                    'city' => $item['city'] ?? null,
                    'state' => $item['state'] ?? null,
                    'country' => $item['country'] ?? null,
                    'pincode' => $item['pincode'] ?? null,
                ];
            }
        }

        // dd($data);

        try {
            $isCreated = Location::insert($data);
            if ($isCreated) {
                $this->reset();
                $this->mount();
                session()->flash('success', 'Locations have been created');
                return;
            } else {
                session()->flash('warning', 'Locations could not be created');
                return;
            }
        } catch (\Throwable $th) {
            throw $th; // Re-throw to allow Laravel's exception handling to take over
        }
    }


    public function edit($id)
    {
        $location = Location::where('id', $id)->first();
        if (!$location) {
            session()->flash('warning', 'Location is not found');
            return;
        }
        $this->locationId = $location->id;
        $this->city = $location->city;
        $this->state = $location->state;
        $this->country = $location->country;
        $this->pincode = $location->pincode;
        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->city = '';
        $this->state = '';
        $this->country = '';
        $this->pincode = '';
        $this->locationId = '';
        $this->updateMode = false;
    }

    public function update(Request $request)
    {
        // $this->validate();

        if (isset($request->all()['components'][0]['updates']['city'])) {
            $this->validate([
                'city' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:locations,city,' . $this->locationId,
                ],
            ]);
            $data['city'] = $this->city;
        }

        if (isset($request->all()['components'][0]['updates']['state'])) {
            $this->validate([
                'state' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ]);
            $data['state'] = $this->state;
        }

        if (isset($request->all()['components'][0]['updates']['country'])) {
            $this->validate([
                'country' => [
                    'required',
                    'string',
                    'max:255',
                ],
            ]);
            $data['country'] = $this->country;
        }

        if (isset($request->all()['components'][0]['updates']['pincode'])) {
            $this->validate([
                'pincode' => [
                    'required',
                    'numeric',
                    'digits:6',
                ],
            ]);
            $data['pincode'] = $this->pincode;
        }

        $isUpdated = Location::where('id', $this->locationId)->update($data);
        if ($isUpdated) {
            $this->reset();
            $this->mount();
            session()->flash('success', 'Location is updated');
            return;
        } else {
            session()->flash('warning', 'Location is not updated');
            return;
        }
    }

    public function delete($id)
    {
        $location = Location::where('id', $id)->withCount('jobs')->first();
        if (!$location) {
            session()->flash('warning', 'Location is not found');
            return;
        }

        if ($location['jobs_count'] == 0) {
            $isDeleted = Location::where('id', $id)->delete();
            if ($isDeleted) {
                $this->reset();
                $this->mount();
                session()->flash('success', 'Location is deleted');
                return;
            } else {
                session()->flash('warning', 'Location is not deleted');
                return;
            }
        } else {
            session()->flash('warning', 'Location is not deleted because it has jobs');
            return;
        }
    }

    public function searchLocation()
    {
        $this->resetPage();
        $this->locations = Location::where('city', 'like', '%' . $this->search . '%')
            ->orWhere('state', 'like', '%' . $this->search . '%')
            ->orWhere('country', 'like', '%' . $this->search . '%')
            ->orWhere('pincode', 'like', '%' . $this->search . '%')
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
        $total_pages =  $this->locations['last_page'];
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
