<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $this->validateRegistration($request);

        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'The email has already been taken. Please choose another one.',
            ], 409);
        }

        $user = $this->createUser($request);

        event(new Registered($user));
        Auth::login($user);

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $this->formatUserResponse($user),
        ], 201);
    }

    /**
     * Validate the registration request.
     *
     * @param  Request  $request
     * @return void
     * @throws ValidationException
     */
    protected function validateRegistration(Request $request): void
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request  $request
     * @return User
     */
    protected function createUser(Request $request): User
    {
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Format the user response.
     *
     * @param  User  $user
     * @return array
     */
    protected function formatUserResponse(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'created_at' => $user->created_at->format('Y-m-d'),
        ];
    }
}
