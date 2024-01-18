<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.qualification.create');
    }

    public function store(Request $request)
    {
        // custom validation
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
    }

    public function index()
    {
        $qualifications = $this->qualification->withCount('jobs')->paginate(5);
        return view('admin.qualification.index', compact('qualifications'));
    }

    public function show($id)
    {
        $qualification = $this->qualification
            ->where('id', $id)
            ->with([
                'jobs' => function ($query) {
                    $query->with(['company', 'profile', 'qualifications', 'locations']);
                }
            ])
            ->get()
            ->ToArray();
        if (!$qualification) {
            return redirect()->back()->with("warning", "Qualification is not found");
        }
        $qualification =  $qualification[0];
        return view('admin.qualification.show', compact('qualification'));
    }

    public function edit($id)
    {
        $qualification = $this->qualification->where('id', $id)->get()->ToArray();
        if (!$qualification) {
            return redirect()->back()->with("warning", "Qualification is not found");
        }
        $qualification =  $qualification[0];
        return view('admin.qualification.edit', compact('qualification'));
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
            return redirect()->route('admin.qualification.index')->with('success', 'Qualification is updated');
        }
        return redirect()->back()->with("warning", "Qualification is not updated");
    }

    public function delete($id)
    {
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
    }
}
