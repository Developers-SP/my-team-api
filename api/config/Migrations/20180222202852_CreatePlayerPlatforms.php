<?php
use Migrations\AbstractMigration;

class CreatePlayerPlatforms extends AbstractMigration
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
        $table = $this->table('player_platforms', ['id' => false, 'primary_key' => ['player_platform_id', 'player_id','platform_id']]);

        $table->addColumn('player_platform_id', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ]);

        $table->addColumn('player_id', 'integer', [
            'default' => null,            
            'null' => false,
        ]);

        $table->addColumn('platform_id', 'integer', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('nickname', 'string', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('player_id', 'players', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

        $table->addForeignKey('platform_id', 'platforms', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE']);

        $table->create();
    }
}
