<?php
require_once 'Content.php';

class VideoContent extends Content
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->type = 'video';
    }

    public function display()
    {
        return "<video controls><source src='{$this->data}' type='video/mp4'>Your browser does not support the video tag.</video>";
    }
}
?>