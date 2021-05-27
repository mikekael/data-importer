<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;
use LaravelDoctrine\Migrations\Schema\Table;
use LaravelDoctrine\Migrations\Schema\Builder;

class Version20210526135041 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        (new Builder($schema))->create('customers', function (Table $table) {
            // column length reference https://kitefaster.com/2017/05/03/maximum-string-length-popular-database-fields/
            $table->guid('id');
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('email');
            $table->string('username', 32);
            $table->string('password', 32);
            $table->string('gender', 10);
            $table->string('country', 90);
            $table->string('city', 189);
            $table->string('phone', 20);

            // constraints
            $table->primary('id');
            $table->unique('id');
            $table->unique('email');
        });
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        (new Builder($schema))->drop('customers');
    }
}
