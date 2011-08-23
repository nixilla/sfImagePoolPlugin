<?php

/**
 * PluginsfImagePoolLookupTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginsfImagePoolLookupTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginsfImagePoolLookupTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('PluginsfImagePoolLookup');
  }
  
  /**
   * Get associated images for a given object
   * 
   * @param object $object
   */
  public function getImages($object, $hydrationMode = null)
  {
    return $this->createQuery('l')
                ->select('DISTINCT l.sf_image_id')
                ->where('l.imaged_model_id = ?', $object['id'])
                ->andWhere('l.imaged_model = ?', get_class($object))
                ->execute(array(), $hydrationMode);
  }
  
  /**
   * Delete associated images for a given object.
   * 
   * @param object $object
   */
  public function removeImages($object)
  {
    return $this->createQuery('i')
                ->delete()
                ->where('i.imaged_model_id = ?', $object['id'])
                ->andWhere('i.imaged_model = ?', get_class($object))
                ->execute();
  }
  
  /**
   * Get number of images associated with a model class
   * 
   * @param string $class
   * @param int $id
   */
  public function getModelCount($class, $id)
  {
    return $this->createQuery()
                ->where('imaged_model = ? AND sf_image_id = ?', array($class, $id))
                ->count();
  }
}