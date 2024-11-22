# Application de Gestion de Tâches d'Équipe

Une application web développée avec Symfony 6+ permettant aux équipes de gérer et suivre leurs tâches et projets de manière collaborative.

## Fonctionnalités

- 👥 **Système d'authentification** avec deux types d'utilisateurs (admin et membre)
- ✅ **Gestion complète des tâches** (CRUD)
- 📊 **Tableau de bord** avec statistiques et indicateurs de performance
- 🔄 **API REST** pour l'intégration avec d'autres services
- ✨ **Interface intuitive** et responsive

## Prérequis

- PHP 8.1 ou supérieur
- Composer
- MySQL 5.7 ou supérieur (ou PostgreSQL 13+)
- Symfony CLI (recommandé pour le développement)
- Node.js et npm (pour la compilation des assets)

## Installation

1. **Cloner le repository**
```bash
git clone https://github.com/yoan1601/vivetic-test-gestion-tache.git
cd vivetic-test-gestion-tache
```

2. **Installer les dépendances**
```bash
composer install
npm install
```

3. **Configurer l'environnement**
   - Copier le fichier `.env` en `.env.local`
   - Modifier les paramètres de connexion à la base de données :
```
DATABASE_URL="mysql://user:password@127.0.0.1:3306/task_manager?serverVersion=8.0"
```

4. **Créer la base de données**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Charger les données initiales**
```bash
php bin/console doctrine:fixtures:load
```

6. **Compiler les assets**
```bash
npm run build
```

7. **Démarrer le serveur de développement**
```bash
symfony server:start
# ou
php -S localhost:8000 -t public/
```

## Comptes de test

### Admin
- Email: admin@example.com
- Mot de passe: admin123

### Membre
- Email: user@example.com
- Mot de passe: user123

## Structure du projet

```
vivetic-test-gestion-tache/
├── assets/              # Fichiers front-end (JS, CSS)
├── config/             # Configuration de l'application
├── migrations/         # Migrations de base de données
├── public/            # Fichiers publics
├── src/               # Code source PHP
│   ├── Controller/   # Contrôleurs
│   ├── Entity/       # Entités Doctrine
│   ├── Repository/   # Repositories
│   └── Service/      # Services métier
├── templates/         # Templates Twig
└── tests/            # Tests unitaires et fonctionnels
```

## Choix techniques

- **Symfony 6+** : Framework PHP moderne avec une excellente documentation
- **Doctrine ORM** : Pour la gestion de la base de données
- **API Platform** : Pour la création rapide d'APIs RESTful
- **Webpack Encore** : Pour la gestion des assets
- **Bootstrap 5** : Pour l'interface utilisateur responsive
