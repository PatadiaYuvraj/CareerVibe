<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QualificationController extends Controller
{
    public function create()
    {
        return view('admin.qualification.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "qualification" => "required|string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "qualification" => $request->get("qualification"),
            ];
            $isCreated = Qualification::create($data);
            if ($isCreated) {
                return redirect()->route('admin.qualification.index')->with('success', 'Qualification is created');
            }
            return redirect()->back()->with("warning", "Qualification is not created");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function index()
    {
        $qualifications = Qualification::all()->toArray();
        return view('admin.qualification.index', compact('qualifications'));
    }

    // public function show($id)
    // {
    //     $Qualification = Qualification::where('id', $id)->get()->ToArray();
    //     return view('admin.Qualification.show', compact('Qualification'));
    // }

    public function edit($id)
    {
        $qualification = Qualification::where('id', $id)->get()->ToArray();
        if (!$qualification) {
            return redirect()->back()->with("warning", "Qualification is not found");
        }
        return view('admin.qualification.edit', compact('qualification'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            "qualification" => "required|string|max:100",
        ]);
        if ($validate->passes()) {
            $data = [
                "qualification" => $request->get("qualification"),
            ];
            $isUpdated = Qualification::find($id)->update($data);
            if ($isUpdated) {
                return redirect()->route('admin.qualification.index')->with('success', 'Qualification is updated');
            }
            return redirect()->back()->with("warning", "Qualification is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function delete($id)
    {
        $isDeleted = Qualification::where('id', $id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.qualification.index')->with('success', 'Qualification is deleted');
        }
        return redirect()->back()->with("warning", "Qualification is not deleted");
    }
}
