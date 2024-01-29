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
            return $this->navigationManagerService->redirectRoute('admin.profile-category.index', [], 302, [], false, ["success" => "Profile Category is created"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not created"]);
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

    public function delete($id)
    {
        $profileCategory = $this->profileCategory->find($id)->withCount('subProfiles')->first();
        if (!$profileCategory) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not found"]);
        }
        if ($profileCategory['sub_profiles_count'] > 0) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not deleted because it has sub profiles"]);
        }
        $isDeleted = $this->profileCategory->where('id', $id)->delete();
        if ($isDeleted) {
            return $this->navigationManagerService->redirectRoute('admin.profile-category.index', [], 302, [], false, ["success" => "Profile Category is deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Profile Category is not deleted"]);
    }
}
