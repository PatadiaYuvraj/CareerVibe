<?php

namespace App\Livewire\Admin\User;

use App\Jobs\UploadToCloudinary;
use App\Models\User;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    public bool $updateMode = false;
    public $users;
    public $id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $profile_image_url;
    public $resume_pdf_url;
    public $search;
    public $perPage;
    public $page = 1;
    public $minRows = 0;
    public $maxRows = 5;
    public $items = [
        [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ],
    ];

    public function __construct()
    {
        $this->perPage = Config::get('constants.pagination');
    }


    public function addRow()
    {
        if (count($this->items) < $this->maxRows) {
            $this->validate();
            $this->items[] = [
                'name' => '',
                'email' => '',
                'password' => '',
                'password_confirmation' => '',
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

    public function allItems()
    {
        dd($this->items);
    }

    // mount
    public function mount()
    {
        $this->users = $this->toArray(User::withCount([
            'appliedJobs',
            'savedJobs',
            'followers',
            'following',
            'followingCompanies',
        ])->paginate($this->perPage));
    }

    public function render()
    {
        return view('livewire.admin.user.index');
    }

    // rules
    public function rules()
    {
        return [
            'items.*.name' => [
                'required',
                'string',
                'max:20',
            ],
            'items.*.email' => [
                'required',
                'email',
                'unique:users,email',
                'max:100',
            ],
            'items.*.password' => [
                'required',
                'min:8',
                'max:20',
            ],
            'items.*.password_confirmation' => [
                'required',
                'same:items.*.password',
                'max:20'
            ],
        ];
    }

    // messages
    public function messages()
    {
        return [
            'items.*.name.required' => 'Name is required.',
            'items.*.name.string' => 'Name must be a string.',
            'items.*.name.max' => 'Name may not be greater than 20 characters.',
            'items.*.email.required' => 'Email is required.',
            'items.*.email.email' => 'Email must be a valid email address.',
            'items.*.email.unique' => 'Email has already been taken.',
            'items.*.email.max' => 'Email may not be greater than 100 characters.',
            'items.*.password.required' => 'Password is required.',
            'items.*.password.min' => 'Password must be at least 8 characters.',
            'items.*.password.max' => 'Password may not be greater than 20 characters.',
            'items.*.password_confirmation.required' => 'Password confirmation is required.',
            'items.*.password_confirmation.same' => 'Password confirmation must match password.',
            'items.*.password_confirmation.max' => 'Password confirmation may not be greater than 20 characters.',
        ];
    }

    public function store()
    {
        $this->validate();
        User::insert(
            collect($this->items)->map(function ($item) {
                return [
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'password' => Hash::make($item['password']),
                ];
            })->toArray()
        );
        session()->flash('message', 'Users added successfully.');
        $this->reset();
        $this->mount();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->updateMode = true;
    }

    public function update(Request $request)
    {
        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:20',
            ],
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:users,email,' . $this->id . ',id',
            ],
            'profile_image_url' => [
                'nullable',
                'mimes:jpg,jpeg,png,gif',
                'max:2048',
            ],
            'resume_pdf_url' => [
                'nullable',
                'mimes:pdf',
                'max:2048',
            ],
        ]);


        $data = [
            "name" => $this->name,
            "email" => $this->email,
        ];

        $user = User::findOrFail($this->id);

        if ($this->profile_image_url) {
            $storageManagerService = new StorageManagerService;
            if ($user->profile_image_url) {
                $public_ids = $user->profile_image_public_id;
                $storageManagerService->deleteFromCloudinary($public_ids);
            }

            if (Config::get('constants.IS_FILE_UPLOAD_SERVICE_ENABLED')) {
                $originalFilename = $this->profile_image_url->getClientOriginalName();
                $storedPath = $this->profile_image_url->storeAs("temp", $originalFilename);
                $user_data = [
                    "stored_path" => $storedPath,
                    "user_type" => "USER",
                    "user_id" => $user->id,
                ];
                UploadToCloudinary::dispatch($user_data);
            }
            $data = [
                "profile_image_public_id" => null,
                "profile_image_url" => null,
            ];
            unset($storageManagerService);
        }
        if ($this->resume_pdf_url) {
            $storageManagerService = new StorageManagerService;
            if ($user->resume_pdf_url) {
                $storageManagerService->deleteFromLocal($user->resume_pdf_url);
            }
            $stored_path = $this->resume_pdf_url->store(Config::get('constants.USER_RESUME_PATH'));
            Log::info('stored_path: ' . $stored_path);
            $data = [
                "resume_pdf_url" => $stored_path,
            ];
            unset($storageManagerService);
        }
        $user->update($data);
        $this->updateMode = false;
        session()->flash('message', 'User updated successfully.');
        $this->reset();
        $this->mount();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $storageManagerService = new StorageManagerService;
            $storageManagerService->deleteFromCloudinary($public_ids);
            $user->update([
                "profile_image_public_id" => null,
                "profile_image_url" => null,
            ]);
            unset($storageManagerService);
        }
        if ($user->resume_pdf_url) {
            $storageManagerService = new StorageManagerService;
            $storageManagerService->deleteFromLocal($user->resume_pdf_url);
            unset($storageManagerService);
        }
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
        $this->mount();
    }

    // deleteResume
    public function deleteResume($id)
    {
        $user = User::findOrFail($id);
        if ($user->resume_pdf_url) {
            $storageManagerService = new StorageManagerService;
            $storageManagerService->deleteFromLocal($user->resume_pdf_url);
            $user->update([
                "resume_pdf_url" => null,
            ]);
            session()->flash('message', 'Resume deleted successfully.');
            $this->mount();
            unset($storageManagerService);
        }
    }

    // deleteProfileImage
    public function deleteProfileImage($id)
    {
        $user = User::findOrFail($id);
        if ($user->profile_image_url) {
            $public_ids = $user->profile_image_public_id;
            $storageManagerService = new StorageManagerService;
            $storageManagerService->deleteFromCloudinary($public_ids);
            $user->update([
                "profile_image_public_id" => null,
                "profile_image_url" => null,
            ]);
            session()->flash('message', 'Profile image deleted successfully.');
            $this->mount();
            unset($storageManagerService);
        }
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->reset();
        $this->resetErrorBag();
        $this->mount();
    }


    public function searching()
    {
        $this->search = "Search is not implemented yet";
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

    public function toArray($array): array
    {
        return json_decode(json_encode($array), true);
    }
}
