<?php
namespace DN\Dnexponatsliste\Files;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Daniel Nemanic <daniel@nemanic.eu>
 *
 ***************************************************************/
/**
 * FileHandler
 *
 * @package Projectlist\Projectlist\Files
 */
class FileHandler
{
  /**
   * filePath
   *
   * @var string
   */
  protected $filePath = '';
  /**
   * listElement
   *
   * @var string
   */
  protected $listElement = '';
  /**
   * pid
   *
   * @var string
   */
  protected $pid = '';
  /**
   * errorMessage
   *
   * @var string
   */
  protected $errorMessage = '';
  /**
   * fileFormats
   */
  protected $excludedFileFormats = [
      'js', 'php', 'html', 'htm', 'css', 'sql',
  ];

  /**
   * @param string $filePath
   */
  public function __construct( $storageUID ){
    $storage = new \TYPO3\CMS\Core\Resource\StorageRepository();
    $filePath = $storage->findByUid($storageUID)->getConfiguration()['basePath'] .'/' ;

    $check = substr( $filePath, -1 );
    if( $check == '/' ) {
			$this->filePath = substr( $filePath, 0, -1 );
    } else {
			$this->filePath = $filePath;
    }
  }
  /**
   * @return string
   */
  public function getFilePath()
  {
		return $this->filePath;
  }

  /**
   * @param string $listElement
   */
  public function setListeElement( $listeElement ){
    $this->listElement = $listeElement;

    $this->createFileFolder() ;
  }

  /**
   * @return mixed
   */
  public function getPID()
  {
    return $this->pid;
  }

  /**
   * @param mixed $projectID
   */
  public function setPID($pid)
  {
    $this->pid = $pid;
  }

  public function getFiles(){
    $folder = $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid .'/'. $this->listElement;
    if( dir( $folder ) ) {
      $verz = opendir ( $folder );
      while ($file = readdir ( $verz )) {
        if(	$file != "." &&
            $file != ".." &&
            !is_file( $file ) ) {

					$files[] = [ 'Name' => $file, 'Path' => '/' . $this->filePath .'/'. $this->pid .'/'. $this->listElement .'/'. $file ];
        }
      }
      closedir($verz);
    }
    return $files;
  }

  public function uploadFiles( $Files ) {
    if( $this->pid && !empty( $Files['name']['file'][$this->listElement] ) ){
      $folder = $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid .'/'. $this->listElement;
      $targetName = $folder .'/'. $this->checkUmlaute( $Files['name']['file'][$this->listElement] );
      $targetTemp = $Files['tmp_name']['file'][$this->listElement];

      if( $this->checkFile( $Files['name']['file'][$this->listElement] ) ) {
        if( $this->moveFiles( $targetTemp, $targetName ) ) {
            $this->errorMessage = true;
        } else {
            $this->errorMessage = false;
        }
      }
    }
  }
  protected function moveFiles( $tmp, $target ){
    if( move_uploaded_file( $tmp, $target ) ) {
			return true;
    } else{
			return false;
    }
  }
  protected function checkUmlaute( $name ) {
    $search = ["ä", "ö", "ü", "ß", "Ä", "Ö",
        "Ü", "&", "é", "á", "ó",
        " :)", " :D", " :-)", " :P",
        " :O", " ;D", " ;)", " ^^",
        " :|", " :-/", ":)", ":D",
        ":-)", ":P", ":O", ";D", ";)",
        "^^", ":|", ":-/", "(", ")", "[", "]",
        "<", ">", "!", "\"", "§", "$", "%", "&",
        "/", "(", ")", "=", "?", "`", "´", "*", "'",
        ":", ";", "²", "³", "{", "}",
        "\\", "~", "#", "+",",",
        "=", ":", "=)", " "];
    $replace = ["ae", "oe", "ue", "ss", "Ae", "Oe",
        "Ue", "und", "e", "a", "o", "", "",
        "", "", "", "", "", "", "", "", "",
        "", "", "", "", "", "", "", "", "",
        "", "", "", "", "", "", "", "", "",
        "", "", "", "", "", "", "", "",
        "", "", "", "", "", "", "", "", "",
        "", "", "", "", "", "", "", "", "", "_"];
    $str = str_replace($search, $replace, $name);
    return  $str;
  }
  protected function checkFile( $targetName ){
    $fileFormat = explode( ".", $targetName );
    $fileFormat = array_reverse( $fileFormat );

    if( !in_array($fileFormat[0], $this->excludedFileFormats) )
		{
			return true;
		}

    return false;
  }
  public function deleteFileFolder( $extra = '' ){
    if( $this->pid ){
      $folder = $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid . $extra ;
      if( dir( $folder ) ) {
        $verz = opendir ( $folder );
        while ($file = readdir ( $verz )) {
          if(	$file != "." &&
              $file != ".." ) {
            if( is_dir($folder .'/'. $file) ) {
							$this->deleteFileFolder( '/'. $file );
            } else {
							unlink( $folder .'/'. $file );
            }
          }
        }
        closedir($verz);

        rmdir( $folder .'/' );
      }
    }
  }
  public function getErrorMessage() {
		return $this->errorMessage;
  }
  public function deleteFile( $name ) {
    $folder = $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid .'/'. $this->listElement;
    if( file_exists( $folder .'/'. $name ) ){
      if( unlink( $folder .'/'. $name ) ) {
				$this->errorMessage = true;
      } else {
				$this->errorMessage = false;
      }
    } else {
			$this->errorMessage = false;
    }
  }
  public function createFileFolder(){
    if( !file_exists( $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath ) )
		{
			if (!mkdir($concurrentDirectory = $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath) && !is_dir($concurrentDirectory)) { throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory)); }
		}

    if( !file_exists( $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid ) && $this->pid )
		{
			if (!mkdir($concurrentDirectory = $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid) && !is_dir($concurrentDirectory)) { throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory)); }
		}

		if( !file_exists( $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid .'/'. $this->listElement ) && $this->listElement  )
		{
			if (!mkdir($concurrentDirectory = $_SERVER['DOCUMENT_ROOT'] .'/'. $this->filePath .'/'. $this->pid .'/'. $this->listElement) && !is_dir($concurrentDirectory)) { throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory)); }
		}

  }
} 