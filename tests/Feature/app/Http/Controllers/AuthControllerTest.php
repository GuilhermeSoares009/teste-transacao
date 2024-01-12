<?php 

namespace Feature\app\Http\Controllers;

use Laravel\Lumen\Testing\TestCase;

class AuthControllerTest extends TestCase
{

    public function createApplication() {
        return require './bootstrap/app.php';
    }

    public function testUserShouldNotAuthenticateWithWrongProvider() {

        $request = $this->post(route('authenticate', ['provider' => 'deixa-o-sub']));

        $request->assertResponseStatus(422);
        $request->seeJson(['errors' => ['main' => 'Wrong provider provided']]);
    }
}


?>