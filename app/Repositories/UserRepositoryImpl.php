<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class UserRepositoryImpl implements UserRepositoryInterface
{
    public function all(array $filters)
    {
        $query = User::with('role');

        // filtre par rôle
        if (!empty($filters['role'])) {
            $query->whereHas('role', function ($q) use ($filters) {
                $q->where('libelle', $filters['role']);
            });
        }
        // filtre par etat
        if (!empty($filters['active'])) {
            $etat = $filters['active'] === 'oui' ? 'actif' : 'inactif';
            $query->where('etat', $etat);
        }

        return $query->orderBy('login')->paginate(10);
    }

    public function findById(int $id): User
    {
        return User::findOrFail($id); 
    }

    public function create(array $data): User
    {
       
        $role = Role::where('libelle', $data['role'])->firstOrFail();
        return User::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'login' => $data['login'],
            'password' => Hash::make($data['password']),
            'etat' => 'actif',
            'role_id' => $role->id,
            'photo' => $data['photo'],
        ]);
    }

    public function update(int $id, array $data): User
    {
        $user = $this->findById($id);
        $user->update($data);
        return $user;
    }

    public function delete(int $id): bool
    {
        return User::destroy($id);
    }
}
