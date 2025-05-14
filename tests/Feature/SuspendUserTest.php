<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;

class SuspendUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_suspend_a_user()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'admin'); // تسجيل دخول كأدمن

        $user = User::factory()->create([
            'status' => 'active',
        ]);

        $response = $this->patch('/admin/stores/' . $user->id . '/suspend');

        $response->assertRedirect();
        $this->assertEquals('suspended', $user->fresh()->status);

    }
}
