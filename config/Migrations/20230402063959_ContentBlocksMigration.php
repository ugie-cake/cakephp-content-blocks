<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class ContentBlocksMigration extends AbstractMigration {
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     * @return void
     */
    public function up(): void {
        $this->table('content_blocks', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
            ])
            ->addColumn('parent', 'string', [
                'limit' => 128,
                'null' => false,
            ])
            // Would prefer this to be 'key', but that is a reserved word for MySQL and likely other DBs.
            ->addColumn('slug', 'string', [
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('label', 'string', [
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'limit' => 32,
                'null' => false,
            ])
            // Would prefer this to be 'value', but that is a reserved word for MySQL and likely other DBs.
            ->addColumn('value', 'text', [
                'limit' => null,
                'null' => true,
                'default' => null,
            ])
            ->addColumn('previous_value', 'text', [
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->create();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     * @return void
     */
    public function down(): void {
        $this->table('content_blocks')->drop()->save();
    }
}
