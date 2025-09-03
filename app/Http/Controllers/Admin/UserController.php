<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role Filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(25)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = UserRole::getAvailableRoles();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => Rule::in(UserRole::getAvailableRoles())
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => UserRole::from($validated['role']),
        ]);

        return redirect()->route('admin.users.edit', $user->id)
            ->with('success', 'Mağaza başarıyla oluşturuldu.');
    }

    public function edit(User $user)
    {
        // Süper admin düzenlenemez
        if ($user->role === UserRole::SUPERADMIN) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Süper admin düzenlenemez.');
        }

        $roles = UserRole::getAvailableRoles();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Süper admin düzenlenemez
        if ($user->role === UserRole::SUPERADMIN) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Süper admin düzenlenemez.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:' . implode(',', array_column(UserRole::getAvailableRoles(), 'value'))],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->role = UserRole::from($validated['role']);
        
        // Şifre sadece girilmişse güncellenir
        if (!empty($validated['password'])) {
            $request->validate([
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.edit', $user->id)
            ->with('success', 'Mağaza başarıyla güncellendi.');
    }

    /**
     * Kullanıcıyı soft delete ile siler.
     */
    public function destroy(User $user)
    {
        // Süper admin kontrolü
        if ($user->role->value === UserRole::SUPERADMIN->value) {
            return redirect()->back()->with('error', 'Süper admin silinemez!');
        }

        try {
            // Email'i değiştirip öyle silelim
            $timestamp = now()->timestamp;
            $user->email = $user->email . '.deleted.' . $timestamp;
            $user->save();
            
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Mağaza başarıyla silindi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Mağaza silinirken bir hata oluştu.');
        }
    }
} 