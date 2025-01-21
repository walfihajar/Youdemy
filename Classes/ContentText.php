<?php
require_once 'Database.php';
require_once 'Content.php';


class ContentText extends Content
{
    private ?string $content = null;
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
        ?string $content = null
    ) {
        parent::__construct($db, $id_content, $id_course, $type);
        $this->content = $content;
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
        // Insérer le cours dans la table `course`
        $sqlCourse = "INSERT INTO course (title, description, picture, id_category, id_user, created_at, price, status, archive, content_type) 
                      VALUES (:title, :description, :picture, :id_category, :id_user, :created_at, :price, 'activated', '0', :content_type)";
        $stmtCourse = $this->db->prepare($sqlCourse);
        $stmtCourse->bindParam(':title', $this->title, PDO::PARAM_STR);
        $stmtCourse->bindParam(':description', $this->description, PDO::PARAM_STR);
        $stmtCourse->bindParam(':picture', $this->picture, PDO::PARAM_STR);
        $stmtCourse->bindParam(':id_category', $this->id_category, PDO::PARAM_INT);
        $stmtCourse->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
        $stmtCourse->bindValue(':created_at', date('Y-m-d H:i:s')); // Utilisation de bindValue ici
        $stmtCourse->bindParam(':price', $this->price, PDO::PARAM_STR);
        $stmtCourse->bindParam(':content_type', $this->type, PDO::PARAM_STR);
        $stmtCourse->execute();

        // Récupérer l'ID du cours inséré
        $this->id_course = $this->db->lastInsertId();

        // Insérer le contenu texte dans la table `content`
        $sqlContent = "INSERT INTO content (id_course, type, content_text) VALUES (:id_course, :type, :content_text)";
        $stmtContent = $this->db->prepare($sqlContent);
        $stmtContent->bindParam(':id_course', $this->id_course, PDO::PARAM_INT);
        $stmtContent->bindParam(':type', $this->type, PDO::PARAM_STR);
        $stmtContent->bindParam(':content_text', $this->content, PDO::PARAM_STR);
        return $stmtContent->execute();
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