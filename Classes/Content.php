<?php
abstract class Content
{
    protected $type;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    abstract public function display();
}
?>