<?php

namespace Tests\Feature;

use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    public function test_terms_page_is_accessible(): void
    {
        $this->get(route('terms'))
            ->assertOk()
            ->assertSee('Syarat & Ketentuan', false);
    }

    public function test_privacy_page_is_accessible(): void
    {
        $this->get(route('privacy'))
            ->assertOk()
            ->assertSee('Kebijakan Privasi');
    }
}
