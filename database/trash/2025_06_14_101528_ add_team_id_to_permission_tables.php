<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add team_id to roles table
        Schema::table('roles', function (Blueprint $table) {
            $table->foreignId('team_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->after('guard_name');

            // Drop old unique constraint
            $table->dropUnique(['name', 'guard_name']);

            // Add new unique constraint with team_id
            $table->unique(['name', 'guard_name', 'team_id']);
        });

        // Add team_id to permissions table
        Schema::table('permissions', function (Blueprint $table) {
            $table->foreignId('team_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->after('guard_name');

            $table->dropUnique(['name', 'guard_name']);
            $table->unique(['name', 'guard_name', 'team_id']);
        });

        // Add team_id to model_has_roles table
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->foreignId('team_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->after('role_id');

            // Update primary key to include team_id
            $table->dropPrimary();
            $table->primary(
                ['team_id', 'role_id', 'model_id', 'model_type'],
                'model_has_roles_role_model_type_primary'
            );
        });

        // Add team_id to model_has_permissions table
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->foreignId('team_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->after('permission_id');

            $table->dropPrimary();
            $table->primary(
                ['team_id', 'permission_id', 'model_id', 'model_type'],
                'model_has_permissions_permission_model_type_primary'
            );
        });

        // Add team_id to role_has_permissions table
        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->foreignId('team_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->after('permission_id');

            $table->dropPrimary();
            $table->primary(
                ['team_id', 'permission_id', 'role_id'],
                'role_has_permissions_permission_role_id_primary'
            );
        });
    }

    public function down()
    {
        // Reverse all changes
        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
            $table->dropUnique(['name', 'guard_name', 'team_id']);
            $table->unique(['name', 'guard_name']);
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
            $table->dropUnique(['name', 'guard_name', 'team_id']);
            $table->unique(['name', 'guard_name']);
        });

        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
            $table->dropPrimary();
            $table->primary(
                ['role_id', 'model_id', 'model_type'],
                'model_has_roles_role_model_type_primary'
            );
        });

        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
            $table->dropPrimary();
            $table->primary(
                ['permission_id', 'model_id', 'model_type'],
                'model_has_permissions_permission_model_type_primary'
            );
        });

        Schema::table('role_has_permissions', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
            $table->dropPrimary();
            $table->primary(
                ['permission_id', 'role_id'],
                'role_has_permissions_permission_role_id_primary'
            );
        });
    }
};
