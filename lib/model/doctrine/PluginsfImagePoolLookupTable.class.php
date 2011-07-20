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
     * Delete associated images for given object.
     */
    public static function removeImages($object)
    {
        return Doctrine_Query::create()
          ->delete()
          ->from('sfImagePoolLookup')
          ->where('imaged_model_id = ?', $object['id'])
          ->andWhere('imaged_model = ?', get_class($object))
          ->execute();
    }
    
    public function getModelCount($class, $id)
    {
      return $this->createQuery()
                  ->where('imaged_model = ? AND sf_image_id = ?', array($class, $id))
                  ->count();
    }
}