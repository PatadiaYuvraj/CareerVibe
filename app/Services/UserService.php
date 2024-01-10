<?php

namespace App\Services;

use App\Models\User;
use App\Repository\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

class UserService implements UserRepo
{
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

    public function validateUser(Request $request, bool $requestfor): ValidationValidator
    {
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

    public function createUser(array $data): array
    {
        // The data should be properly validated.
        if (!$data) return ["status" => false, "msg" => "Data not found", "data" => null];
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user = $user->only(["id", "name", "email", "password", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "User Created Successfully", "data" => $user->toArray()];
    }

    public function getUsers(): array
    {
        $user = User::all();
        if (!isset($user[0])) return ["status" => false, "msg" => "Data not found", "data" => null];
        return ["status" => true, "msg" => "Data found", "data" => $user->toArray()];
    }

    public function getUserByIdWithoutPassword(int $id): array
    {
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find('2');
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        $user = $user->only(["id", "name", "email", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "Data found", "data" => $user->toArray()];
    }

    public function getUserById(int $id): array
    {
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find($id);
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        $user = $user->only(["id", "name", "email", "password", "created_at", "updated_at"]);
        return ["status" => true, "msg" => "Data found", "data" => $user->toArray()];
    }

    public function updateUser(int $id, array $data): array
    {
        if (!$id) return ["status" => false, "msg" => "User found", "data" => null];
        if (!$data) return ["status" => false, "msg" => "User found", "data" => null];
        return ["status" => false, "msg" => "User found", "data" => null];
    }

    public function replaceUser(int $id, array $data): array
    {
        if (!$id) return ["status" => false, "msg" => "User found", "data" => null];
        if (!$data) return ["status" => false, "msg" => "User found", "data" => null];
        return ["status" => false, "msg" => "User found", "data" => null];
    }

    public function deleteUser(int $id): array
    {
        if (!$id) return ["status" => false, "msg" => "ID is not found", "data" => null];
        $user = User::find($id);
        if (!$user) return ["status" => false, "msg" => "User not found", "data" => null];
        if (!($user->delete())) return ["status" => false, "msg" => "Deleting error", "data" => null];
        return ["status" => true, "msg" => "User Deleted Successfully", "data" => $user->toArray()];
    }
}
