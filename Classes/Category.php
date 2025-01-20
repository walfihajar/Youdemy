<?php
require_once 'Database.php'; // Inclure la classe Database

class Category
{
    private ?int $id_category; // Nullable car il peut ne pas être défini avant l'insertion
    private string $name;
    private PDO $db; // Connexion à la base de données

    // Constructeur
    public function __construct(PDO $db, ?int $id_category = null, string $name = '')
    {
        $this->db = $db; // Initialiser la connexion à la base de données
        $this->id_category = $id_category;
        $this->name = $name;
    }

    // Getter pour l'ID de la catégorie
    public function getIdCategory(): ?int
    {
        return $this->id_category;
    }

    // Getter pour le nom de la catégorie
    public function getName(): string
    {
        return $this->name;
    }

    // Setter pour le nom de la catégorie
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    // Méthode pour créer une catégorie dans la base de données
    public function create(): bool
    {
        // Vérifier si la catégorie existe déjà
        if ($this->exists()) {
            throw new Exception("La catégorie '{$this->name}' existe déjà.");
        }

        // Insérer la catégorie dans la base de données
        $stmt = $this->db->prepare("INSERT INTO category (name) VALUES (:name)");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $success = $stmt->execute();

        // Récupérer l'ID généré
        if ($success) {
            $this->id_category = $this->db->lastInsertId();
        }

        return $success;
    }

    // Méthode pour mettre à jour une catégorie dans la base de données
    public function update(): bool
    {
        // Vérifier si la catégorie existe déjà avec un autre ID
        if ($this->exists()) {
            throw new Exception("La catégorie '{$this->name}' existe déjà.");
        }

        // Mettre à jour la catégorie dans la base de données
        $stmt = $this->db->prepare("UPDATE category SET name = :name WHERE id_category = :id_category");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->bindParam(':id_category', $this->id_category, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Méthode pour supprimer une catégorie de la base de données
    public function delete(): bool
    {
        $stmt = $this->db->prepare("DELETE FROM category WHERE id_category = :id_category");
        $stmt->bindParam(':id_category', $this->id_category, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Méthode pour vérifier si une catégorie existe déjà dans la base de données
    public function exists(): bool
    {
        $stmt = $this->db->prepare("SELECT id_category FROM category WHERE name = :name");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    // Méthode statique pour récupérer toutes les catégories de la base de données
    public static function showAll(PDO $db): array
    {
        $stmt = $db->prepare("SELECT * FROM category");
        $stmt->execute();
        $categories = [];

        while ($categoryData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Category($db, $categoryData['id_category'], $categoryData['name']);
        }

        return $categories;
    }
}
?>