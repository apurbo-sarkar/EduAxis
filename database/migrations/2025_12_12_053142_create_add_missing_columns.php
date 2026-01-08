<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration adds missing columns to existing students and teachers tables
     */
    public function up(): void
    {
        
        // ====================================================
        // STUDENTS TABLE - Add missing columns (SAFE VERSION)
        // ====================================================
        if (Schema::hasTable('students')) {

            Schema::table('students', function (Blueprint $table) {

                // DO NOT touch primary key (student_id)

                if (!Schema::hasColumn('students', 'full_name')) {
                    $table->string('full_name')->nullable();
                }

                if (!Schema::hasColumn('students', 'email')) {
                    $table->string('email')->nullable();
                }

                if (!Schema::hasColumn('students', 'phone')) {
                    $table->string('phone', 20)->nullable();
                }

                if (!Schema::hasColumn('students', 'class')) {
                    $table->string('class', 50)->nullable();
                }

                if (!Schema::hasColumn('students', 'section')) {
                    $table->string('section', 10)->nullable();
                }

                if (!Schema::hasColumn('students', 'roll_number')) {
                    $table->string('roll_number', 50)->nullable();
                }

                if (!Schema::hasColumn('students', 'guardian_name')) {
                    $table->string('guardian_name')->nullable();
                }

                if (!Schema::hasColumn('students', 'guardian_phone')) {
                    $table->string('guardian_phone', 20)->nullable();
                }

                if (!Schema::hasColumn('students', 'status')) {
                    $table->enum('status', ['active', 'inactive', 'suspended'])
                        ->default('active');
                }
            });

            // ====================================================
            // DATA MIGRATION (NO PRIMARY KEY MODIFICATION)
            // ====================================================
            DB::statement("
                UPDATE students
                SET
                    full_name = COALESCE(full_name, 'Student Name'),
                    email = COALESCE(
                        student_email,
                        email,
                        CONCAT('student', student_id, '@temp.com')
                    ),
                    class = COALESCE(class, student_class)
            ");

            // ====================================================
            // ENFORCE NOT NULL WHERE REQUIRED
            // ====================================================
            Schema::table('students', function (Blueprint $table) {
                $table->string('full_name')->nullable(false)->change();
                $table->string('email')->nullable(false)->change();
            });

            // ====================================================
            // UNIQUE INDEXES
            // ====================================================
            try {
                DB::statement('ALTER TABLE students ADD UNIQUE KEY unique_student_email (email)');
            } catch (\Exception $e) {
                // already exists
            }
        }

        // ====================================================
        // TEACHERS TABLE - Add missing columns
        // ====================================================
        if (Schema::hasTable('teachers')) {
            Schema::table('teachers', function (Blueprint $table) {
                // Add new columns if they don't exist
                if (!Schema::hasColumn('teachers', 'teacher_id')) {
                    $table->string('teacher_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('teachers', 'full_name')) {
                    $table->string('full_name')->nullable()->after('teacher_id');
                }
                if (!Schema::hasColumn('teachers', 'date_of_birth')) {
                    $table->date('date_of_birth')->nullable()->after('full_name');
                }
                if (!Schema::hasColumn('teachers', 'address')) {
                    $table->text('address')->nullable()->after('date_of_birth');
                }
                if (!Schema::hasColumn('teachers', 'department')) {
                    $table->string('department', 100)->nullable()->after('address');
                }
                if (!Schema::hasColumn('teachers', 'designation')) {
                    $table->string('designation', 100)->nullable()->after('department');
                }
                if (!Schema::hasColumn('teachers', 'qualification')) {
                    $table->string('qualification')->nullable()->after('designation');
                }
                if (!Schema::hasColumn('teachers', 'joining_date')) {
                    $table->date('joining_date')->nullable()->after('qualification');
                }
                if (!Schema::hasColumn('teachers', 'salary')) {
                    $table->decimal('salary', 10, 2)->nullable()->after('joining_date');
                }
                if (!Schema::hasColumn('teachers', 'status')) {
                    $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active')->after('salary');
                }
            });

            // Copy data from old columns to new columns
            DB::statement("
                UPDATE teachers 
                SET 
                    full_name = COALESCE(full_name, CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, ''))),
                    date_of_birth = COALESCE(date_of_birth, dob),
                    teacher_id = COALESCE(teacher_id, CONCAT('TCH', LPAD(id, 5, '0')))
            ");

            // Make required columns NOT NULL
            Schema::table('teachers', function (Blueprint $table) {
                $table->string('teacher_id')->nullable(false)->change();
                $table->string('full_name')->nullable(false)->change();
            });

            // Add unique indexes
            try {
                DB::statement('ALTER TABLE teachers ADD UNIQUE KEY unique_teacher_id (teacher_id)');
            } catch (\Exception $e) {
                // Index might already exist
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove added columns from students table
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn([
                    'student_id',
                    'full_name',
                    'email',
                    'phone',
                    'class',
                    'section',
                    'roll_number',
                    'guardian_name',
                    'guardian_phone',
                    'status'
                ]);
            });
        }

        // Remove added columns from teachers table
        if (Schema::hasTable('teachers')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn([
                    'teacher_id',
                    'full_name',
                    'date_of_birth',
                    'address',
                    'department',
                    'designation',
                    'qualification',
                    'joining_date',
                    'salary',
                    'status'
                ]);
            });
        }
    }
};