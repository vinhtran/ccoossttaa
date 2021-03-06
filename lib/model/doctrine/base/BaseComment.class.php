<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Comment', 'doctrine');

/**
 * BaseComment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property bigint $comment_id
 * @property boolean $comment_status
 * @property timestamp $comment_date
 * @property bigint $comment_image
 * @property bigint $comment_fbuser
 * @property Fbusers $Fbusers
 * @property Image $Image
 * 
 * @method bigint    getCommentId()      Returns the current record's "comment_id" value
 * @method boolean   getCommentStatus()  Returns the current record's "comment_status" value
 * @method timestamp getCommentDate()    Returns the current record's "comment_date" value
 * @method bigint    getCommentImage()   Returns the current record's "comment_image" value
 * @method bigint    getCommentFbuser()  Returns the current record's "comment_fbuser" value
 * @method Fbusers   getFbusers()        Returns the current record's "Fbusers" value
 * @method Image     getImage()          Returns the current record's "Image" value
 * @method Comment   setCommentId()      Sets the current record's "comment_id" value
 * @method Comment   setCommentStatus()  Sets the current record's "comment_status" value
 * @method Comment   setCommentDate()    Sets the current record's "comment_date" value
 * @method Comment   setCommentImage()   Sets the current record's "comment_image" value
 * @method Comment   setCommentFbuser()  Sets the current record's "comment_fbuser" value
 * @method Comment   setFbusers()        Sets the current record's "Fbusers" value
 * @method Comment   setImage()          Sets the current record's "Image" value
 * 
 * @package    nokia.lumia.v2
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseComment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('co_comment');
        $this->hasColumn('comment_id', 'bigint', 20, array(
             'type' => 'bigint',
             'primary' => true,
             'autoincrement' => true,
             'length' => 20,
             ));
        $this->hasColumn('comment_status', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('comment_date', 'timestamp', 25, array(
             'type' => 'timestamp',
             'notnull' => false,
             'length' => 25,
             ));
        $this->hasColumn('comment_image', 'bigint', 20, array(
             'type' => 'bigint',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('comment_fbuser', 'bigint', 20, array(
             'type' => 'bigint',
             'notnull' => true,
             'length' => 20,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Fbusers', array(
             'local' => 'comment_fbuser',
             'foreign' => 'user_id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Image', array(
             'local' => 'comment_image',
             'foreign' => 'image_id',
             'onDelete' => 'CASCADE'));
    }
}