<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'email' => [
                ...$this->emailRules(),
                function ($attribute, $value, $fail) {
                    $domainDiizinkan = ['student.telkomuniversity.ac.id', 'telkomuniversity.ac.id'];
                    $domainEmail = strtolower((string) substr((string) strrchr($value, '@'), 1));

                    if (! in_array($domainEmail, $domainDiizinkan)) {
                        $fail('Pendaftaran hanya untuk email kampus Telkom University (@student.telkomuniversity.ac.id atau @telkomuniversity.ac.id).');
                    }
                },
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
        ]);
    }
}
