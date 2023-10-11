<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require './bootstrap/app.php';
    }

    public function testUserShouldNotAuthenticateWithWrongProvider() {
        $request = $this->post(route('authenticate',['provider' => 'texto']));

        $request->assertResponseStatus(422);
        $request->seeJson(['errors' => ['main' => 'Wrong provider provided']]);
    }
}
