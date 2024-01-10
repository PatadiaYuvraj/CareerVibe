<?php

namespace App\Services;

use App\Models\Admin as User;
use App\Repository\AdminRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class AdminService implements AdminRepo
{
    public function authorised(array $data): array
    {
        // TODO: Implement authorised() method.
        return [];
    }
    public function authenticate(array $data): array
    {
        if (!$data) return ["status" => false, "msg" => "Data not found", "data" => null];
        $user = ["email" => $data['email'], "password" => $data['password']];
        if (Auth::guard('user')->attempt($user)) {
            return ["status" => true, "msg" => "User is Authenticated", "data" => null];
        } else {
            return ["status" => false, "msg" => "User is not Authenticated", "data" => null];
        }

        // return ["status" => false, "msg" => "Data not found", "data" => null];
    }

    public function validateAdmin(Request $request, bool $requestfor): ValidationValidator
    {
        // TODO: Implement validateAdmin() method.
        // true -> register, false -> login
        if ($requestfor) {
            // register route validation
            $validate = Validator::make($request->all(), [
                "name" => "required|min:5|max:30",
                "email" => "required|unique:users,email|email",
                "password" => "required|min:8",
                "confirm_password" => 'required_with:password|same:password|min:8'
            ]);
        } else {
            // login route validation
            $validate = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required|min:8",
            ]);
        }
        return $validate;
    }

    public function createAdmin(array $data): array
    {
        // TODO: Implement createAdmin() method.
        return [];
        // The data should be properly validated.
        if (!$data) return ["status" => false, "msg" => "Data not found", "data" => null];
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user = $user->only(["id", "name", "email", "password", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "User Created Successfully", "data" => $user->toArray()];
    }

    public function getAdmins(): array
    { // TODO: Implement getAdmins() method.
        $user = User::all();
        if (!isset($user[0])) return ["status" => false, "msg" => "Data not found", "data" => null];
        return ["status" => true, "msg" => "Data found", "data" => $user->toArray()];
    }

    public function getAdminByIdWithoutPassword(int $id): array
    {
        // TODO: Implement getAdminByIdWithoutPassword() method.
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find('2');
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        $user = $user->only(["id", "name", "email", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "Data found", "data" => $user->toArray()];
    }

    public function getAdminById(int $id): array
    {
        // TODO: Implement getAdminById() method.
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find($id);
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        $user = $user->only(["id", "name", "email", "password", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "Data found", "data" => $user->toArray()];
    }

    // public function updateAdmin(int $id, array $data): array
    // { 
    // TODO: Implement updateAdmin() method.
    //     if (!$id) return ["status" => false, "msg" => "User found", "data" => null];
    //     if (!$data) return ["status" => false, "msg" => "User found", "data" => null];
    //     return ["status" => false, "msg" => "User found", "data" => null];
    // }

    // public function replaceAdmin(int $id, array $data): array
    // { 
    // TODO: Implement replaceAdmin() method.
    //     if (!$id) return ["status" => false, "msg" => "User found", "data" => null];
    //     if (!$data) return ["status" => false, "msg" => "User found", "data" => null];
    //     return ["status" => false, "msg" => "User found", "data" => null];
    // }

    public function deleteAdmin(int $id): array
    {
        // TODO: Implement deleteAdmin() method.
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find($id);
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        if (!($user->delete())) return ["status" => false, "msg" => "Deleting error", "data" => null];
        return ["status" => true, "msg" => "User Deleted Successfully", "data" => $user->toArray()];
    }
}
