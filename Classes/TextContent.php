<?php
require_once 'Content.php';

class TextContent extends Content
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->type = 'text';
    }

    public function display()
    {
        return "<div class='text-content'>{$this->data}</div>";
    }
}
?>