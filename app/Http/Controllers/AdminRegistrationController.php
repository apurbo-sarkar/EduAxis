<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminRegistrationController extends Controller
{
    /**
     * Display the admin registration form.
     * * NOTE: This route should typically be highly restricted (e.g., only available 
     * once after a fresh install, or protected by an existing Super Admin).
     *
     * @return View
     */
    public function create(): View
    {
        // Renders the admin registration view (e.g., resources/views/admin/register.blade.php)
        return view('admin.register');
    }


    /**
     * Handle an incoming admin registration request.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validation
        $validatedData = $request->validate([
            'fullName' => 'required|string|max:255',
            'adminId' => 'required|string|max:255|unique:admins,admin_id',
            'email' => 'required|email|max:255|unique:admins,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|max:255', // Example: Super Admin, Registrar, HR
            'address' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required|accepted',
        ]);

        // 2. Data Creation
        Admin::create([
            'admin_id' => $validatedData['adminId'],
            'full_name' => $validatedData['fullName'], // Matches 'full_name' in Model $fillable
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'role' => $validatedData['role'],
            'address' => $validatedData['address'] ?? null,
            'terms_agreed' => true,
            'password' => Hash::make($validatedData['password']),
        ]);

        // 3. Redirection
        return redirect()->route('admin.login')
            ->with('success', 'Admin account created successfully. You may now log in.');
    }
}