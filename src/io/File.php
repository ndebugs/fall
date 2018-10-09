<?php

namespace ndebugs\fall\io;

class File {
    
    /** @var string */
    private $path;
    
    /** @param string $path */
    public function __construct($path) {
        $this->path = $path;
    }

    /** @return string */
    public function getParentPath() {
        $path = dirname($this->path);
        return $path !== $this->path? $path : null;
    }

    /** @return string */
    public function getAbsolutePath() {
        $path = realpath($this->path);
        return $path !== false ? $path : null;
    }

    /** @return string */
    public function getPath() {
        return $this->path;
    }

    /** @return string */
    public function getName() {
        return $this->name;
    }

    /** @return boolean */
    public function isDirectory() {
        return is_dir($this->path);
    }

    /** @return boolean */
    public function isFile() {
        return is_file($this->path);
    }

    /** @return boolean */
    public function isSymlink() {
        return is_link($this->path);
    }

    /** @return boolean */
    public function isExists() {
        return file_exists($this->path);
    }

    /**
     * @param boolean $recursive [optional]
     * @param integer $mode [optional]
     * @return boolean
     */
    public function mkdir($recursive = false, $mode = 0777) {
        if (!$this->isExists()) {
            return mkdir($this->path, $mode, $recursive) !== false;
        } else {
            return false;
        }
    }

    /**
     * @param boolean $recursive [optional]
     * @param integer $mode [optional]
     * @return boolean
     */
    public function create($recursive = false, $mode = 0777) {
        if (!$this->isExists()) {
            $parentPath = $this->getParentPath();
            if ($recursive && !file_exists($parentPath)) {
                mkdir($parentPath, $mode, $recursive);
            }
            return file_put_contents($this, '') !== false;
        } else {
            return false;
        }
    }

    /** @return boolean */
    public function delete() {
        if ($this->isExists()) {
            return unlink($this->path);
        } else {
            return false;
        }
    }
    
    /** @return File */
    public function parent() {
        $parentPath = $this->getParentPath();
        return $parentPath ? new File($parentPath) : null;
    }

    /** @return File[] */
    public function childs() {
        if ($this->isDirectory()) {
            $files = [];
            $filePaths = scandir($this);
            $path = $this->getAbsolutePath() . DIRECTORY_SEPARATOR;
            foreach ($filePaths as $filePath) {
                if ($filePath !== '.' && $filePath !== '..') {
                    $files[] = new File($path . $filePath);
                }
            }
            return $files;
        } else {
            return null;
        }
    }
    
    /** @return string */
    public function __toString() {
        return $this->path;
    }
}
