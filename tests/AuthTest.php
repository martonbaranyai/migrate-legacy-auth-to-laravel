<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    public function test_original_auth_still_works()
    {
        $user = factory(User::class)->create([
            'name'     => 'John Smith',
            'email'    => 'john@example.com',
            'password' => bcrypt('asdf1234'),
        ]);

        $this->post('/login', [
            'email'    => 'john@example.com',
            'password' => 'asdf1234',
        ])->followRedirects()
            ->see('Welcome')
            ->see('John Smith');
    }

    public function test_legacy_auth_works()
    {
        
    }
}
