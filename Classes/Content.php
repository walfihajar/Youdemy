<?php
require_once 'Database.php';

abstract class Content
{
    protected ?int $id_content;
    protected ?int $id_course;
    protected ?string $type;
    protected PDO $db; 

    
    public function __construct(PDO $db,?int $id_content = null, ?int $id_course = null, ?string $type = null )
    {
        $this->db = $db; 
        $this->id_content = $id_content;
        $this->id_course = $id_course;
        $this->type = $type;
    }

    abstract public function add(): int|bool;
    abstract public function display(): string ;
    abstract public function update(): bool;
}




