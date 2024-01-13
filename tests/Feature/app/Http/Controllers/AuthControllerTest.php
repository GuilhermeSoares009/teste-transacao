<?php 

namespace Feature\app\Http\Controllers;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function createApplication() {
        return require './bootstrap/app.php';
    }

    public function testUserShouldNotAuthenticateWithWrongProvider() {

        $payload = [
            'email' => 'hey@guilherme3s.dev',
            'password' => 'secret123'
        ];

        $request = $this->post(route('authenticate', ['provider' => 'deixa-o-sub']), $payload);

        $request->assertResponseStatus(422);
        $request->seeJson(['errors' => ['main' => 'Wrong provider provided']]);
    }

    public function testUserShouldBeDeniedIfNoRegistered() {

        $payload = [
            'email' => 'hey@guilherme3s.dev',
            'password' => 'secret123'
        ];

        $request = $this->post(route('authenticate', ['provider' => 'user']), $payload);

        $request->assertResponseStatus(401);
        $request->seeJson(['errors' => ['main' => 'Wrong credentials']]);
    }
}


?>