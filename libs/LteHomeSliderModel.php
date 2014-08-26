<?php

class LteHomeSliderModel
{
	private $tableName = 'lte_home_slider';
	private $wpdb;
	
	
	public function __construct()
	{
		global $wpdb;
		$this->wpdb = $wpdb;
	}
	
	
	/**
	 * @return string
	 * @description zwraca nazwe tabeli do utworzenia
	 */
	public function getTableName() 
	{
		
		return $this->wpdb->prefix.$this->tableName;
	}
	
	public function createDbTable() 
	{
		
		$tableName = $this->getTableName();
		$sql = '
			CREATE TABLE IF NOT EXISTS '.$tableName.'(
				id INT NOT NULL AUTO_INCREMENT,
				slide_url VARCHAR(255) NOT NULL,
				title VARCHAR(255) NOT NULL,
				caption VARCHAR(255) DEFAULT NULL,
				read_more_url VARCHAR(255) DEFAULT NULL,
				position INT NOT NULL,
				published enum("yes", "no") NOT NULL DEFAULT "yes",
				PRIMARY KEY(id)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8';
		
		require_once ABSPATH.'wp-admin/includes/upgrade.php';
		dbDelta($sql);
	}
	
	public function isEmptyPosition($position) 
	{
		$position = (int)$position;
		$table_name = $this->getTableName();
		
		$sql = "SELECT COUNT(*) FROM {$table_name} WHERE position = %d";
		$prop = $this->wpdb->prepare($sql, $position);
		
		$count = (int)$this->wpdb->get_var($prop);
		
		return ($count < 1);
	}
	
	public function getLastFreePosition()
	{
		$table_name = $this->getTableName();
		$sql = "SELECT MAX(position) FROM {$table_name}";
		
		
		
		$pos = (int)$this->wpdb->get_var($sql);
		
		return ($pos+1);
		
	}
	
	// przekazanie instancji klasy
	public function saveEntry(LTEHomeSlider_SlideEntry $entry)
	{
		// tablica danych do zapisania
		$toSave = array(
			'slide_url' => $entry->getField('slide_url'),
			'title' => $entry->getField('title'),
			'caption' => $entry->getField('caption'),
			'read_more_url' => $entry->getField('read_more_url'),
			'position' => $entry->getField('position'),
			'published' => $entry->getField('published'),
		);
		//mapowanie %s - string, %d - integer
		$maps = array('%s', '%s', '%s', '%s', '%d', '%s');
		$table_name = $this->getTableName();
		
		if ($entry->hasId() )
		{
			if ($this->wpdb->update($table_name, $toSave, array('id' => $entry->getField('id') ), $maps, '%d' ))
			{
				return $entry->getField('id');
			}
		}
		else 
		{
			if($this->wpdb->insert($table_name, $toSave, $maps) )
			{
				
				return $this->wpdb->insert_id;
				
			}
			else 
			{
				return FALSE;
			}
		}

		
		

	
	}
	
	function fetchRow($id) 
	{
		$table_name = $this->getTableName();
		$sql = "SELECT * FROM {$table_name} WHERE id = %d";
		$prep = $this->wpdb->prepare($sql, $id);
		return $this->wpdb->get_row($prep);
	}
	
	
	
	
	
	
	
	
	
}