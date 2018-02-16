<?php
use Migrations\AbstractMigration;

class CreateTeamPlayers extends AbstractMigration
{

    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('team_players', ['id' => false, 'primary_key' => ['team_id','player_id']]);
        $table->addColumn('team_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('player_id', 'string', [
            'default' => null,
            'limit' => 255,
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
        $table->addColumn('is_owner','boolean', [
            'default' => false,
            'null' => false,
            ]);

        $table->addColumn('is_captain','boolean', [
            'default' => false,
            'null' => false,
            ]);

        $table->addForeignKey('team_id', 'teams', ['id'],
                            ['constraint'=>'team_id_idx']);       

        $table->addForeignKey('player_id', 'players', ['id'],
                            ['constraint'=>'player_id_idx']); 

        $table->create();
    }
}
