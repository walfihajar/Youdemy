<?php
require_once 'Database.php';

class ContentVideo extends Content
{
    private ?string $url;

    public function __construct(
        PDO $db,
        ?int $id_content = null,
        ?int $id_course = null,
        ?string $type = null,
        ?string $url = null
    ) {
        parent::__construct($db, $id_content, $id_course, $type);
        $this->url = $url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url ?? '';
    }

    public function add(): bool
    {
        $sql = "INSERT INTO content (id_course, type, url_video) VALUES (:id_course, :type, :url_video)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        $stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmt->bindParam(':url_video', $this->url, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update(): bool
    {
        $sql = "UPDATE content SET url_video = :url_video WHERE id_content = :id_content";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':url_video', $this->url, PDO::PARAM_STR);
        $stmt->bindParam(':id_content', $this->id_content, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function display(): string
    {
        $videoHtml = '<iframe height="400" width="560" src="' . htmlspecialchars($this->url) . '"></iframe>';
        return '<div class="course-video w-full">
                    <div class="video-container mb-4">
                        <div class="container flex justify-center">
                            ' . $videoHtml . '
                        </div>
                    </div>
                </div>';
    }

    public static function fetchById(PDO $db, int $id_content): ?ContentVideo
    {
        $sql = "SELECT * FROM content WHERE id_content = :id_content";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id_content', $id_content, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new ContentVideo(
                $db,
                $data['id_content'],
                $data['id_course'],
                $data['type'],
                $data['url_video']
            );
        }
        return null;
    }
}