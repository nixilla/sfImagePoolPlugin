<?php

/**
 * PluginsfImagePoolImageTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginsfImagePoolImageTable extends Doctrine_Table
{
  /**
   * Returns an instance of this class.
   *
   * @return object PluginsfImagePoolImageTable
   */
  public static function getInstance()
  {
      return Doctrine_Core::getTable('PluginsfImagePoolImage');
  }
  
  /**
   * Fetch images from pool according to any default tag(s) option specified 
   * in the global schema.yml.
   * Override added to specify per tag in MooEditable
   * 
   * @return sfDoctrinePager
   */
  public function getPager($per_page = 12, $page = 1, $tagged_object = null, $tag = null)
  {
      $pager = new sfDoctrinePager($this->getClassnameToReturn(), $per_page);
      
      $im = new sfImagePoolImage();
      
      if(!$im->option('tagging'))
      {
        $tagged_object = $tag = null;
      }
      
      $im->free(true);
      
      if (isset($tagged_object) && $tag = $tagged_object->getTagRestriction()) 
      {
        $query = TagTable::getObjectTaggedWithQuery(
            $this->getClassnameToReturn(),
            $tag,
            $pager->getQuery(),
            array('nb_common_tags'=>1)
        );
        
        $pager->setQuery($query);
      }
      else if (!empty($tag)) 
      {
        // If only tags we have no taggable object
        // So get images tagged with this query and do a whereIn on the ids
        $tags = explode(',', $tag);
        $images = TagTable::getObjectTaggedWith($tags, array('model' => 'sfImagePoolImage', 'nb_common_tags'=>1));
        $image_ids = array();   

        foreach ($images as $image) 
        {
          $image_ids[] = $image->id;
        }
        
        if (!empty($image_ids)) 
        {
          $pager->getQuery()->whereIn('sfImagePoolImage.id', $image_ids);
        }
        else $pager->getQuery()->where('false'); // we have no images tagged
      }
      
      $pager->getQuery()->orderBy('updated_at DESC');
      $pager->setPage($page);
      $pager->init();
      
      return $pager;
  }
  
  /**
   * Get images by ids
   * 
   * @param array $image_ids
   */
  public function getByIds($image_ids)
  {
    return $this->getByIdsQuery($image_ids)->execute();
  }
  
  /**
   * Get query for getByIds()
   * 
   * @param array $image_ids
   */
  public function getByIdsQuery($image_ids)
  {
    // Fix for empty image id
    foreach ($image_ids as $idx => $image_id) {
      if (empty($image_id)) unset($image_ids[$idx]);
    }
    
    return $this->createQuery('i')
                ->whereIn('i.id', $image_ids);
  }
}