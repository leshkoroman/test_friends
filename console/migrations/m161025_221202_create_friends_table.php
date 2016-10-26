<?php

use yii\db\Migration;

/**
 * Handles the creation of table `friends`.
 */
class m161025_221202_create_friends_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('friends', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'friend_id' => $this->integer(),
            'confirmed' => $this->boolean(),
            'date_add' => $this->datetime(),
            'date_confirmed' => $this->datetime(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('friends');
    }
}
