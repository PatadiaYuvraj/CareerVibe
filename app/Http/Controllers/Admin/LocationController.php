<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\NavigationManagerService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    private Location $location;
    private int $paginate;
    private NavigationManagerService $navigationManagerService;

    public function __construct(
        Location $location,
        NavigationManagerService $navigationManagerService,
    ) {
        $this->location = $location;
        $this->paginate = Config::get('constants.pagination');
        $this->navigationManagerService = $navigationManagerService;
    }



    // public function store(Request $request)
    // {
    //     $request->validate([
    //         "city" => [
    //             "required",
    //             "string",
    //             "max:100",
    //             function ($attribute, $value, $fail) {
    //                 $isExist = $this->location->where('city', $value)->get()->ToArray();
    //                 if ($isExist) {
    //                     return $fail($attribute . ' is already exist.');
    //                 }
    //             },
    //         ],
    //     ]);
    //     $data = [
    //         "city" => $request->get("city"),
    //     ];

    //     if ($request->get("state")) {
    //         $request->validate([
    //             "state" => [
    //                 "required",
    //                 "string",
    //                 "max:100",
    //             ],
    //         ]);
    //         $data["state"] = $request->get("state");
    //     }

    //     if ($request->get("country")) {
    //         $request->validate([
    //             "country" => [
    //                 "required",
    //                 "string",
    //                 "max:100",
    //             ],
    //         ]);
    //         $data["country"] = $request->get("country");
    //     }

    //     if ($request->get("pincode")) {
    //         $request->validate([
    //             "pincode" => [
    //                 "required",
    //                 "numeric",
    //                 "digits:6",
    //             ],
    //         ]);
    //         $data["pincode"] = $request->get("pincode");
    //     }
    //     $isCreated = $this->location->create($data);
    //     if ($isCreated) {
    //         return $this->navigationManagerService->redirectRoute('admin.location.index', [], 302, [], false, ["success" => "Location is created"]);
    //     }
    //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not created"]);
    // }

    // public function index()
    // {
    //     // $locations = $this->location->withCount('jobs')->paginate($this->paginate);
    //     return $this->navigationManagerService->loadView('admin.location.index');
    // }

    // public function show($id)
    // {
    //     $location = $this->location
    //         ->select([
    //             'id',
    //             'city',
    //             'state',
    //             'country',
    //             'locations.created_at'
    //         ])
    //         ->where('id', $id)
    //         ->with([
    //             'jobs' => function ($query) {
    //                 $query->select([
    //                     'jobs.id',
    //                     'company_id',
    //                     'sub_profile_id',
    //                     'vacancy',
    //                     'min_salary',
    //                     'max_salary',
    //                     'work_type',
    //                     'job_type',
    //                     'experience_level',
    //                     'is_active',
    //                     'is_verified',
    //                     'is_featured',
    //                     'jobs.created_at'
    //                 ]);
    //                 $query->with([
    //                     'company' => function ($query) {
    //                         $query->select(['companies.id', 'name',]);
    //                     },
    //                     'qualifications' => function ($query) {
    //                         $query->select(['qualifications.id', 'name',]);
    //                     },
    //                     'locations' => function ($query) {
    //                         $query->select(['locations.id', 'city', 'state']);
    //                     },
    //                 ]);
    //             }
    //         ])
    //         ->get()
    //         ->ToArray();
    //     if (!$location) {
    //         return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not found"]);
    //     }
    //     $location =  $location[0];
    //     return $this->navigationManagerService->loadView('admin.location.show', compact('location'));
    // }

    // public function edit($id)
    // {
    //     $location = $this->location->where('id', $id)->get()->ToArray();
    //     if (!$location) {
    //         return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not found"]);
    //     }
    //     $location =  $location[0];
    //     return $this->navigationManagerService->loadView('admin.location.edit', compact('location'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         "city" => [
    //             "required",
    //             "string",
    //             "max:100",
    //             function ($attribute, $value, $fail) use ($id) {
    //                 $isExist = $this->location->where('id', '!=', $id)->where('city', $value)->get()->ToArray();
    //                 if ($isExist) {
    //                     return $fail($attribute . ' is already exist.');
    //                 }
    //             },
    //         ],
    //     ]);

    //     $data = [
    //         "city" => $request->get("city"),
    //     ];

    //     $data['state'] = $data['country'] = $data['pincode'] = null;
    //     if ($request->get("state")) {
    //         $request->validate([
    //             "state" => [
    //                 "required",
    //                 "string",
    //                 "max:100",
    //             ],
    //         ]);
    //         $data["state"] = $request->get("state");
    //     }

    //     if ($request->get("country")) {
    //         $request->validate([
    //             "country" => [
    //                 "required",
    //                 "string",
    //                 "max:100",
    //             ],
    //         ]);
    //         $data["country"] = $request->get("country");
    //     }

    //     if ($request->get("pincode")) {
    //         $request->validate([
    //             "pincode" => [
    //                 "required",
    //                 "numeric",
    //                 "digits:6",
    //             ],
    //         ]);
    //         $data["pincode"] = $request->get("pincode");
    //     }
    //     $isUpdated = $this->location->find($id);
    //     if (!$isUpdated) {
    //         return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not found"]);
    //     }
    //     $isUpdated = $isUpdated->update($data);
    //     if ($isUpdated) {
    //         return $this->navigationManagerService->redirectRoute('admin.location.index', [], 302, [], false, ["success" => "Location is updated"]);
    //     }
    //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not updated"]);
    // }

    // public function delete($id)
    // {
    //     $location = $this->location->where('id', $id)->withCount('jobs')->get()->ToArray();
    //     if (!$location) {
    //         return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not found"]);
    //     }
    //     $location =  $location[0];
    //     if ($location['jobs_count'] == 0) {
    //         $isDeleted = $this->location->where('id', $id)->delete();
    //         if ($isDeleted) {
    //             return $this->navigationManagerService->redirectRoute('admin.location.index', [], 302, [], false, ["success" => "Location is deleted"]);
    //         }
    //         return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not deleted"]);
    //     }
    //     return $this->navigationManagerService->redirectBack(302, [], false, ["warning" => "Location is not deleted, because it has jobs associated with it"]);
    // }

    public function getAll()
    {
        $locations    = $this->location
            ->withCount('jobs')
            ->get();

        return DataTables::of($locations)
            ->addColumn('action', function ($location) {
                return
                    '<div class=" btn-group d-flex">
                        <a href="javascript:void(0)" data-id="' . $location->id . '" id="" class="showLocation btn btn-primary btn-sm show">
                            <i class="bi bi-eye" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="' . $location->id . '" id="" class="editLocation btn btn-info btn-sm edit">
                            <i class="bi bi-pencil" aria-hidden="true"></i>
                        </a>
                        <a href="javascript:void(0)" data-id="' . $location->id . '" id="" class="deleteLocation btn btn-danger btn-sm delete">
                            <i class="bi bi-trash" aria-hidden="true"></i>
                        </a>
                    </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        return $this->navigationManagerService->loadView('admin.location.index');
    }

    public function store(Request $request)
    {

        $request->validate([
            "city" => [
                "required",
                "string",
                "max:100",
                "unique:locations,city",
            ],
        ]);
        $data = [
            "city" => $request->get("city"),
        ];


        if ($request->get("state")) {
            $request->validate([
                "state" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["state"] = $request->get("state");
        }

        if ($request->get("country")) {
            $request->validate([
                "country" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["country"] = $request->get("country");
        }

        if ($request->get("pincode")) {
            $request->validate([
                "pincode" => [
                    "required",
                    "numeric",
                    "digits:6",
                ],
            ]);
            $data["pincode"] = $request->get("pincode");
        }

        $isCreated = $this->location->create($data);
        if ($isCreated) {
            return response()->json(["success" => "Location is created"], 200);
        }
        return response()->json(["warning" => "Location is not created"], 400);
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $location = $this->location->where('id', $id)->withCount('jobs')->get()->ToArray();

        if (!$location) {
            return response()->json(["warning" => "Location is not found"], 400);
        }
        $location =  $location[0];
        if ($location['jobs_count'] == 0) {
            $isDeleted = $this->location->where('id', $id)->delete();
            if ($isDeleted) {
                return response()->json(["success" => "Location is deleted"], 200);
            }
            return response()->json(["warning" => "Location is not deleted"], 400);
        }
        return response()->json(["warning" => "Location is not deleted, because it has jobs associated with it"], 400);
    }

    // edit
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $location = $this->location->where('id', $id)->get()->ToArray();
        if (!$location) {
            return response()->json(["warning" => "Location is not found"], 400);
        }
        $location =  $location[0];
        return response()->json($location, 200);
    }

    // update
    public function update(Request $request)
    {
        $id = $request->get('id');
        $request->validate([
            "city" => [
                "required",
                "string",
                "max:100",
                "unique:locations,city," . $id,
            ],
        ]);

        $data = [
            "city" => $request->get("city"),
        ];

        $data['state'] = $data['country'] = $data['pincode'] = null;

        if ($request->get("state")) {
            $request->validate([
                "state" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["state"] = $request->get("state");
        }


        if ($request->get("country")) {
            $request->validate([
                "country" => [
                    "required",
                    "string",
                    "max:100",
                ],
            ]);
            $data["country"] = $request->get("country");
        }

        if ($request->get("pincode")) {
            $request->validate([
                "pincode" => [
                    "required",
                    "numeric",
                    "digits:6",
                ],
            ]);
            $data["pincode"] = $request->get("pincode");
        }

        $isUpdated = $this->location->find($id);
        if (!$isUpdated) {
            return response()->json(["warning" => "Location is not found"], 400);
        }
        $isUpdated = $isUpdated->update($data);
        if ($isUpdated) {
            return response()->json(["success" => "Location is updated"], 200);
        }
        return response()->json(["warning" => "Location is not updated"], 400);
    }

    public function show(Request $request)
    {
        $id = $request->get('id');
        $location = $this->location
            ->select([
                'id',
                'city',
                'state',
                'country',
                'locations.created_at'
            ])
            ->where('id', $id)
            ->with([
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
                        'jobs.created_at'
                    ]);
                    $query->with([
                        'company' => function ($query) {
                            $query->select(['companies.id', 'name',]);
                        },
                        'qualifications' => function ($query) {
                            $query->select(['qualifications.id', 'name',]);
                        },
                        'locations' => function ($query) {
                            $query->select(['locations.id', 'city', 'state']);
                        },
                    ]);
                }
            ])
            ->get()
            ->ToArray();
        if (!$location) {
            return response()->json(["warning" => "Location is not found"], 400);
        }
        $location =  $location[0];
        return response()->json($location, 200);
    }
}
