<?php
require_once 'Database.php';

class ContentText extends Content
{
    private ?string $content = null;

    public function __construct(
        PDO $db,
        ?int $id_content = null,
        ?int $id_course = null,
        ?string $type = null,
        ?string $content = null
    ) {
        parent::__construct($db, $id_content, $id_course, $type);
        $this->content = $content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content ?? '';
    }

    public function add(): bool
    {
        $sql = "INSERT INTO content (id_course, type, content_text) VALUES (:id_course, :type, :content_text)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindParam(':content_text', $this->content, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update(): bool
    {
        $sql = "UPDATE content SET content_text = :content_text WHERE id_content = :id_content";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':content_text', $this->content, PDO::PARAM_STR);
        $stmt->bindParam(':id_content', $this->id_content, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function display(): string
    {
        return '<div class="course-text">
                    <div class="bg-white rounded-lg p-8 mb-8">
                        <div class="">
                            ' . nl2br(htmlspecialchars($this->getContent())) . '
                        </div>
                    </div>
                </div>';
    }

    public static function fetchById(PDO $db, int $id_content): ?ContentText
    {
        $sql = "SELECT * FROM content WHERE id_content = :id_content";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_content', $id_content, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new ContentText(
                $db,
                $data['id_content'],
                $data['id_course'],
                $data['type'],
                $data['content_text']
            );
        }
        return null;
    }
}