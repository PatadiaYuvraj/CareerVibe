<?php

namespace App\Jobs;

use App\Models\Demo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProcessRecordsChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $records;
    private int $chunkSize;

    /**
     * Create a new job instance.
     */
    public function __construct(array $records, int $chunkSize = 10)
    {
        $this->records = $records;
        $this->chunkSize = $chunkSize;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Log::info(gettype(collect($this->records)));
        // die();
        // Iterate over chunks of records
        $this->records = array_slice($this->records, 0, $this->chunkSize);


        foreach ($this->records as $key => $chunk) {
            try {
                // Insert each record in the chunk into the database
                // $this->insertRecords($chunk);
                foreach ($chunk as $key => $value) {
                    Log::info($value[1]);
                }
                // foreach ($chunk[$key]->toArray() as $key1 => $value) {
                //     Log::info($value[$key][$key1]);
                // }



                // Demo::insert(
                //     [
                //         'name' => $chunk->name,
                //         'email' => $chunk->email,
                //     ]
                // );
                // Optionally, log successful processing, report progress, etc.
                // Log::info(sprintf('Processed chunk of %d records successfully.', $chunk->count()));
            } catch (\Exception $e) {
                // Handle exception appropriately, e.g., retry the chunk, record the error, etc.
                Log::error('Error processing chunk of records: ' . $e->getMessage());
                // Requeue the chunk with an exponential backoff strategy if desired
                // $this->release(60); // Retry in 60 seconds
            }
        }
    }

    /**
     * Insert records into the database.
     */
    private function insertRecords(Collection $records)
    {
        // Use the appropriate method for your database and ORM (e.g., insert, createMany, etc.)
        $model = new Demo();
        $model->insert($records->toArray());
    }
}
