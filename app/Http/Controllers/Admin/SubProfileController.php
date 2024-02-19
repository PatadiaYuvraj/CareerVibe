<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileCategory;
use App\Models\SubProfile;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SubProfileController extends Controller
{
    private SubProfile $subProfile;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        SubProfile $subProfile,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->subProfile = $subProfile;
        $this->paginate = Config::get('constants.pagination');
        $this->navigationManagerService = $navigationManagerService;
    }

    public function create()
    {
        $profileCategories = ProfileCategory::all();
        return $this->navigationManagerService->loadView('admin.sub-profile.create', compact('profileCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:sub_profiles,name',
            ],
            'profile_category_id' => [
                'required',
                'integer',
                'exists:profile_categories,id',
                function ($attribute, $value, $fail) {
                    $profileCategory = ProfileCategory::where('id', $value)->first();
                    if (!$profileCategory) {
                        return $fail('The ' . $attribute . ' is invalid.');
                    }
                },

            ],
        ]);
        $data = [
            'name' => $request->name,
            'profile_category_id' => $request->profile_category_id,
        ];

        $isCreated = $this->subProfile->create($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('admin.sub-profile.index', [], 302, [], false, ["success" => "Sub Profile created successfully"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["error" => "Sub Profile creation failed"]);
    }

    public function index()
    {
        $subProfiles = $this->subProfile->withCount('jobs')->with('profileCategory')->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.sub-profile.index', compact('subProfiles'));
    }

    public function show($id)
    {
        $subProfile = $this->subProfile
            ->where('id', $id)
            ->with(
                [
                    'profileCategory' => function ($query) {
                        $query->select(['profile_categories.id', 'name', 'created_at']);
                    },
                    'jobs' => function ($query) {
                        $query->select([
                            'jobs.id',
                            'company_id',
                            'sub_profile_id',
                            'vacancy',
                            'min_salary',
                            'max_salary',
                            'work_type',
                            'job_type',
                            'experience_level',
                            'is_active',
                            'is_verified',
                            'is_featured',
                            'created_at'
                        ]);
                        $query->with([
                            'company' => function ($query) {
                                $query->select([
                                    'companies.id',
                                    'name',
                                ]);
                            }
                        ]);
                    }
                ]
            )
            ->get()
            ->ToArray();
        if (!$subProfile) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Sub Profile is not found"]);
        }
        $subProfile =  $subProfile[0];
        return $this->navigationManagerService->loadView('admin.sub-profile.show', compact('subProfile'));
    }

    public function edit($id)
    {
        $subProfile = $this->subProfile->where('id', $id)->with('profileCategory')->get()->ToArray();
        if (!$subProfile) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Sub Profile is not found"]);
        }
        $subProfile =  $subProfile[0];
        $profileCategories = ProfileCategory::all();
        return $this->navigationManagerService->loadView('admin.sub-profile.edit', compact('subProfile', 'profileCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:sub_profiles,name,' . $id,
            ],
            'profile_category_id' => [
                'required',
                'integer',
                'exists:profile_categories,id',
            ],
        ]);
        $data = [
            'name' => $request->name,
            'profile_category_id' => $request->profile_category_id,
        ];

        $isUpdated = $this->subProfile->where('id', $id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.sub-profile.index', [], 302, [], false, ["success" => "Sub Profile is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Sub Profile is not updated"]);
    }

    public function destroy($id)
    {
        $subProfile = $this->subProfile->where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$subProfile) {
            // return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Sub Profile is not found"]);
            session()->flash('warning', 'Sub Profile is not found');
            return;
        }
        $subProfile =  $subProfile[0];
        if ($subProfile['jobs_count'] == 0) {
            $isDeleted = $this->subProfile->where('id', $id)->delete();
            if ($isDeleted) {
                // return $this->navigationManagerService->redirectRoute('admin.sub-profile.index', [], 302, [], false, ["success" => "Sub Profile is deleted"]);
                session()->flash('success', 'Sub Profile is deleted');
                return;
            }
            // return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Sub Profile is not deleted"]);
            session()->flash('warning', 'Sub Profile is not deleted');
            return;
        }
        // return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Sub Profile is not deleted, because it has jobs associated with it"]);
        session()->flash('warning', 'Sub Profile is not deleted, because it has jobs associated with it');
        return;
    }

    // livewire
    public function livewire()
    {
        return  $this->navigationManagerService->loadView('admin.sub-profile.index-livewire');
    }
}
