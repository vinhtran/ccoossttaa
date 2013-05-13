<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('WinnersInformation', 'doctrine');

/**
 * BaseWinnersInformation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $fbuser_id
 * @property integer $award_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property string $mailing_address
 * @property string $zip_code
 * @property timestamp $created_date
 * @property timestamp $modified_date
 * @property Awards $Awards
 * @property Fbusers $Fbusers
 * 
 * @method string             getFbuserId()        Returns the current record's "fbuser_id" value
 * @method integer            getAwardId()         Returns the current record's "award_id" value
 * @method string             getFirstName()       Returns the current record's "first_name" value
 * @method string             getLastName()        Returns the current record's "last_name" value
 * @method string             getEmailAddress()    Returns the current record's "email_address" value
 * @method string             getMailingAddress()  Returns the current record's "mailing_address" value
 * @method string             getZipCode()         Returns the current record's "zip_code" value
 * @method timestamp          getCreatedDate()     Returns the current record's "created_date" value
 * @method timestamp          getModifiedDate()    Returns the current record's "modified_date" value
 * @method Awards             getAwards()          Returns the current record's "Awards" value
 * @method Fbusers            getFbusers()         Returns the current record's "Fbusers" value
 * @method WinnersInformation setFbuserId()        Sets the current record's "fbuser_id" value
 * @method WinnersInformation setAwardId()         Sets the current record's "award_id" value
 * @method WinnersInformation setFirstName()       Sets the current record's "first_name" value
 * @method WinnersInformation setLastName()        Sets the current record's "last_name" value
 * @method WinnersInformation setEmailAddress()    Sets the current record's "email_address" value
 * @method WinnersInformation setMailingAddress()  Sets the current record's "mailing_address" value
 * @method WinnersInformation setZipCode()         Sets the current record's "zip_code" value
 * @method WinnersInformation setCreatedDate()     Sets the current record's "created_date" value
 * @method WinnersInformation setModifiedDate()    Sets the current record's "modified_date" value
 * @method WinnersInformation setAwards()          Sets the current record's "Awards" value
 * @method WinnersInformation setFbusers()         Sets the current record's "Fbusers" value
 * 
 * @package    nokia_facebook
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseWinnersInformation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('nf_winners_information');
        $this->hasColumn('fbuser_id', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('award_id', 'integer', 8, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => false,
             'length' => 8,
             ));
        $this->hasColumn('first_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('last_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('email_address', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('mailing_address', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('zip_code', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('created_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('modified_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Awards', array(
             'local' => 'award_id',
             'foreign' => 'id'));

        $this->hasOne('Fbusers', array(
             'local' => 'fbuser_id',
             'foreign' => 'fbuser_id'));
    }
}