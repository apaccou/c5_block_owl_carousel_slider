<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
/* C:\Users\Alexandre\Desktop\blocks\whale_nivo_slider\whale_nivo_slider\blocks\whale_nivo_slider/controller.php
/* C:\wamp\www\ofdt\packages\formigo_slider\blocks\formigo_slider/edit.php
/**
 * The controller for the OwlCarouselSlider block.
 *
 * @package Blocks
 * @subpackage OwlCarouselSlider
 * @author Alexandre PACCOU <a.paccou@coteo.com>
 * @copyright  Copyright (c) 2014 Owlgraphic (http://owlgraphic.com/owlcarousel) / Coteo (http://www.coteo.com).
 * @license    The MIT License (MIT)
 *
 */
class OwlCarouselSliderBlockController extends BlockController {

	protected $btTable = 'btOwlCarouselSlider';
	protected $btInterfaceWidth = "800";
	protected $btInterfaceHeight = "600";

	// Allow full caching
	// DEVNOTE: The cache may need to be cleared or the block resaved if file are changed.
	protected $btCacheBlockRecord = false;
	protected $btCacheBlockOutput = false;
	protected $btCacheBlockOutputOnPost = false;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;

	public $defaultItems = 1; /* int - This variable allows you to set the maximum amount of items displayed at a time with the widest browser width */
	public $defaultItemsScaleUp = false; /* boolean - Option to not stretch items when it is less than the supplied items. */
	public $defaultSlideSpeed = 200; /* int - Slide speed in milliseconds */
	public $defaultPaginationSpeed = 800; /* int - Pagination speed in milliseconds */
		public $defaultAutoPlay = false; /* int/boolean - Change to any integrer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds */
	public $defaultStopOnHover = false; /* boolean - Stop autoplay on mouse hover */
	public $defaultNavigation = false; /* boolean - Display "next" and "prev" buttons. */
		public $defaultNavigationText = array("prev","next"); /* array - You can customize your own text for navigation. To get empty buttons use navigationText : false. Also HTML can be used here */
	public $defaultScrollPerPage = false; /* boolean - Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging. */
	public $defaultPagination = true; /* boolean - Show pagination. */ 
	public $defaultPaginationNumbers = false; /* boolean - Show numbers inside pagination buttons */
		public $defaultTheme = 'owl-theme'; /* string - Default Owl CSS styles for navigation and buttons. Change it to match your own theme */
	public $defaultLazyLoad = false; /* boolean - Delays loading of images. Images outside of viewport won't be loaded before user scrolls to them. Great for mobile devices to speed up page loadings. IMG need special markup class="lazyOwl" and data-src="your img path". */
	public $defaultAutoHeight = false; /* boolean - Add height to owl-wrapper-outer so you can use different heights on slides. Use it only for one item per page setting. */
	public $defaulTransitionStyle = 'false'; /* string - Add CSS3 transition style: 'fade, backSlide, goDown, scaleUp'. Works only with one item on screen. */

	public $themes = array('owl-theme'); /* Ajouter ici manuellement les classes en plus des fichiers css dans /css ou de la feuille de style principale. Les fichiers css dans /css sont chargés de manière automatique. */
		public $playback = "ORDER";	

