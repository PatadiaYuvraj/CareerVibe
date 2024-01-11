<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function create()
    {
        return view('admin.location.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "city" => "required|string|max:100",
            "state" => "required|string|max:100",
            "country" => "required|string|max:100",
            "pincode" => "required|numeric",
        ]);
        if ($validate->passes()) {
            $data = [
                "city" => $request->get("city"),
                "state" => $request->get("state"),
                "country" => $request->get("country"),
                "pincode" => $request->get("pincode"),
            ];
            $isCreated = Location::create($data);
            if ($isCreated) {
                return redirect()->route('admin.location.index')->with('success', 'Location is created');
            }
            return redirect()->back()->with("warning", "Location is not created");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function index()
    {
        $locations = Location::all();
        return view('admin.location.index', compact('locations'));
    }

    // public function show($id)
    // {
    //     $location = $this->getLocationById($id);
    //     return view('admin.location.show', compact('location'));
    // }

    public function edit($id)
    {
        $location = Location::find($id);
        return view('admin.location.edit', compact('location'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            "city" => "required|string|max:100",
            "state" => "required|string|max:100",
            "country" => "required|string|max:100",
            "pincode" => "required|numeric",
        ]);
        if ($validate->passes()) {
            $data = [
                "city" => $request->get("city"),
                "state" => $request->get("state"),
                "country" => $request->get("country"),
                "pincode" => $request->get("pincode"),
            ];
            $isUpdated = Location::find($id)->update($data);
            if ($isUpdated) {
                return redirect()->route('admin.location.index')->with('success', 'Location is updated');
            }
            return redirect()->back()->with("warning", "Location is not updated");
        }
        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }
    }

    public function delete($id)
    {
        $isDeleted = Location::find($id)->delete();
        if ($isDeleted) {
            return redirect()->route('admin.location.index')->with('success', 'Location is deleted');
        }
        return redirect()->back()->with("warning", "Location is not deleted");
    }
}
