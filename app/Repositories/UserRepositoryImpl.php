<?php

namespace App\Repositories;

use App\Repositories\UserRepositoryInterface;
use App\Models\User;
use App\Models\Role;

class UserRepositoryImpl implements UserRepositoryInterface
{
    public function all($filters)
    {
        $query = User::with('role');

        if (isset($filters['role'])) {
            $query->whereHas('role', function ($q) use ($filters) {
                $q->where('libelle', $filters['role']);
            });
        }

        if (isset($filters['active'])) {
            $etat = $filters['active'] === 'oui' ? 'actif' : 'inactif';
            $query->where('etat', $etat);
        }

        return $query->orderBy('name')->paginate(10);
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function create($data)
    {
        $role = Role::where('libelle', $data['role'])->firstOrFail();

        return User::create([
            'name' => $data['name'],
            'login' => $data['login'],
            'password' => bcrypt($data['password']),
            'etat' => 'actif',
            'role_id' => $role->id,
        ]);
    }

    public function update($id, $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }
}
