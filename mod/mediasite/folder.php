<?php

namespace Sonicfoundry;
use Sonicfoundry\EDAS as EDAS;

require_once(dirname(__FILE__) . '/../../config.php');

global $CFG;

require_once("$CFG->dirroot/mod/mediasite/utility.php");

/**
 * Class Folder
 * @package Sonicfoundry
 */
class Folder {
    /**
     * @param null|\stdClass $json
     */
    function __construct($json = null) {
        if(!is_null($json))
        {
            if($json instanceof EDAS\FolderDetails) {
                $this->Id = $json->Id;
                $this->Name = $json->Name;
                $this->Owner = $json->Owner;
                $this->Description = $json->Description;
                $this->CreationDate = $json->CreationDate;
                $this->LastModified = $json->LastModified;
                $this->ParentFolderId = $json->ParentId;
                $this->Recycled = $json->Recycled;
                $this->Type = $json->Type;
            } else {
                $this->Presentations = $json->{'Presentations@odata.navigationLinkUrl'};
                $this->Id = $json->Id;
                $this->Name = $json->Name;
                $this->Owner = $json->Owner;
                $this->Description = $json->Description;
                $this->CreationDate = $json->CreationDate;
                $this->LastModified = $json->LastModified;
                $this->ParentFolderId = $json->ParentFolderId;
                $this->Recycled = $json->Recycled;
                $this->Type = $json->Type;
            }
        }
    }

    /**
     * @return \stdClass
     */
    public function DatabaseRecord() {
        $record = new \stdClass();
        $record->resourceid = $this->Id;
        $record->name = $this->Name;
        $record->owner = $this->Owner;
        $record->description = $this->Description;
        $record->creationdate = $this->CreationDate;
        $record->lastmodified = $this->LastModified;
        $record->parentfolderid = $this->ParentFolderId;
        $record->recycled = $this->Recycled;
        $record->type = $this->Type;
        return $record;
    }
    private static function FolderMerge($folder, $group, $root, &$temp) {
        $temp[] = $folder;
        if(array_key_exists($folder->Id, $group)) {
            foreach($group[$folder->Id] as $child) {
                self::FolderMerge($child, $group, $root, $temp);
            }
        }
    }
    public static function FolderArrayHierarchy(&$array) {
        if(!is_array($array) || count($array) < 2) {
            throw new SonicfoundryException('FolderArrayHierarchy: Argument must be an array', SonicfoundryException::INVALID_ARGUMENT);
        }
        if(!$array[0] instanceof Folder) {
            throw new SonicfoundryException('FolderArrayHierarchy: Argument must be an array of Folders', SonicfoundryException::INVALID_ARGUMENT);
        }
        $group = array();
        foreach($array as $folder) {
            if(array_key_exists($folder->ParentFolderId, $group)) {
               $group[$folder->ParentFolderId][] = $folder;
            } else {
                $group[$folder->ParentFolderId] = array($folder);
            }
        }

        $rootfolderid = '';
        foreach($group as $keys => $values) {
            $found = FALSE;
            foreach($array as $folder) {
                if(!strcmp($keys, $folder->Id)) {
                    $found = TRUE;
                }
            }
            if(!$found) {
                $rootfolderid = $keys;
                break;
            }
        }

        $temp = array();
        foreach($group[$rootfolderid] as $folder) {
            self::FolderMerge($folder, $group, $rootfolderid, $temp);
        }

        $array = $temp;
    }
    private static function compare($a, $b) {
        return strcmp($a->Id, $b->Id);
    }
    public static function sort($folders) {
        usort($folders, 'Sonicfoundry\Folder::compare');
    }
	public function __toString() {
		return (string)$this->Name;
	}
    public $Id;
    public $Name;
    public $Owner;
    public $Description;
    public $CreationDate;
    public $LastModified;
    public $ParentFolderId;
    public $Recycled;
    public $Type;
    public $Presentations;
}