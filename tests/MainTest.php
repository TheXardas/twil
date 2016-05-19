<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MainTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     * @return void
     */
    public function testFrontPageOpening()
    {
        $this->visit('/')
            ->see('Better call us');
        $this->assertResponseOk();
    }
}
