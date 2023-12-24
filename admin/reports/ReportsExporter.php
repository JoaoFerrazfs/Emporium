<?php

namespace Admin\reports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExporter implements FromCollection
{
    use Exportable;

    public function __construct(
        private readonly array $reports
    ) {
    }

    public function collection(): Collection
    {
        return collect(
            $this->reports
        )    ;
    }
}
