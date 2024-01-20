<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileCategory;
use App\Models\SubProfile;
use Illuminate\Http\Request;

class SubProfileController extends Controller
{
    private SubProfile $subProfile;
    private int $paginate;

    public function __construct(SubProfile $subProfile)
    {
        $this->subProfile = $subProfile;
        $this->paginate = env('PAGINATEVALUE');
    }

    public function create()
    {
        $profileCategories = ProfileCategory::all();
        return view('admin.sub-profile.create', compact('profileCategories'));
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
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                },

            ],
        ]);
        $data = [
            'name' => $request->name,
            'profile_category_id' => $request->profile_category_id,
        ];
        // dd($data);
        $isCreated = $this->subProfile->create($data);
        if ($isCreated) {
            return redirect()->route('admin.sub-profile.index')->with('success', 'Sub Profile created successfully');
        }
        return redirect()->back()->with('error', 'Sub Profile creation failed');
    }

    public function index()
    {
        // dd($this->paginate);
        $subProfiles = $this->subProfile->withCount('jobs')->with('profileCategory')->paginate($this->paginate);
        return view('admin.sub-profile.index', compact('subProfiles'));
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
            return redirect()->back()->with("warning", "Sub Profile is not found");
        }
        $subProfile =  $subProfile[0];
        return view('admin.sub-profile.show', compact('subProfile'));
    }

    public function edit($id)
    {
        $subProfile = $this->subProfile->where('id', $id)->with('profileCategory')->get()->ToArray();
        if (!$subProfile) {
            return redirect()->back()->with("warning", "Sub Profile is not found");
        }
        $subProfile =  $subProfile[0];
        $profileCategories = ProfileCategory::all();
        return view('admin.sub-profile.edit', compact('subProfile', 'profileCategories'));
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
            return redirect()->route('admin.sub-profile.index')->with('success', 'Sub Profile is updated');
        }
        return redirect()->back()->with("warning", "Sub Profile is not updated");
    }

    public function delete($id)
    {
        $subProfile = $this->subProfile->where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$subProfile) {
            return redirect()->back()->with("warning", "Sub Profile is not found");
        }
        $subProfile =  $subProfile[0];
        if ($subProfile['jobs_count'] == 0) {
            $isDeleted = $this->subProfile->where('id', $id)->delete();
            if ($isDeleted) {
                return redirect()->route('admin.sub-profile.index')->with('success', 'Sub Profile is deleted');
            }
            return redirect()->back()->with("warning", "Sub Profile is not deleted");
        }
        return redirect()->back()->with("warning", "Sub Profile is not deleted, because it has jobs associated with it");
    }
}
