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
    public array $city;
    public $state;
    public $country;
    public $pincode;
    public $locationId;
    public $search;
    public $perPage;
    public $page = 1;

    // rules
    protected $rules = [
        'city' => [
            'required',
            'string',
            'max:255',
            'unique:locations,city',
        ],
    ];

    // listeners
    protected $listeners = [];

    // messages
    protected $messages = [
        'city.required' => 'The city name cannot be empty.',
        'city.string' => 'The city name must be a string.',
        'city.max' => 'The city name cannot be more than 255 characters.',
        'city.unique' => 'The city name has already been taken.',
        'state.required' => 'The state name cannot be empty.',
        'state.string' => 'The state name must be a string.',
        'state.max' => 'The state name cannot be more than 255 characters.',
        'country.required' => 'The country name cannot be empty.',
        'country.string' => 'The country name must be a string.',
        'country.max' => 'The country name cannot be more than 255 characters.',
        'pincode.required' => 'The pincode cannot be empty.',
        'pincode.string' => 'The pincode must be a string.',
        'pincode.max' => 'The pincode cannot be more than 255 characters.',
    ];

    public function __construct()
    {
        $this->perPage = Config::get('constants.pagination');
    }

    public function mount()
    {
        $currentPage = $this->page;
        $this->locations = Location::withCount('jobs')->paginate($this->perPage, ['*'], 'page', $currentPage)->ToArray();
    }

    public function render()
    {
        return view('livewire.admin.location.index');
    }

    public function store(Request $request)
    {
        dd($request->all());
        $this->validate();
        $data = [
            "city" => $this->city,
            "state" => null,
            "country" => null,
            "pincode" => null,
        ];

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

        $isCreated = Location::create($data);

        if ($isCreated) {
            $this->reset();
            $this->mount();
            session()->flash('success', 'Location is created');
            return;
        } else {
            session()->flash('warning', 'Location is not created');
            return;
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
