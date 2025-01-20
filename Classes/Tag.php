<?php
require_once 'Database.php'; // Inclure la classe Database

class Tag
{
    private ?int $id_tag; // Nullable car il peut ne pas être défini avant l'insertion
    private string $name;
    private PDO $db; // Connexion à la base de données

    // Constructeur
    public function __construct(PDO $db, ?int $id_tag = null, string $name = '')
    {
        $this->db = $db; // Initialiser la connexion à la base de données
        $this->id_tag = $id_tag;
        $this->name = $name;
    }

    // Getter pour l'ID du tag
    public function getIdTag(): ?int
    {
        return $this->id_tag;
    }

    // Getter pour le nom du tag
    public function getName(): string
    {
        return $this->name;
    }

    // Setter pour le nom du tag
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    // Méthode pour créer un tag dans la base de données
    public function create(): bool
    {
        // Vérifier si le tag existe déjà
        if ($this->exists()) {
            throw new Exception("Le tag '{$this->name}' existe déjà.");
        }

        // Insérer le tag dans la base de données
        $stmt = $this->db->prepare("INSERT INTO tag (name) VALUES (:name)");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $success = $stmt->execute();

        // Récupérer l'ID généré
        if ($success) {
            $this->id_tag = $this->db->lastInsertId();
        }

        return $success;
    }

    // Méthode pour mettre à jour un tag dans la base de données
    public function update(): bool
    {
        // Vérifier si le tag existe déjà avec un autre ID
        if ($this->exists()) {
            throw new Exception("Le tag '{$this->name}' existe déjà.");
        }

        // Mettre à jour le tag dans la base de données
        $stmt = $this->db->prepare("UPDATE tag SET name = :name WHERE id_tag = :id_tag");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':id_tag', $this->id_tag, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Méthode pour supprimer un tag de la base de données
    public function delete(): bool
    {
        $stmt = $this->db->prepare("DELETE FROM tag WHERE id_tag = :id_tag");
        $stmt->bindParam(':id_tag', $this->id_tag, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Méthode pour vérifier si un tag existe déjà dans la base de données
    public function exists(): bool
    {
        $stmt = $this->db->prepare("SELECT id_tag FROM tag WHERE name = :name");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Méthode statique pour récupérer tous les tags de la base de données
    public static function showAll(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM tag");
        $stmt->execute();
        $tags = [];

        while ($tagData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tags[] = new Tag($db, $tagData['id_tag'], $tagData['name']);
        }

        return $tags;
    }
}
?>