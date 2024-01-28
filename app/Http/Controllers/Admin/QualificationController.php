<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Qualification;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    private Qualification $qualification;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        Qualification $qualification,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->paginate = env('PAGINATEVALUE');
        $this->qualification = $qualification;
        $this->navigationManagerService = $navigationManagerService;
    }

    public function create()
    {
        // return $this->navigationManagerService->loadView('view-name');
        // return $this->navigationManagerService->redirectRoute('view-name', [], 302, [], false, ["success" => "message"]);
        // return $this->navigationManagerService->redirectBack(302, [], false, ["success" => "message"]);

        return $this->navigationManagerService->loadView('admin.qualification.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                "unique:qualifications,name",
            ]
        ]);
        $data = [
            "name" => $request->get("name"),
        ];
        $isCreated = $this->qualification->create($data);
        if ($isCreated) {
            return $this->navigationManagerService->redirectRoute('admin.qualification.index', [], 302, [], false, ["success" => "Qualification is created"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Qualification is not created"]);
    }

    public function index()
    {
        $qualifications = $this->qualification->withCount('jobs')->paginate($this->paginate);
        return $this->navigationManagerService->loadView('admin.qualification.index', compact('qualifications'));
    }

    public function show($id)
    {
        $qualification = $this->qualification
            ->where('id', $id)
            ->select('id', 'name', 'created_at')
            ->with([
                'jobs' => function ($query) {
                    $query->select([
                        'jobs.id',
                        'vacancy',
                        "min_salary",
                        "max_salary",
                        "is_active",
                        "is_featured",
                        "is_verified",
                        'jobs.created_at',
                        'sub_profile_id',
                        'company_id',
                    ]);
                    $query->with([
                        'company' => function ($query) {
                            $query->select([
                                'companies.id',
                                'name',
                                // 'email',
                            ]);
                        },
                        'subProfile' => function ($query) {
                            $query->select([
                                'sub_profiles.id',
                                'name',
                            ]);
                        },
                        'qualifications' => function ($query) {
                            $query->select([
                                'qualifications.id',
                                'name',
                            ]);
                        },
                        'locations' => function ($query) {
                            $query->select([
                                'locations.id',
                                "city",
                                "state",
                            ]);
                        },
                    ]);
                }
            ])
            ->get()
            ->ToArray();
        if (!$qualification) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Qualification is not found"]);
        }
        $qualification =  $qualification[0];
        return $this->navigationManagerService->loadView('admin.qualification.show', compact('qualification'));
    }

    public function edit($id)
    {

        $qualification = $this->qualification->where('id', $id)->get()->ToArray();
        if (!$qualification) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Qualification is not found"]);
        }
        $qualification =  $qualification[0];
        return $this->navigationManagerService->loadView('admin.qualification.edit', compact('qualification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => [
                "required",
                "string",
                "max:100",
                "unique:qualifications,name," . $id,
            ]
        ]);
        $data = [
            "name" => $request->get("name"),
        ];
        $isUpdated = $this->qualification->where('id', $id)->update($data);
        if ($isUpdated) {
            return $this->navigationManagerService->redirectRoute('admin.qualification.index', [], 302, [], false, ["success" => "Qualification is updated"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Qualification is not updated"]);
    }

    public function delete($id)
    {
        $qualification = $this->qualification->where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$qualification) {
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Qualification is not found"]);
        }
        $qualification =  $qualification[0];
        if ($qualification['jobs_count'] == 0) {
            $isDeleted = $this->qualification->where('id', $id)->delete();
            if ($isDeleted) {
                return $this->navigationManagerService->redirectRoute('admin.qualification.index', [], 302, [], false, ["success" => "Qualification is deleted"]);
            }
            return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Qualification is not deleted"]);
        }
        return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Qualification is not deleted, because it has jobs associated with it"]);
    }
}
