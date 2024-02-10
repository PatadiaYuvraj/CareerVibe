<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $index, $unique;
    public function up(): void
    {

        $this->index = [
            "city",
            "state",
            "id",
        ];
        $this->unique = [
            "city",
        ];
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string("city", 20);
            $table->string("state", 25)->nullable();
            $table->string("country", 25)->nullable();
            $table->integer("pincode")->nullable();
            $table->index(
                $this->index
            );
            $table->unique(
                $this->unique
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};


/*
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedJobsTable extends Migration
{
    
    public function up()
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('failed_jobs');
    }
}
*/