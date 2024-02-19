<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileCategory;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ProfileCategoryController extends Controller
{
    private ProfileCategory $profileCategory;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        ProfileCategory $profileCategory,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->profileCategory = $profileCategory;
        $this->paginate = Config::get('constants.pagination');
        $this->navigationManagerService = $navigationManagerService;
    }


    public function create()
    {
        return $this->navigationManagerService->loadView('admin.profile-category.create');
    }

    public function store1(Request $request)
    {
        $request->validate([
            'profile_categories.*.name' => 'required|unique:profile_categories,name',  // Ensure unique names across all items
        ]);
        $data = collect($request->get('profile_categories'))->map(function ($item) {
            return ['name' => $item['name']];
        })->toArray();
        $isCreated = $this->profileCategory->insert($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('admin.profile-category.index', [], 302, [], false, ['success' => 'Profile Category is created']);
        } else {
            return $this->navigationManagerService->redirectBack(302, [], false, ['warning' => 'Profile Category could not be created']);
        }
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'name.*' => 'required|unique:profile_categories,name',
        ]);


        $data = collect($request->get('name'))->map(function ($item) {
            return ['name' => $item];
        })->toArray();

        $isCreated = $this->profileCategory->insert($data);

        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('admin.profile-category.index', [], 302, [], false, ['success' => 'Profile Category is created']);
        } else {
            return $this->navigationManagerService->redirectBack(302, [], false, ['warning' => 'Profile Category could not be created']);
        }
    }

    public function index()
    {
        $profileCategories = $this->profileCategory->withCount('subProfiles', 'jobs')->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.profile-category.index', compact('profileCategories'));
    }

    public function show($id)
    {
        $profileCategory = $this->profileCategory
            ->select(['id', 'name', 'created_at'])
            ->where('id', $id)
            ->with(['subProfiles' => function ($query) {
                $query->select(['id', 'name', 'profile_category_id']);
                $query->withCount(['jobs']);
            }])
            ->get()
            ->ToArray();
        if (!$profileCategory) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not found"]);
        }
        $profileCategory =  $profileCategory[0];
        return $this->navigationManagerService->loadView('admin.profile-category.show', compact('profileCategory'));
    }

    public function edit($id)
    {
        $profileCategory = $this->profileCategory->where('id', $id)->get()->ToArray();
        if (!$profileCategory) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not found"]);
        }
        $profileCategory =  $profileCategory[0];
        return $this->navigationManagerService->loadView('admin.profile-category.edit', compact('profileCategory'));
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
            return $this->navigationManagerService->redirectRoute('admin.profile-category.index', [], 302, [], false, ["success" => "Profile Category is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not updated"]);
    }

    public function destroy($id)
    {
        $profileCategory = $this->profileCategory->find($id)->withCount('subProfiles')->first();
        if (!$profileCategory) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not found"]);
            session()->flash('warning', 'Profile Category is not found');
            return response()->json(['warning' => 'Profile Category is not found'], 200);
        }
        if ($profileCategory['sub_profiles_count'] > 0) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not deleted because it has sub profiles"]);
            session()->flash('warning', 'Profile Category is not deleted because it has sub profiles');
            return response()->json(['warning' => 'Profile Category is not deleted because it has sub profiles'], 200);
        }
        $isDeleted = $this->profileCategory->where('id', $id)->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('admin.profile-category.index', [], 302, [], false, ["success" => "Profile Category is deleted"]);
            session()->flash('success', 'Profile Category is deleted');
            return response()->json(['success' => 'Profile Category is deleted'], 200);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not deleted"]);
        session()->flash('warning', 'Profile Category is not deleted');
        return response()->json(['warning' => 'Profile Category is not deleted'], 200);
    }

    public function livewire()
    {
        return $this->navigationManagerService->loadView('admin.profile-category.index-livewire');
    }
}
