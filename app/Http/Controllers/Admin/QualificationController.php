<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Qualification;
use App\Services\NavigationManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class QualificationController extends Controller
{
    private Qualification $qualification;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        Qualification $qualification,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->paginate = Config::get('constants.pagination');
        $this->qualification = $qualification;
        $this->navigationManagerService = $navigationManagerService;
    }

    // index
    public function index()
    {
        return $this->navigationManagerService->loadView('admin.qualification.index');
    }

    // getAll
    public function getAll(Request $request)
    {

        $qualifications = $this->qualification->withCount('jobs')->get();

        '<div class=" btn-group d-flex">
            <a href="javascript:void(0)" data-id="' . $qualifications . '" id="" class="showQualification btn btn-primary btn-sm show">
                <i class="bi bi-eye" aria-hidden="true"></i>
            </a>
            <a href="javascript:void(0)" data-id="' . $qualifications . '" id="" class="editQualification btn btn-info btn-sm edit">
                <i class="bi bi-pencil" aria-hidden="true"></i>
            </a>
            <a href="javascript:void(0)" data-id="' . $qualifications . '" id="" class="deleteQualification btn btn-danger btn-sm delete">
                <i class="bi bi-trash" aria-hidden="true"></i>
            </a>
        </div>';

        return  DataTables($qualifications)
            ->addColumn('action', function ($qualification) {
                return
                    '<div class=" btn-group d-flex">
                        <a href="javascript:void(0)" data-id="' . $qualification->id . '" id="" class="showQualification btn btn-primary btn-sm show">
                            <i class="bi bi-eye" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="' . $qualification->id . '" id="" class="editQualification btn btn-info btn-sm edit">
                            <i class="bi bi-pencil" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="' . $qualification->id . '" id="" class="deleteQualification btn btn-danger btn-sm delete">
                            <i class="bi bi-trash" aria-hidden="true"></i>
                        </a>
                    </div>';
            })
            ->rawColumns([
                'action',
            ])->make(true);
    }

    // store
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
            return response()->json(["success" => "Qualification is created"], 200);
        }
        return response()->json(["warning" => "Qualification is not created"], 400);
    }

    // delete
    public function delete(Request $request)
    {
        $id = $request->get('id');

        $qualification = $this->qualification->where('id', $id)->withCount('jobs')->get()->ToArray();
        // return response()->json($qualification, 200);
        if (!$qualification) {
            return response()->json(["warning" => "Qualification is not found"], 400);
        }
        $qualification =  $qualification[0];
        if ($qualification['jobs_count'] == 0) {
            $isDeleted = $this->qualification->where('id', $id)->delete();
            if ($isDeleted) {
                return response()->json(["success" => "Qualification is deleted"], 200);
            }
            return response()->json(["warning" => "Qualification is not deleted"], 400);
        }
        return response()->json(["warning" => "Qualification is not deleted, because it has jobs associated with it"], 400);
    }

    // edit
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $qualification = $this->qualification->where('id', $id)->get()->ToArray();
        if (!$qualification) {
            return response()->json(["warning" => "Qualification is not found"], 400);
        }
        $qualification =  $qualification[0];
        return response()->json($qualification, 200);
    }

    // update
    public function update(Request $request)
    {
        $id = $request->get('id');
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
            return response()->json(["success" => "Qualification is updated"], 200);
        }
        return response()->json(["warning" => "Qualification is not updated"], 400);
    }

    // show
    public function show(Request $request)
    {
        $id = $request->get('id');
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
            return response()->json(["warning" => "Qualification is not found"], 400);
        }
        $qualification =  $qualification[0];
        return response()->json($qualification, 200);
    }
}
