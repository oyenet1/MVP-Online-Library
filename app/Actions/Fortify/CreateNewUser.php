<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use phpDocumentor\Reflection\Types\Nullable;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                // 'required',
                // 'string',
                // 'email',
                // 'max:255',
                // Rule::unique(User::class),
                'nullable'
            ], 
            'phone' => ['required', 'digits:10'],
            'library_id' => 'nullable',
            'password' => $this->passwordRules(),

        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => Str::slug($input['name']).'@e-library.com',
            'phone' => $input['phone'],
            'library_id' => strtoupper($input['name'].'-' . Str::random(5)),
            'password' => Hash::make($input['password']),
        ]);

        return $user->attachRole(2);

    }
}
