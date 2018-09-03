<?php

namespace ndebugs\fall\io;

class File {
    
    private $path;
    
    public function __construct($path) {
        $this->path = $path;
    }

    public function getParentPath() {
        $path = dirname($this->path);
        return $path !== $this->path? $path : null;
    }

    public function getAbsolutePath() {
        $path = realpath($this->path);
        return $path !== false ? $path : null;
    }

    public function getPath() {
        return $this->path;
    }

    public function getName() {
        return $this->name;
    }

    public function isDirectory() {
        return is_dir($this->path);
    }

    public function isFile() {
        return is_file($this->path);
    }

    public function isSymlink() {
        return is_link($this->path);
    }

    public function isExists() {
        return file_exists($this->path);
    }

    public function mkdir($recursive = false, $mode = 0777) {
        if (!$this->isExists()) {
            return mkdir($this->path, $mode, $recursive) !== false;
        } else {
            return false;
        }
    }

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

    public function delete() {
        if ($this->isExists()) {
            return unlink($this->path);
        } else {
            return false;
        }
    }
    
    public function parent() {
        $parentPath = $this->getParentPath();
        return $parentPath ? new File($parentPath) : null;
    }

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
    
    public function __toString() {
        return $this->path;
    }
}
