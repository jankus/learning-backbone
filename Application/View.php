<?php

namespace Application;


class View
{
    private $file;
    private $data;

    /**
     * Construct view object
     * @param string $file Relative path to a file
     * @param array $data Data that is passed to view file
     */
    public function __construct($file, $data = array())
    {
        $this->file = $file;
        $this->data = $data;
    }

    /**
     * Render a view
     * @return string
     */
    public function render()
    {
        extract($this->data);

        ob_start();

        require($this->file); // file existence must be checked before rendering

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
