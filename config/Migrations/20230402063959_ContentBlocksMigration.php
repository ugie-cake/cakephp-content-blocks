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
        // This table contains the key-value pairs for ContentBlock components.
        // Note: that strings like "page", "key", "value" are actually MySQL reserved words
        // so you shouldn't use them as column names but something else rather.
        $this->table('content_blocks', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'uuid', [
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('parent', 'string', [
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('display_name', 'string', [
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'null' => false,
            ])
            ->addColumn('hint', 'string', [
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('content_type', 'string', [
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('content_value', 'text', [
                'limit' => null,
                'null' => false,
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
