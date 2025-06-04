<?php
namespace App\User;

use App\Core\{BaseController, Database, Request, Response};

class UserController extends BaseController {
    private UserTable $userTable;

    public function __construct(Database $db) {
        $this->userTable = new UserTable($db);
    }

    public function index(): array {
        $users = $this->userTable->getAll();
        return $this->success($users);
    }

    public function show(int $id): array {
        $user = $this->userTable->getById($id);
        return $user ? $this->success($user) : $this->error('User not found', 404);
    }

    public function store(Request $request): array {
        $data = $request->validate([
                'name' => 'required|string',
                'password' => 'required|min:6',
                'role' => 'required|in:student,teacher,admin'
        ]);

        $userId = $this->userTable->create($data);
        return $this->success(['id' => $userId], 201);
    }

    public function update(int $id, Request $request): array {
        $data = $request->validate([
                'name' => 'string',
                'password' => 'min:6',
                'role' => 'in:student,teacher,admin'
        ]);

        $this->userTable->update($id, $data);
        return $this->success(['message' => 'User updated']);
    }

    public function destroy(int $id): array {
        $this->userTable->delete($id);
        return $this->success(['message' => 'User deleted']);
    }
}