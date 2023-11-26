<?php

namespace Admin\reports\products;

use Admin\reports\ReportsExporter;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Job implements ShouldQueue
{
    const DEFAULT_FOLDER = 'reports';

    public string $fullPath;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly Collection $products,
        private readonly string $id,
    ){
        $this->fullPath = $this->handlePath();
    }

    public function handle(Processor $processor):void
    {
        if(!$data = $processor->process($this->products)){
            throw  new Exception('Empty data');
        }

        $reportsExporter = new ReportsExporter($data);

        if(!$reportsExporter->store($this->fullPath)){
            throw  new Exception('Error with exportation');
        }

    }

    public function handlePath(): string
    {
       return self::DEFAULT_FOLDER . DIRECTORY_SEPARATOR .
            "$this->id.csv";
    }
}
