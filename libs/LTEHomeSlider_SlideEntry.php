<?php

class LTEHomeSlider_SlideEntry
{

	private $id = NULL;

	private $slide_url = NULL;

	private $title = NULL;

	private $caption = NULL;

	private $read_more_url = NULL;

	private $position = NULL;

	private $published = 'yes';

	private $errors = array();
	
	private $exist = FALSE;
	
	function __construct($id = NULL)
	{
		$this->id = $id;
		$this->load();
	}
	
	private function load() 
	{
		if (isset($this->id))
		{
			$Model = new LteHomeSliderModel();
			$row = $Model->fetchRow($this->id);
			if (isset( $row ) )
			{
				$this->setFields($row);
				$this->exist = TRUE;
			}
		}
	}
	
	public function exist() 
	{
		return $this->exist;
	}
	
	
	// getter dla pol wyzej
	public function getField($field)
	{
		if (isset($this->{$field}))
		{
			return $this->{$field};
		}
		return NULL;
	}
	
	function hasId() 
	{
		return isset($this->id);
	}
	
	//spdawdza checkboxa published czy jest tak czy nie
	public function isPublished() 
	{
		return $this->published == 'yes';
	}
	// setter dla pol wyzej
	public function setFields($fields)
	{
		foreach ($fields as $key => $val)
		{
			$this->{$key} = $val;
		}
	}

	public function setError($field, $error)
	{
		$this->errors[$field] = $error;
	}

	public function getError($field)
	{
		if (isset($this->errors[$field]))
		{
			return $this->errors[$field];
		}
		return NULL;
	}

	public function hasError($field)
	{
		return isset($this->errors[$field] );
	}

	public function hasErrors()
	{
		return (count($this->errors) > 0);
	}

	/**
	 * VALIDACJA FORMULARZA
	 */
	public function validate()
	{
		
		/*
		 * POLE SLIDE URL
		 */
		// jeślu puste to :
		if (empty($this->slide_url))
		{
			$this->setError('slide_url', 'To pole nie może być puste');
		}
		// jeśli nie puste to
		else
		{
			// jeśli nie jest url to:
			if (! filter_var($this->slide_url, FILTER_VALIDATE_URL))
			{
				$this->setError('slide_url', 'to pole musi być poprawnym adresem url');
			}
			// jeśli jest url to
			else
			{
				// jeśli ma wiecej niż 255 znaków to
				if (strlen($this->slide_url) > 255)
				{
					$this->setError('slide_url', 'to pole nie może przekroaczać 255 znaków');
				}
			}
		}
		
		
		/*
		 * POLE TITLE
		 */
		
		if (empty($this->title))
		{
			$this->setError('title', 'To pole nie może być puste');
		}
		// jeśli nie puste to
		else
		{
			// jeśli ma wiecej niż 255 znaków to
			if (strlen($this->title) > 255)
			{
				$this->setError('title', 'to pole nie może przekroaczać 255 znaków');
			}
		}
		
		/*
		 * POLE CAPTION
		 */
		
		if (!empty($this->caption))
		{
			$allowed_html = array(
				'strong' => array(),
				'b' => array()
			);
			// funkcja wordpressam oczyszcza string z niedozwolonych znaków, zostawaijąc tylko to z tablicy $allowed_html
			$this->caption = wp_kses($this->caption, $allowed_html);
			
			if (strlen($this->caption) > 255)
			{
				$this->setError('caption', 'to pole nie może przekroaczać 255 znaków');
			}
		}
		
		/*
		 * POLE READ_MORE_URL
		 */
		
		if (!empty($this->read_more_url))
		{
			// oczyszczenie urla z niebezpiecznych znaków
			$this->read_more_url = esc_url($this->read_more_url);
			
			if (strlen($this->read_more_url) > 255)
			{
				$this->setError('read_more_url', 'to pole nie może przekroaczać 255 znaków');
			}
		}
		
		/*
		 * POLE POSITION
		 */
		if (empty($this->position ))
		{
			$this->setError('position', 'To pole nie może być puste.');
		}
		else 
		{
			$this->position = (int)$this->position;
			if ($this->position < 1)
			{
				$this->setError('position', 'To pole musi być liczbą większą od 0');
			}
		}
		
		
		
		/*
		 * POLE PUBLISHED
		 */
		
		if (isset($this->published) && $this->published == 'yes')
		{
			$this->published == 'yes';
		}
		else 
		{
			$this->published = 'no';
		}
		
		return (!$this->hasErrors() );
		
		
	}

}