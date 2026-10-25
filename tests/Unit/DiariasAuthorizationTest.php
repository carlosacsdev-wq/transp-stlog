<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class DiariasAuthorizationTest extends TestCase
{
    public function test_admin_can_manage_diarias(): void
    {
        $user = new User;
        $user->is_admin = true;

        $this->assertTrue(Gate::forUser($user)->allows('gerenciar-diarias'));
    }

    public function test_finance_user_can_manage_diarias(): void
    {
        $user = new User(['is_financeiro' => true]);

        $this->assertTrue(Gate::forUser($user)->allows('gerenciar-diarias'));
    }

    public function test_regular_user_cannot_manage_diarias(): void
    {
        $user = new User;

        $this->assertFalse(Gate::forUser($user)->allows('gerenciar-diarias'));
    }
}
