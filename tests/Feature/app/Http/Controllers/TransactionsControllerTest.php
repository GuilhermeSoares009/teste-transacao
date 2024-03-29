<?php

namespace Feature\app\Http\Controllers;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase;

class TransactionsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function createApplication() {
        return require './bootstrap/app.php';
    }
    
    public function setUp(): void
    {
        parent::setUp();
    }
    
    public function testUserShouldNotSendWrongProvider(){
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $payload = [
            'provider' => 'dsadsa',
            'payee_id' => 'fodasenexiste',
            'amount'   => 123
        ];
        $request = $this->actingAs($user,'users')
            ->post(route('postTransaction'),$payload);

        $request->assertResponseStatus(422);

    }

    public function testUserShouldBeExistingOnProviderToTransfer(){
        $this->artisan('passport:install');
        $user = User::factory()->create();
        $payload = [
            'provider' => 'users',
            'payee_id' => 'fodasenexiste',
            'amount'   => 123
        ];
        
        $request = $this->actingAs($user,'users')
            ->post(route('postTransaction'),$payload);
        $request->assertResponseStatus(404);

    }
}
