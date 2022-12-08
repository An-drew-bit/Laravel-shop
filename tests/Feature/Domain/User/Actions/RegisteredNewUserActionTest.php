<?php

namespace Tests\Feature\Domain\User\Actions;

use Domain\User\Actions\Contract\RegisteredContract;
use Domain\User\DTO\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisteredNewUserActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_success_user_created(): void
    {
        $actions = app(RegisteredContract::class);

        $actions(NewUserDTO::make('test', 'testing@mail.com', 'password'));

        $this->assertDatabaseHas('users', [
            'email' => 'testing@mail.com'
        ]);
    }
}
