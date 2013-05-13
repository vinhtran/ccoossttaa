<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Fbusers', 'doctrine');

/**
 * BaseFbusers
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $fbuser_id
 * @property string $fbuser_email
 * @property string $fbuser_first_name
 * @property string $fbuser_last_name
 * @property string $fbuser_data
 * @property timestamp $created_date
 * @property timestamp $modified_date
 * @property Doctrine_Collection $Codes
 * @property Doctrine_Collection $Invitations
 * @property Doctrine_Collection $Invitations_2
 * @property Doctrine_Collection $Winners
 * @property Doctrine_Collection $WinnersInformation
 * 
 * @method string              getFbuserId()           Returns the current record's "fbuser_id" value
 * @method string              getFbuserEmail()        Returns the current record's "fbuser_email" value
 * @method string              getFbuserFirstName()    Returns the current record's "fbuser_first_name" value
 * @method string              getFbuserLastName()     Returns the current record's "fbuser_last_name" value
 * @method string              getFbuserData()         Returns the current record's "fbuser_data" value
 * @method timestamp           getCreatedDate()        Returns the current record's "created_date" value
 * @method timestamp           getModifiedDate()       Returns the current record's "modified_date" value
 * @method Doctrine_Collection getCodes()              Returns the current record's "Codes" collection
 * @method Doctrine_Collection getInvitations()        Returns the current record's "Invitations" collection
 * @method Doctrine_Collection getInvitations2()       Returns the current record's "Invitations_2" collection
 * @method Doctrine_Collection getWinners()            Returns the current record's "Winners" collection
 * @method Doctrine_Collection getWinnersInformation() Returns the current record's "WinnersInformation" collection
 * @method Fbusers             setFbuserId()           Sets the current record's "fbuser_id" value
 * @method Fbusers             setFbuserEmail()        Sets the current record's "fbuser_email" value
 * @method Fbusers             setFbuserFirstName()    Sets the current record's "fbuser_first_name" value
 * @method Fbusers             setFbuserLastName()     Sets the current record's "fbuser_last_name" value
 * @method Fbusers             setFbuserData()         Sets the current record's "fbuser_data" value
 * @method Fbusers             setCreatedDate()        Sets the current record's "created_date" value
 * @method Fbusers             setModifiedDate()       Sets the current record's "modified_date" value
 * @method Fbusers             setCodes()              Sets the current record's "Codes" collection
 * @method Fbusers             setInvitations()        Sets the current record's "Invitations" collection
 * @method Fbusers             setInvitations2()       Sets the current record's "Invitations_2" collection
 * @method Fbusers             setWinners()            Sets the current record's "Winners" collection
 * @method Fbusers             setWinnersInformation() Sets the current record's "WinnersInformation" collection
 * 
 * @package    nokia_facebook
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFbusers extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('nf_fbusers');
        $this->hasColumn('fbuser_id', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('fbuser_email', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('fbuser_first_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('fbuser_last_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 255,
             ));
        $this->hasColumn('fbuser_data', 'string', null, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('created_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
        $this->hasColumn('modified_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 25,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Codes', array(
             'local' => 'fbuser_id',
             'foreign' => 'fbuser_id'));

        $this->hasMany('Invitations', array(
             'local' => 'fbuser_id',
             'foreign' => 'invitee_id'));

        $this->hasMany('Invitations as Invitations_2', array(
             'local' => 'fbuser_id',
             'foreign' => 'inviter_id'));

        $this->hasMany('Winners', array(
             'local' => 'fbuser_id',
             'foreign' => 'fbuser_id'));

        $this->hasMany('WinnersInformation', array(
             'local' => 'fbuser_id',
             'foreign' => 'fbuser_id'));
    }
}