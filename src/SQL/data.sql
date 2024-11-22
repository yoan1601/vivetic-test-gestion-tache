-- Table des utilisateurs
CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(180) NOT NULL UNIQUE,
    `roles` JSON NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des tâches
CREATE TABLE `task` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `status` ENUM('pending', 'in_progress', 'completed') NOT NULL DEFAULT 'pending',
    `priority` ENUM('low', 'medium', 'high') NOT NULL DEFAULT 'medium',
    `start_date` DATETIME NOT NULL,
    `end_date` DATETIME NOT NULL,
    `assigned_to_id` INT,
    `comments` TEXT,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`assigned_to_id`) REFERENCES `user`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion d'utilisateurs de test
INSERT INTO `user` (`email`, `roles`, `password`, `full_name`) VALUES
-- Le mot de passe est 'admin123' hashé avec BCRYPT
('admin@example.com', '["ROLE_ADMIN"]', '$2y$13$IrBzuDcBbf7S8X4p8FVoKe7pvfQ3i5pbw7F7VCBFphMSTD/AXjqIu', 'Admin User'),
-- Le mot de passe est 'user123' hashé avec BCRYPT
('user@example.com', '["ROLE_USER"]', '$2y$13$jYoU7VKoGhfL8qQH8SCxu.9PlEFfaZWqZSd.K/XCjl/9BbH0zrKQC', 'Regular User');

ALTER TABLE task
    MODIFY status VARCHAR(255) NOT NULL DEFAULT 'pending',
    MODIFY priority VARCHAR(255) NOT NULL DEFAULT 'medium';


-- Insertion de quelques tâches de test
INSERT INTO `task` (`title`, `description`, `status`, `priority`, `start_date`, `end_date`, `assigned_to_id`) VALUES
('Configuration du projet', 'Mettre en place l\'environnement de développement', 'completed', 'high', NOW(), DATE_ADD(NOW(), INTERVAL 2 DAY), 1),
('Développement des fonctionnalités', 'Implémenter les principales fonctionnalités', 'in_progress', 'high', NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), 2),
('Tests unitaires', 'Écrire les tests unitaires pour les fonctionnalités principales', 'pending', 'medium', DATE_ADD(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 7 DAY), 2);