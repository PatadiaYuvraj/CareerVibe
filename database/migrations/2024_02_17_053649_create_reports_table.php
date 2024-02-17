<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    private array $reportTypes, $index, $unique;
    public function up(): void
    {
        $this->reportTypes = Config::get('constants.report.type');
        $this->index = [
            'reporter_type',
            'reporter_id',
            'reportable_type',
            'reportable_id',
            'is_resolved',
            'type',
        ];
        $this->unique = [
            'reporter_type',
            'reporter_id',
            'reportable_type',
            'reportable_id',
            'type',
        ];

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->morphs('reporter'); // reporter is the model that is reporting ( user or company)
            $table->morphs('reportable'); // reportable is the model that is being reported (post, comment, user, company)
            $table->enum(
                'type',
                $this->reportTypes
            )->default('other');
            $table->text('description')->nullable(); // description of the report
            $table->boolean('is_resolved')->default(false);
            $table->morphs('resolved_by'); // resolved_by is the model that resolved the report (admin)
            $table->text('resolution')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->index(
                $this->index,
                'index_report'
            );
            $table->unique(
                $this->unique,
                'unique_report'
            );
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
