<?php
ob_start();
session_start();
/*
 * Plugin Name: LTE Home Slider
 * Plugin URI: http://
 * Description: Opis
 * Version: 1.0
 * Author: Ja
 * Author URI: http://
 * License: GPL2
 */
require_once 'libs/LteHomeSliderModel.php';
require_once 'libs/Request.php';
require_once 'libs/LTEHomeSlider_SlideEntry.php';

class LteHomeSlider
{

	private static $pluginId = 'lte-home-slider';

	private $pluginVersion = '1.0.0';
	
	private $user_capability = 'edit_theme_options';
	private $model;
	
	private $action_token = 'lte-hs-action';

	public function __construct()
	{
		$this->model = new LteHomeSliderModel();
		// funckja co sie ma stać przy włączeniu wytczki wywołująca funkcje onActiwate
		register_activation_hook(__FILE__, array($this,'onActivate'));
		//rejestracja przycisku w menu
		add_action( 'admin_menu', array(&$this, 'createAdminMenu') );
		
// 		rejestracja skryptów w panelu admina
		add_action('admin_enqueue_scripts', array(&$this, 'addAdminPageScripts'));
		
		//rejestracja akcji ajax
		add_action('wp_ajax_checkValidPosition', array($this, 'checkValidPosition'));
		add_action('wp_ajax_getLastFreePosition', array($this, 'getLastFreePosition'));
		
		
		
	}
	
	public function checkValidPosition() 
	{
		$position = isset($_POST['position']) ? (int)$_POST['position']: 0;
		$message = '';
		
		if ($position < 1)
		{
			$message = 'Podana wartość jest niepoprawna. Pozycje musi być liczba większą od 0';
			
		}
		else 
		{
			if (!$this->model->isEmptyPosition($position))
			{
				$message = 'Dana pozycja jest już zajęta';
			}
			else 
			{
				$message = 'Ta pozycja jest wolna';
			}
			
		}
		echo $message;
		die;
	}
	
	public function getLastFreePosition() 
	{
		echo $this->model->getLastFreePosition();
		die;
	}
	
	
	public function addAdminPageScripts() 
	{
		wp_register_script('lte-hs-scripts', 
		plugins_url('/js/scripts.js', __FILE__,
		//po czym ma zostań załadowany skrypt
		array('jquery', 'media-upload', 'thickbox')));
		
		if (get_current_screen()->id == 'toplevel_page_'.static::$pluginId)
		{
			wp_enqueue_script('jquery');
			
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			
			wp_enqueue_script('media-upload');
			
			wp_enqueue_script('lte-hs-scripts');
		}
	}
	// funckcja co sie ma stac jak sie włączy plugin
	public function onActivate()
	{
		$verOpt = static::$pluginId . '-version';
		$installedVersion = get_option($verOpt, NULL);
		
		if ($installedVersion == NULL)
		{
			
			$this->model->createDbTable();
			update_option($verOpt, $this->pluginVersion);
		}
		else
		{
			switch (version_compare($installedVersion, $this->pluginVersion))
			{
				case 0:
				break;
				
				case 1:
				break;
				
				case -1:
				break;
			}
		}
	}
	
	public function createAdminMenu() 
	{
		add_menu_page(
			'LoveToEat-Home-Slider', 
			'LTE-Home-Slider', 
			$this->user_capability, 
			static::$pluginId, 
			array($this,'printAdminPage'));
	}
	
	//print admin page, iucluded request class
	public function printAdminPage() 
	{
		$request = Request::instance();
		
		$view = $request->getQuerySingleParam('view', 'index');
		$action = $request->getQuerySingleParam('action');
		$slideid = (int)$request->getQuerySingleParam('slideid');
		
		switch ($view)
		{
			case 'index':
				$this->redner('index');
				break;
				
			case 'form':
				
				if ($slideid > 0)
				{
					$SlideEntry = new LTEHomeSlider_SlideEntry($slideid);
					
					if (!$SlideEntry->exist() )
					{
						$this->setFlashMsg('Brak takiego wpisu w bazie danych', 'error');
						//przekieruje na index
						$this->redirect( $this->getAdminPanelUrl() );
					}
				}
				else 
				{
					$SlideEntry = new LTEHomeSlider_SlideEntry();
				}
				
				
				if ($action == 'save' && $request->isMethod('POST') && isset($_POST['entry']) )
				{
					if( check_admin_referer($this->action_token) )
					
					{
						$SlideEntry->setFields($_POST['entry']);
						if ($SlideEntry->validate())
						{
							
							$entry_id = $this->model->saveEntry($SlideEntry);
							
							if ($entry_id !== FALSE)
							{
								if ($SlideEntry->hasId())
								{
									$this->setFlashMsg('Poprawnie zmodyfikowano wpis');
								}
								else
								{
									$this->setFlashMsg('Poprawnie dodano nowy wpis');
								}
								$this->redirect( $this->getAdminPanelUrl( array('view' => 'form', 'slideid' => $entry_id) ) );
								
							}
							else
							{
								$this->setFlashMsg('Wystąpiły błędy z zapisem do bazy danych', 'error');
							}
						}
						else
						{
							$this->setFlashMsg('Popraw błędy formularza', 'error');
						}
					}
					else
					{
						$this->setFlashMsg('błędny toekn formularza', 'error');
					}
				}
				
				
				
				
				//przekazanie instancji klasy do widoku form
				$this->redner('form', array(
					'Slide' => $SlideEntry
				));
				break;
				
			default:
				$this->redner('404');
				break;
				
		}
		
	}
	
	
	//funkcja renderująca strone
	private function redner($view, array $args = array() ) 
	{
		//wyciaga zmienne
		extract($args);
		$tmpl_dir = plugin_dir_path(__FILE__).'templates/';
		
		$view = $tmpl_dir.$view.'.php';
		
		
		require_once $tmpl_dir.'layout.php';
	}
	
	
	//funkcja przekierowująca na strone wtyczki
	public function getAdminPanelUrl(array $params = array()) 
	{
		$admin_url = admin_url('admin.php?page='.static::$pluginId);
		$admin_url = add_query_arg($params, $admin_url);
		return $admin_url;
	}
	
	// wyświetlanie powodzenia dodania do bazy lub porażki
	
	public function setFlashMsg($message, $status = 'updated') 
	{
		// 
		$_SESSION[__CLASS__]['message'] = $message;
		$_SESSION[__CLASS__]['status'] = $status;
	}
	
	// pobiera z sesji parametry
	
	public function getFlashMsg() 
	{
		if ( isset( $_SESSION[__CLASS__]['message'] ) )
		{
			//pobiera wiadomość a później ją usówa, żeby się ciągle nie wyświetlała
			$msg = $_SESSION[__CLASS__]['message'];
			unset($_SESSION[__CLASS__]);
			return $msg;
		}
		return NULL;
	}
	
	
	// status wiadomości
	public function getFlashMsgStatus() 
	{
		if ( isset( $_SESSION[__CLASS__]['status'] ) )
		{
			//pobiera wiadomość a później ją usówa, żeby się ciągle nie wyświetlała
			
			return $_SESSION[__CLASS__]['status'];
		}
		return NULL;
	}
	
	// funkcja poinformuje czy wiadomość została ustawiona
	public function hasFlashMsg() 
	{
		return isset( $_SESSION[__CLASS__]['message'] );
	}
	
	public function redirect($location) 
	{
		wp_safe_redirect($location);
		exit;
	}
	
}

$LteHomeSlider = new LteHomeSlider();
ob_flush();
