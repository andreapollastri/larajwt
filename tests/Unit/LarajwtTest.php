<?php

namespace Andr3a\Larajwt\Tests\Unit;

use Andr3a\Larajwt\Larajwt;
use Andr3a\Larajwt\Tests\TestCase;

class LarajwtTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function larajwt_instantiate_correctly()
    {
        $service = $this->app->make(Larajwt::class);

        $this->assertInstanceOf('Andr3a\Larajwt\Larajwt', $service);
    }
}
