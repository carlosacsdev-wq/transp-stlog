<?php

namespace Tests\Unit;

use App\Models\Carga;
use Carbon\Carbon;
use Tests\TestCase;

class CargaDiariasTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_it_counts_started_days_after_the_first_24_hours(): void
    {
        $carga = new Carga([
            'data_hora_chegada' => '2026-06-01 10:00:00',
            'data_hora_descarga' => '2026-06-02 10:00:01',
        ]);

        $this->assertSame(1, $carga->diarias);
    }

    public function test_it_does_not_count_a_daily_before_the_first_24_hours(): void
    {
        $carga = new Carga([
            'data_hora_chegada' => '2026-06-01 10:00:00',
            'data_hora_descarga' => '2026-06-02 10:00:00',
        ]);

        $this->assertSame(0, $carga->diarias);
    }

    public function test_it_calculates_daily_count_for_a_pending_unload(): void
    {
        Carbon::setTestNow('2026-06-02 11:00:00');
        $carga = new Carga([
            'data_hora_chegada' => '2026-06-01 10:00:00',
        ]);

        $this->assertSame(1, $carga->diarias);
    }

    public function test_it_returns_zero_when_arrival_is_missing(): void
    {
        $carga = new Carga([
            'data_hora_descarga' => '2026-06-03 10:00:00',
        ]);

        $this->assertSame(0, $carga->diarias);
    }

    public function test_it_uses_the_manually_saved_daily_count_instead_of_the_calculation(): void
    {
        $carga = new Carga([
            'data_hora_chegada' => '2026-06-01 10:00:00',
            'data_hora_descarga' => '2026-06-02 10:00:00',
            'diarias' => 3,
        ]);

        $this->assertSame(3, $carga->diarias);
    }
}
