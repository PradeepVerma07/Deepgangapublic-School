<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->patchExistingTables();
        $this->createAdminTables();
        $this->createWebsiteTables();
    }

    public function down(): void
    {
        // No-op: this migration is intentionally additive for live Hostinger databases.
    }

    private function patchExistingTables(): void
    {
        $this->addColumnIfMissing('contacts', 'school_id', function (Blueprint $table): void {
            $table->unsignedBigInteger('school_id')->nullable()->index();
        });

        foreach ([
            'active' => fn (Blueprint $table) => $table->boolean('active')->default(true),
            'address' => fn (Blueprint $table) => $table->text('address')->nullable(),
            'map_link' => fn (Blueprint $table) => $table->text('map_link')->nullable(),
            'pincode' => fn (Blueprint $table) => $table->string('pincode')->nullable(),
            'mobile2' => fn (Blueprint $table) => $table->string('mobile2')->nullable(),
            'facebook' => fn (Blueprint $table) => $table->string('facebook')->nullable(),
            'instagram' => fn (Blueprint $table) => $table->string('instagram')->nullable(),
            'youtube' => fn (Blueprint $table) => $table->string('youtube')->nullable(),
            'whatsapp_no' => fn (Blueprint $table) => $table->string('whatsapp_no')->nullable(),
            'school_id' => fn (Blueprint $table) => $table->unsignedBigInteger('school_id')->nullable()->index(),
        ] as $column => $callback) {
            $this->addColumnIfMissing('users', $column, $callback);
        }
    }

    private function createAdminTables(): void
    {
        $this->createIfMissing('admin_roles', function (Blueprint $table): void {
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('active')->default(true)->index();
        });

        $this->createIfMissing('admin_menus', function (Blueprint $table): void {
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedBigInteger('parent')->nullable()->index();
            $table->text('description')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('admin_role_menus', function (Blueprint $table): void {
            $table->unsignedBigInteger('role_id')->index();
            $table->unsignedBigInteger('menu_id')->index();
            $table->boolean('add_update')->default(false);
            $table->boolean('trash')->default(false);
            $table->boolean('view')->default(false);
        });
    }

    private function createWebsiteTables(): void
    {
        $this->createIfMissing('classes', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('title');
            $this->orderColumns($table);
        });

        $this->createIfMissing('website_menus', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('title');
            $table->string('slug')->nullable()->index();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $this->orderColumns($table);
        });

        $this->createIfMissing('sections', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->unsignedBigInteger('menu_id')->nullable()->index();
            $table->string('type')->nullable();
            $table->longText('content')->nullable();
            $table->string('heading')->nullable();
            $table->string('file_path')->nullable();
            $table->json('files')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('gallery_categories', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('title');
            $this->orderColumns($table);
        });

        $this->createIfMissing('gallery', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->string('image')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('banners', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('image')->nullable();
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->text('description')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('testimonials', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('messages', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->text('description')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('latest_news', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('date')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('faqs', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('title');
            $table->text('description')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('brand_partners', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('image')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('membership_offers', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('image')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('services', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->string('title');
            $table->string('slug')->nullable()->index();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('teachers', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->unsignedBigInteger('class_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('subject')->nullable();
            $table->string('qualification')->nullable();
            $table->string('image')->nullable();
            $table->date('dob')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('students', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->unsignedBigInteger('class_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('toppers', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->unsignedBigInteger('class_id')->nullable()->index();
            $table->string('name');
            $table->string('marks')->nullable();
            $table->string('year')->nullable();
            $table->string('image')->nullable();
            $this->orderColumns($table);
        });

        $this->createIfMissing('admission_requests', function (Blueprint $table): void {
            $this->schoolColumn($table);
            $table->unsignedBigInteger('class_id')->nullable()->index();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('status')->default('pending')->index();
        });

        $this->createIfMissing('settings', function (Blueprint $table): void {
            $table->string('title')->index();
            $table->longText('value')->nullable();
        });
    }

    private function createIfMissing(string $tableName, Closure $callback): void
    {
        if (Schema::hasTable($tableName)) {
            return;
        }

        Schema::create($tableName, function (Blueprint $table) use ($callback): void {
            $table->id();
            $callback($table);
            $table->timestamps();
        });
    }

    private function addColumnIfMissing(string $tableName, string $column, Closure $callback): void
    {
        if (! Schema::hasTable($tableName) || Schema::hasColumn($tableName, $column)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($callback): void {
            $callback($table);
        });
    }

    private function schoolColumn(Blueprint $table): void
    {
        $table->unsignedBigInteger('school_id')->nullable()->index();
    }

    private function orderColumns(Blueprint $table): void
    {
        $table->integer('seq')->default(0)->index();
        $table->boolean('active')->default(true)->index();
    }
};
