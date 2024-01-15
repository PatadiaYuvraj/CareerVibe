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
        if (Auth::guard('admin')->attempt($user, true)) {
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
        // The data should be properly validated.
        if (!$data) return ["status" => false, "msg" => "Data not found", "data" => null];
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user = $user->only(["id", "name", "email", "password", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "User Created Successfully", "data" => $user];
    }

    public function getAdmins(): array
    { // TODO: Implement getAdmins() method.
        $user = User::all();
        if (!isset($user[0])) return ["status" => false, "msg" => "Data not found", "data" => null];
        return ["status" => true, "msg" => "Data found", "data" => $user];
    }

    public function getAdminByIdWithoutPassword(int $id): array
    {
        // TODO: Implement getAdminByIdWithoutPassword() method.
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find('2');
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        $user = $user->only(["id", "name", "email", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "Data found", "data" => $user];
    }

    public function getAdminById(int $id): array
    {
        // TODO: Implement getAdminById() method.
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find($id);
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        $user = $user->only(["id", "name", "email", "password", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "Data found", "data" => $user];
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
        return ["status" => true, "msg" => "User Deleted Successfully", "data" => $user];
    }


    public function validatePassword(Request $request): ValidationValidator
    {
        $validate = Validator::make($request->all(), [
            "currentPassword" => "required|min:8",
            "newPassword" => "required|min:8",
            "confirmPassword" => 'required_with:newPassword|same:newPassword|min:8'
        ]);

        return $validate;
    }

    public function changePassword(array $data, $admin_id): array
    {
        $user = User::find($admin_id);
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        if (!(Hash::check($data['currentPassword'], $user->password))) return ["status" => false, "msg" => "Current Password is not matched", "data" => null];
        $user->password = Hash::make($data['newPassword']);
        if (!($user->save())) return ["status" => false, "msg" => "Password not changed", "data" => null];
        return ["status" => true, "msg" => "Password changed successfully", "data" => null];
    }


    public function updateAdmin(array $data, $admin_id): array
    {
        $user = User::find($admin_id);
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!($user->save())) return ["status" => false, "msg" => "User not updated", "data" => null];
        return ["status" => true, "msg" => "User updated successfully", "data" => null];
    }
}
