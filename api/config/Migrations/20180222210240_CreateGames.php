<?php
use Migrations\AbstractMigration;

class CreateGames extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('games', ['id' => false, 'primary_key' => ['id']]);

        $table->addColumn('id', 'integer', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);

        $table->addColumn('platform_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('game_platform_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('platform_id', 'platforms', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

        $table->create();

    }
}
