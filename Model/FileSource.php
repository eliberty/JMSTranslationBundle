<?php

/*
 * Copyright 2011 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace JMS\TranslationBundle\Model;

class FileSource implements SourceInterface
{
    private $path;
    private $line;
    private $column;

    public function __construct($path, $line = null, $column = null)
    {
        $this->path = $path;
        $this->line = $line;
        $this->column = $column;
    }

    public function getPath()
    {
        $parts = explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $this->path));
        $parts = array_splice($parts, -3);

        return implode('/', $parts);
    }

    public function getRealPath()
    {
        return $this->path;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function equals(SourceInterface $source)
    {
        if (!$source instanceof FileSource) {
            return false;
        }

        if ($this->path !== $source->getRealPath()) {
            return false;
        }

        if ($this->line !== $source->getLine()) {
            return false;
        }

        if ($this->column !== $source->getColumn()) {
            return false;
        }

        return true;
    }

    public function __toString()
    {
        $str = basename(dirname($this->path)).'/'.basename($this->path);

        if (null !== $this->line) {
            $str .= ' on line '.$this->line;

            if (null !== $this->column) {
                $str .= ' at column '.$this->column;
            }
        }

        return $str;
    }
}