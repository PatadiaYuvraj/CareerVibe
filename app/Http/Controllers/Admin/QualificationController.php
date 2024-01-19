<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;

class QualificationController extends Controller
{
    private Qualification $qualification;

    public function __construct(Qualification $qualification)
    {
        $this->qualification = $qualification;
    }

    public function create()
    {
        try {
            return view('admin.qualification.create');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
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
                return redirect()->route('admin.qualification.index')->with('success', 'Qualification is created');
            }
            return redirect()->back()->with("warning", "Qualification is not created");
        } catch (\Throwable $th) {

            dd($th->getMessage());
        }
    }

    public function index()
    {
        try {
            $qualifications = $this->qualification->withCount('jobs')->paginate(5);
            return view('admin.qualification.index', compact('qualifications'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function show($id)
    {
        // try {
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
            return redirect()->back()->with("warning", "Qualification is not found");
        }
        $qualification =  $qualification[0];
        // dd($qualification);
        return view('admin.qualification.show', compact('qualification'));
        // } catch (\Throwable $th) {
        //     dd($th->getMessage());
        // }
    }

    public function edit($id)
    {
        try {
            $qualification = $this->qualification->where('id', $id)->get()->ToArray();
            if (!$qualification) {
                return redirect()->back()->with("warning", "Qualification is not found");
            }
            $qualification =  $qualification[0];
            return view('admin.qualification.edit', compact('qualification'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
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
                return redirect()->route('admin.qualification.index')->with('success', 'Qualification is updated');
            }
            return redirect()->back()->with("warning", "Qualification is not updated");
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $qualification = $this->qualification->where('id', $id)->withCount('jobs')->get()->ToArray();
            if (!$qualification) {
                return redirect()->back()->with("warning", "Qualification is not found");
            }
            $qualification =  $qualification[0];
            if ($qualification['jobs_count'] == 0) {
                $isDeleted = $this->qualification->where('id', $id)->delete();
                if ($isDeleted) {
                    return redirect()->route('admin.qualification.index')->with('success', 'Qualification is deleted');
                }
                return redirect()->back()->with("warning", "Qualification is not deleted");
            }
            return redirect()->back()->with("warning", "Qualification is not deleted, because it has jobs associated with it");
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
