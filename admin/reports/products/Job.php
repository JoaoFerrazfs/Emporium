<?php

namespace Admin\reports\products;

use Admin\reports\ReportsExporter;
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
        $data = $processor->process($this->products);

        (new ReportsExporter($data))->store(
            $this->fullPath,
            's3'
        );
    }

    public function handlePath(): string
    {
       return self::DEFAULT_FOLDER . DIRECTORY_SEPARATOR .
            "$this->id.csv";

    }
}
