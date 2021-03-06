<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Location', 'doctrine');

/**
 * BaseLocation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property bigint $location_id
 * @property string $location_name
 * @property Doctrine_Collection $Image
 * 
 * @method bigint              getLocationId()    Returns the current record's "location_id" value
 * @method string              getLocationName()  Returns the current record's "location_name" value
 * @method Doctrine_Collection getImage()         Returns the current record's "Image" collection
 * @method Location            setLocationId()    Sets the current record's "location_id" value
 * @method Location            setLocationName()  Sets the current record's "location_name" value
 * @method Location            setImage()         Sets the current record's "Image" collection
 * 
 * @package    nokia.lumia.v2
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLocation extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('co_location');
        $this->hasColumn('location_id', 'bigint', 20, array(
             'type' => 'bigint',
             'primary' => true,
             'autoincrement' => true,
             'length' => 20,
             ));
        $this->hasColumn('location_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Image', array(
             'local' => 'location_id',
             'foreign' => 'image_location'));
    }
}