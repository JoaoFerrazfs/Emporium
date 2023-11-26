<?php

use Admin\reports\products\Job;
use Admin\reports\products\Processor;
use Admin\reports\ReportsExporter;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Tests\TestCase;

class JobTest extends TestCase
{
    public function testShouldHandle(): void
    {
        // Set
        $collection = m::mock(Collection::class);
        $processor = m::mock(Processor::class);
        $container = m::mock(Container::class);
        $reportsExporter = m::mock(ReportsExporter::class);
        $job = new Job($collection,'some_id');

        // Expectations
        $processor->expects()
            ->process($collection)
            ->andReturn([['1', '2']]);

        $container->expects()
            ->make(ReportsExporter::class, m::type('array'))
            ->andReturn($reportsExporter);

        $reportsExporter->expects()
            ->store('reports/some_id.csv')
            ->andReturnTrue();

        // Action
        $job->handle($processor, $container);
    }

    public function testShouldNotHandleEmptyData(): void
    {
        // Set
        $collection = m::mock(Collection::class);
        $processor = m::mock(Processor::class);
        $container = m::mock(Container::class);
        $job = new Job($collection,'some_id');

        // Expectations
        $processor->expects()
            ->process($collection)
            ->andReturnNull();

        $this->expectExceptionMessage('Empty data');

        // Action
        $job->handle($processor, $container);
    }

    public function testShouldNotHandleExporterWithError(): void
    {
        // Set
        $collection = m::mock(Collection::class);
        $processor = m::mock(Processor::class);
        $container = m::mock(Container::class);
        $reportsExporter = m::mock(ReportsExporter::class);
        $job = new Job($collection,'some_id');

        // Expectations
        $processor->expects()
            ->process($collection)
            ->andReturn([$processor]);

        $container->expects()
            ->make(ReportsExporter::class, m::type('array'))
            ->andReturn($reportsExporter);

        $reportsExporter->expects()
            ->store('reports/some_id.csv')
            ->andReturnFalse();

        $this->expectExceptionMessage('Error with exportation');

        // Action
        $job->handle($processor, $container);
    }
}
