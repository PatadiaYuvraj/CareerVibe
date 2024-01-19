<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    private Location $location;

    public function __construct(Location $location)
    {
        $this->location = $location;
    }

    public function create()
    {
        return view('admin.location.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            "city" => [
                "required",
                "string",
                "max:100",
            ],
        ]);
        // validate request data 
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
            return redirect()->route('admin.location.index')->with('success', 'Location is created');
        }
        return redirect()->back()->with("warning", "Location is not created");
    }

    public function index()
    {
        $locations = $this->location->withCount('jobs')->paginate(5);
        return view('admin.location.index', compact('locations'));
    }

    public function show($id)
    {
        $location = $this->location
            ->select(['id', 'city', 'state', 'locations.created_at'])
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
        // dd($location);
        if (!$location) {
            return redirect()->back()->with("warning", "Location is not found");
        }
        $location =  $location[0];
        return view('admin.location.show', compact('location'));
    }

    public function edit($id)
    {
        $location = $this->location->where('id', $id)->get()->ToArray();
        if (!$location) {
            return redirect()->back()->with("warning", "Location is not found");
        }
        $location =  $location[0];
        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "city" => [
                "required",
                "string",
                "max:100",
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
            return redirect()->back()->with("warning", "Location is not found");
        }
        $isUpdated = $isUpdated->update($data);
        if ($isUpdated) {
            return redirect()->route('admin.location.index')->with('success', 'Location is updated');
        }
        return redirect()->back()->with("warning", "Location is not updated");
    }

    public function delete($id)
    {
        $location = $this->location->where('id', $id)->withCount('jobs')->get()->ToArray();
        if (!$location) {
            return redirect()->back()->with("warning", "Location is not found");
        }
        $location =  $location[0];
        if ($location['jobs_count'] == 0) {
            $isDeleted = $this->location->where('id', $id)->delete();
            if ($isDeleted) {
                return redirect()->route('admin.location.index')->with('success', 'Location is deleted');
            }
            return redirect()->back()->with("warning", "Location is not deleted");
        }
        return redirect()->back()->with("warning", "Location is not deleted, because it has jobs associated with it");
    }
}
