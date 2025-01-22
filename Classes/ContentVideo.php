<?php
require_once 'Database.php';
require_once 'Content.php';

class ContentVideo extends Content
{
    private ?string $url = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $picture = null;
    private ?float $price = null;
    private ?int $id_category = null;
    private ?int $id_user = null;

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

    // Setters et getters pour les nouvelles propriétés
    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setIdCategory(?int $id_category): self
    {
        $this->id_category = $id_category;
        return $this;
    }

    public function setIdUser(?int $id_user): self
    {
        $this->id_user = $id_user;
        return $this;
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
        $sqlCourse = "INSERT INTO course (title, description, picture, id_category, id_user, created_at, price, status, archive, content_type) 
                      VALUES (:title, :description, :picture, :id_category, :id_user, :created_at, :price, 'activated', '0', :content_type)";
        $stmtCourse = $this->db->prepare($sqlCourse);
        $stmtCourse->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmtCourse->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmtCourse->bindParam(':picture', $this->picture, PDO::PARAM_STR);
        $stmtCourse->bindParam(':id_category', $this->id_category, PDO::PARAM_INT);
        $stmtCourse->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        $stmtCourse->bindParam(':created_at', date('Y-m-d H:i:s'));
        $stmtCourse->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmtCourse->bindParam(':content_type', $this->type, PDO::PARAM_STR);
        $stmtCourse->execute();

        $this->id_course = $this->db->lastInsertId();

        $sqlContent = "INSERT INTO content (id_course, type, url_video) VALUES (:id_course, :type, :url_video)";
        $stmtContent = $this->db->prepare($sqlContent);
        $stmtContent->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        $stmtContent->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmtContent->bindParam(':url_video', $this->url, PDO::PARAM_STR);
        return $stmtContent->execute();

        
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
        $videoHtml = '<iframe width="560" height="315" src="' . htmlspecialchars($this->url) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
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


