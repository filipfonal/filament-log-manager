<?php

namespace FilipFonal\FilamentLogManager\Tests;

class FilamentLogManagerTest extends TestCase
{
    public function testArtisanCommand(): void
    {
        $this->artisan('filament-log-manager')
            ->expectsOutput('All done')
            ->assertExitCode(0);
    }
}
