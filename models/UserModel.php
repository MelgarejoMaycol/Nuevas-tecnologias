<?php
class UserModel {
  private $pdo;
  public function __construct($pdo) { $this->pdo = $pdo; }

  public function findByEmailOrPhone($identifier) {
    // Como ya no usamos phone, simplemente buscar por email
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :id LIMIT 1");
    $stmt->execute([':id' => $identifier]);
    return $stmt->fetch();
  }

  public function findByEmail($email) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch();
  }

  public function create($name, $email, $password, $role = 'cliente') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Verificar si la columna 'role' existe en la tabla
    try {
      $stmt = $this->pdo->prepare("SHOW COLUMNS FROM users LIKE 'role'");
      $stmt->execute();
      $roleColumnExists = $stmt->fetch() !== false;
    } catch (PDOException $e) {
      $roleColumnExists = false;
    }
    
    if ($roleColumnExists) {
      // Si la columna role existe, incluirla en el INSERT (sin phone)
      $stmt = $this->pdo->prepare(
        "INSERT INTO users (name,email,password_hash,role) VALUES (:n,:e,:h,:r)"
      );
      $stmt->execute([':n'=>$name, ':e'=>$email, ':h'=>$hash, ':r'=>$role]);
    } else {
      // Si no existe la columna role, usar el INSERT original (sin phone)
      $stmt = $this->pdo->prepare(
        "INSERT INTO users (name,email,password_hash) VALUES (:n,:e,:h)"
      );
      $stmt->execute([':n'=>$name, ':e'=>$email, ':h'=>$hash]);
    }
    
    return $this->pdo->lastInsertId();
  }

  public function createFromArray($data) {
    return $this->create(
      $data['name'],
      $data['email'], 
      $data['password_hash'],
      $data['role'] ?? 'cliente'
    );
  }

  public function getAllUsers() {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE estado = 1");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getUserStats() {
    $stmt = $this->pdo->prepare("
      SELECT 
        COUNT(*) as total_users,
        SUM(CASE WHEN role = 'cliente' THEN 1 ELSE 0 END) as clientes,
        SUM(CASE WHEN role = 'tecnico' THEN 1 ELSE 0 END) as tecnicos,
        SUM(CASE WHEN role = 'administrador' THEN 1 ELSE 0 END) as administradores
      FROM users
    ");
    $stmt->execute();
    return $stmt->fetch();
  }

  public function deleteUser($userId) {
    $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
    return $stmt->execute([':id' => $userId]);
  }

  public function updateUserRole($userId, $newRole) {
    $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE id = :id");
    return $stmt->execute([':role' => $newRole, ':id' => $userId]);
  }

  public function getTecnicos() {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'tecnico'"); // Cambia 'users' si tu tabla tiene otro nombre
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getUsersByRole($rol) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = ? AND estado = 1");
    $stmt->execute([$rol]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

