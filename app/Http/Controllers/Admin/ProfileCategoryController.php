<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileCategory;
use Illuminate\Http\Request;

class ProfileCategoryController extends Controller
{
    private ProfileCategory $profileCategory;

    public function __construct(ProfileCategory $profileCategory)
    {
        $this->profileCategory = $profileCategory;
    }

    public function create()
    {
        return view('admin.profile-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:profile_categories,name',

            ],
        ]);
        $data = [
            'name' => $request->name,
        ];
        $isCreated = $this->profileCategory->create($data);
        if ($isCreated) {
            return redirect()->route('admin.profile-category.index')->with('success', 'Profile Category created successfully');
        }
        return redirect()->back()->with('error', 'Profile Category creation failed');
    }

    public function index()
    {
        $profileCategories = $this->profileCategory->withCount('subProfiles', 'jobs')->paginate(5);
        return view('admin.profile-category.index', compact('profileCategories'));
    }

    public function show($id)
    {

        // profile category with sub profiles and jobs
        $profileCategory = $this->profileCategory
            ->where('id', $id)
            ->with([
                'subProfiles' => function ($query) {
                    $query->withCount('jobs');
                }
            ])
            ->get()
            ->ToArray();
        if (!$profileCategory) {
            return redirect()->back()->with("warning", "Profile Category is not found");
        }
        $profileCategory =  $profileCategory[0];
        return view('admin.profile-category.show', compact('profileCategory'));
    }

    public function edit($id)
    {
        $profileCategory = $this->profileCategory->where('id', $id)->get()->ToArray();
        if (!$profileCategory) {
            return redirect()->back()->with("warning", "Profile Category is not found");
        }
        $profileCategory =  $profileCategory[0];
        return view('admin.profile-category.edit', compact('profileCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:50',
                'unique:profile_categories,name,' . $id,
            ],
        ]);
        $data = [
            'name' => $request->name,
        ];

        $isUpdated = $this->profileCategory->where('id', $id)->update($data);
        if ($isUpdated) {
            return redirect()->route('admin.profile-category.index')->with('success', 'Profile Category updated successfully');
        }
        return redirect()->back()->with('error', 'Profile Category updation failed');
    }

    public function delete($id)
    {
        $profileCategory = $this->profileCategory->where('id', $id)->withCount('subProfiles')->get()->ToArray();
        if (!$profileCategory) {
            return redirect()->back()->with("warning", "Profile Category is not found");
        }
        $profileCategory =  $profileCategory[0];
        if ($profileCategory->sub_profiles_count > 0) {
            return redirect()->back()->with("warning", "Profile Category is not deleted because it has sub profiles");
        }
        $isDeleted = $this->profileCategory->where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.profile-category.index')->with('success', 'Profile Category deleted successfully');
        }
        return redirect()->back()->with('error', 'Profile Category deletion failed');
    }
}