	/** 
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription() {
		return t("Touch enabled jQuery plugin that lets you create beautiful responsive carousel slider.");
	}
	
	public function getBlockTypeName() {
		return t("Owl Carousel Slider");
	}
		
	public function getJavaScriptStrings() {
		return array(
			'choose-file' => t('Choose Image/File'),
			'choose-min-2' => t('Please choose at least two images.'),
			'choose-fileset' => t('Please choose a file set.')
		);
	}
	
	function __construct($obj = null) {		
		parent::__construct($obj);

		$this->set('defaultItems', $this->defaultItems);
		$this->set('defaultItemsScaleUp', $this->defaultItemsScaleUp);
		$this->set('defaultSlideSpeed', $this->defaultSlideSpeed);
		$this->set('defaultPaginationSpeed', $this->defaultPaginationSpeed);
		$this->set('defaultAutoPlay', $this->defaultAutoPlay);
		$this->set('defaultStopOnHover', $this->defaultStopOnHover);
		$this->set('defaultNavigation', $this->defaultNavigation);
		$this->set('defaultNavigationText', $this->defaultNavigationText);
		$this->set('defaultScrollPerPage', $this->defaultScrollPerPage);
		$this->set('defaultPagination', $this->defaultPagination);
		$this->set('defaultPaginationNumbers', $this->defaultPaginationNumbers);
		$this->set('defaultTheme', $this->defaultTheme);
		$this->set('defaultLazyLoad', $this->defaultLazyLoad);
		$this->set('defaultAutoHeight', $this->defaultAutoHeight);
		$this->set('defaulTransitionStyle', $this->defaulTransitionStyle);

		$this->set('themes', $this->themes);

	}	

	function view() {
		$this->loadBlockInformation();
	}

	function add() {
		$this->loadBlockInformation();
	}
	
	function edit() {
		$this->loadBlockInformation();
	}

	function delete(){
		$db = Loader::db();
		$db->query("DELETE FROM btOwlCarouselSliderItems WHERE bID=".intval($this->bID));		
		parent::delete();
	}

	function duplicate($nbID) {
		parent::duplicate($nbID);
		$this->loadBlockInformation();
		$db = Loader::db();
		foreach($this->images as $im) {
			$db->Execute('insert into btOwlCarouselSliderItems (bID, fID, pageID, itemTitle, itemDesc, groupSet, position) values (?, ?, ?, ?, ?, ?, ?)', 
				array($nbID, $im['fID'], $im['pageID'],$im['itemTitle'],$im['itemDesc'], $im['groupSet'], $im['position'])
			);		
		}
	}

	function save($data) {

		$args['playback'] = isset($data['playback']) ? trim($data['playback']) : 'ORDER';		
			

		$args['items']  = (int)$data['items'];
		$args['itemsScaleUp']  = $data['itemsScaleUp'] ? 1 : 0;
		$args['slideSpeed']  = (int)$data['slideSpeed'];
		$args['paginationSpeed']  = (int)$data['paginationSpeed'];
		$args['autoPlay']  = (int)$data['autoPlay'];
		$args['stopOnHover']  = $data['stopOnHover'] ? 1 : 0;
		$args['navigation']  = $data['navigation'] ? 1 : 0;		
			$args['navigationText']  = serialize( array($data['navigationTextPrevious'],$data['navigationTextNext']) );
		$args['scrollPerPage']  = $data['scrollPerPage'] ? 1 : 0;
		$args['pagination']  = $data['pagination'] ? 1 : 0;
		$args['paginationNumbers']  = $data['paginationNumbers'] ? 1 : 0;
			$args['theme']  = (int)$data['theme'];
		$args['lazyLoad']  = $data['lazyLoad'] ? 1 : 0;
		$args['autoHeight']  = $data['autoHeight'] ? 1 : 0;
			$args['transitionStyle']  = $data['transitionStyle'];
		$db = Loader::db();
		
		if( $data['type'] == 'FILESET' && $data['fsID'] > 0){
			$args['fsID'] = $data['fsID'];
			
			$files = $db->getAll("SELECT fv.fID FROM FileSetFiles fsf, FileVersions fv WHERE fsf.fsID = " . $data['fsID'] .
			         " AND fsf.fID = fv.fID AND fvIsApproved = 1");
			
			//delete existing images
			$db->query("DELETE FROM btOwlCarouselSliderItems WHERE bID=".intval($this->bID));
		} else if( $data['type'] == 'CUSTOM' && count($data['imgFIDs']) ){
			$args['fsID'] = 0;
			$args['pageID'] = $data['pageID'];			
			$args['itemTitle'] = $data['itemTitle'];
			$args['itemDesc'] = $data['itemDesc'];
			
			
			//delete existing images
			$db->query("DELETE FROM btOwlCarouselSliderItems WHERE bID=".intval($this->bID));
			
			//loop through and add the images
			$pos=0;
			foreach($data['imgFIDs'] as $imgFID){ 
				if(intval($imgFID)==0 || $data['fileNames'][$pos]=='tempFilename') continue;
				$vals = array(intval($this->bID),intval($imgFID), intval($data['pageID'][$pos]),
						trim($data['itemTitle'][$pos]),trim($data['itemDesc'][$pos]),
						intval($data['groupSet'][$pos]),$pos);
				$db->query("INSERT INTO btOwlCarouselSliderItems (bID,fID,pageID,itemTitle,itemDesc,groupSet,position) values (?,?,?,?,?,?,?)",$vals);
				$pos++;
			}
		}
		
		parent::save($args);
	}

	function getFileSetName(){
		$sql = "SELECT fsName FROM FileSets WHERE fsID=".intval($this->fsID);
		$db = Loader::db();
		return $db->getOne($sql); 
	}

	function loadFileSet(){
		if (intval($this->fsID) < 1) {
			return false;
		}
        Loader::helper('concrete/file');
		Loader::model('file_attributes');
		Loader::library('file/types');
		Loader::model('file_list');
		Loader::model('file_set');
		
		$ak = FileAttributeKey::getByHandle('height');

		$fs = FileSet::getByID($this->fsID);
		$fileList = new FileList();		
		$fileList->filterBySet($fs);
		$fileList->filterByType(FileType::T_IMAGE);	
		$fileList->sortByFileSetDisplayOrder();
		
		$files = $fileList->get(1000,0);
		
		
		$image = array();
		
		$image['pageID'] = $this->pageID;
		$image['itemTitle'] = $this->itemTitle;
		$image['itemDesc'] = $this->itemDesc;
		$image['groupSet'] = 0;
		$images = array();
		$maxHeight = 0;
		foreach ($files as $f) {
			$fp = new Permissions($f);
			if(!$fp->canRead()) { continue; }
			$image['fID'] 			= $f->getFileID();
			$image['fileName'] 		= $f->getFileName();
			$image['fullFilePath'] 	= $f->getPath();
			
			// find the max height of all the images so slideshow doesn't bounce around while rotating
			$vo = $f->getAttributeValueObject($ak);
			if (is_object($vo)) {
				$image['imgHeight'] = $vo->getValue('height');
			}
			if ($maxHeight == 0 || $image['imgHeight'] > $maxHeight) {
				$maxHeight = $image['imgHeight'];
			}
			$images[] = $image;
		}
		$this->images = $images;
	
	}

	function loadImages(){
		if(intval($this->bID)==0) $this->images=array();
		$sortChoices=array('ORDER'=>'position','RANDOM-SET'=>'groupSet asc, position asc','RANDOM'=>'rand()');
		if( !array_key_exists($this->playback,$sortChoices) ) 
			$this->playback='ORDER';
		if(intval($this->bID)==0) return array();
		$sql = "SELECT * FROM btOwlCarouselSliderItems WHERE bID=".intval($this->bID).' ORDER BY '.$sortChoices[$this->playback];
		$db = Loader::db();
		$this->images=$db->getAll($sql); 
	}
	

	
	function loadBlockInformation() {
		if ($this->fsID == 0) {
			$this->loadImages();
		} else {
			$this->loadFileSet();
		}
		$this->randomizeImages();		

		$this->set('pageID', $this->pageID);
		$this->set('itemTitle', $this->itemTitle);
		$this->set('itemDesc', $this->itemDesc);
		$this->set('minHeight', $this->minHeight);
		$this->set('fsID', $this->fsID);
		$this->set('fsName', $this->getFileSetName());
		$this->set('images', $this->images);
		$this->set('playback', $this->playback);
		$type = ($this->fsID > 0) ? 'FILESET' : 'CUSTOM';
		$this->set('type', $type);
		$this->set('bID', $this->bID);				
	}
	

	

	
	
	
	function randomizeImages()
	{
		if($this->playback == 'RANDOM')
		{
			shuffle($this->images);
		}
		else if($this->playback == 'RANDOM-SET')
		{
			$imageGroups=array();
			$imageGroupIds=array();
			$sortedImgs=array();
			foreach($this->images as $imgInfo){
				$imageGroups[$imgInfo['groupSet']][]=$imgInfo;
				if( !in_array($imgInfo['groupSet'],$imageGroupIds) )
					$imageGroupIds[]=$imgInfo['groupSet'];
			}
			shuffle($imageGroupIds);
			foreach($imageGroupIds as $imageGroupId){
				foreach($imageGroups[$imageGroupId] as $imgInfo)
					$sortedImgs[]=$imgInfo;
			}
			$this->images=$sortedImgs;
		}
	}
}

?>
