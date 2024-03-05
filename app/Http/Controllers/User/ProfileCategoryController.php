<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\ProfileCategory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthenticableService;
use App\Services\NavigationManagerService;
use App\Services\StorageManagerService;
use App\Services\MailableService;
use App\Services\NotifiableService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class ProfileCategoryController extends Controller
{
    private User $user;
    private StorageManagerService $storageManagerService;
    private NotifiableService $notifiableService;
    private MailableService $mailableService;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;
    private AuthenticableService $authenticableService;

    public function __construct(

        User $user,
        NotifiableService $notifiableService,
        MailableService $mailableService,
        StorageManagerService $storageManagerService,
        NavigationManagerService $navigationManagerService,
        AuthenticableService $authenticableService,
    ) {
        $this->user = $user;
        $this->notifiableService = $notifiableService;
        $this->mailableService = $mailableService;
        $this->storageManagerService = $storageManagerService;
        $this->navigationManagerService = $navigationManagerService;
        $this->authenticableService = $authenticableService;
        $this->paginate = Config::get('constants.pagination');
    }
    public function index()
    {
        $categories = ProfileCategory::select([
            'profile_categories.id',
            'profile_categories.name',
        ])
            ->with([
                'subProfiles' => function ($query) {
                    $query->select([
                        'sub_profiles.id',
                        'sub_profiles.profile_category_id',
                        'sub_profiles.name',
                    ]);
                    $query->with([
                        'jobs' => function ($query) {
                            $query->select([
                                'jobs.id',
                                'jobs.sub_profile_id',
                            ]);
                        },
                    ]);
                },
            ])
            ->get();
        return view('user.profile-category.index', compact('categories'));
    }

    public function show($id)
    {
        $category = ProfileCategory::select([
            'profile_categories.id',
            'profile_categories.name',
        ])
            ->with([
                'subProfiles' => function ($query) {
                    $query->select([
                        'sub_profiles.id',
                        'sub_profiles.profile_category_id',
                        'sub_profiles.name',
                    ]);
                    $query->with([
                        'jobs' => function ($query) {
                            $query->select([
                                'jobs.id',
                                'jobs.sub_profile_id',
                            ]);
                        },
                    ]);
                },
            ])
            ->find($id);
        dd($category);
        return view('user.profile-category.show', compact('category'));
    }
}
