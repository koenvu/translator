<?php

namespace Koenvu\Translator;

class Comparator
{
    /**
     * Store the language lines available in the database.
     *
     * @var array
     */
    protected $inDatabase = [];

    /**
     * Store the language lines available in the files.
     *
     * @var array
     */
    protected $inFiles = [];

    public function __construct($inDatabase, $inFiles)
    {
        $this->inDatabase = $inDatabase;
        $this->inFiles = $inFiles;
    }

    /**
     * Find translations in the database that no longer exist in the files.
     *
     * @return array
     */
    public function obsolete()
    {
        return array_diff_key($this->inDatabase, $this->inFiles);
    }

    /**
     * Find translations that are already in the database, but differ in content from the files.
     *
     * @return array
     */
    public function updated()
    {
        return array_diff(
            array_intersect_key($this->inDatabase, $this->inFiles),
            $this->inFiles
        );
    }

    /**
     * Find translations that are not yet in the database.
     *
     * @return array
     */
    public function added()
    {
        return array_diff_key($this->inFiles, $this->inDatabase);
    }
}
