<?php

use Admin\reports\ReportsExporter;
use Tests\TestCase;

class ReportsExporterTest extends TestCase
{
    public function testGetCollectionWithSheetsData(): void
    {
        // Set
        $reports =[
            ['name', 'age'],
            ['jp', 25]
        ];
        $reportsExporter = new ReportsExporter($reports);

        // Actions
        $actual = $reportsExporter->collection();

        // Assertions
        $this->assertSame($reports, $actual->all());
    }
}
