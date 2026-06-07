# 📝 Blog Personnel Laravel

> Application de blog moderne développée avec Laravel 11, permettant la gestion d'articles, commentaires, likes et catégories.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=flat&logo=php)
![License](https://img.shields.io/badge/License-MIT-green.svg)

## ✨ Fonctionnalités

### 👤 Pour les Visiteurs
- 📖 Consultation des articles publiés
- 🔍 Filtrage par catégorie
- 📱 Interface responsive et moderne

### 🔐 Pour les Utilisateurs Connectés
- ❤️ Liker/unliker des articles
- 💬 Commenter les articles
- 💭 Répondre aux commentaires (1 niveau)
- 👤 Gestion de profil

### 👨‍💼 Pour l'Administrateur
- ✍️ Créer, modifier et supprimer des articles
- 🖼️ Upload d'images pour les articles
- 📂 Gestion des catégories
- 🗑️ Modération des commentaires
- 📊 Statistiques (likes, commentaires)
- 📝 Système de brouillon/publication

## 🚀 Technologies Utilisées

- **Backend**: Laravel 11
- **Frontend**: Blade + Bootstrap 5 + Alpine.js
- **Base de données**: MySQL
- **Authentification**: Laravel Breeze
- **Assets**: Vite
- **Icons**: Bootstrap Icons

## 📦 Installation

### Prérequis
- PHP 8.4+
- Composer
- MySQL
- Node.js & NPM

### Étapes d'installation

1. **Cloner le repository**
```bash
git clone https://github.com/votre-username/blog-laravel.git
cd blog-laravel
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances NPM**
```bash
npm install
```

4. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurer la base de données**
Éditez le fichier `.env` et configurez vos informations de connexion:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=root
DB_PASSWORD=
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Créer le lien symbolique pour le storage**
```bash
php artisan storage:link
```

8. **Peupler la base de données (optionnel)**
```bash
php artisan db:seed --class=BlogSeeder
```
Identifiants admin par défaut:
- Email: `admin@blog.com`
- Password: `password`

9. **Compiler les assets**
```bash
npm run build
# Ou pour le développement
npm run dev
```

10. **Lancer le serveur**
```bash
php artisan serve
```

Accédez à l'application sur `http://127.0.0.1:8000`

## 📁 Structure du Projet

```
blog/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Contrôleurs admin
│   │   ├── Auth/           # Authentification
│   │   └── ...
│   └── Models/             # Modèles Eloquent
├── database/
│   ├── migrations/         # Migrations
│   └── seeders/           # Seeders
├── resources/
│   ├── views/
│   │   ├── admin/         # Vues admin
│   │   ├── posts/         # Vues publiques
│   │   └── layouts/       # Layouts
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php            # Routes web
│   └── auth.php           # Routes d'authentification
└── public/
    ├── images/            # Images par défaut
    └── storage/           # Lien symbolique vers storage
```

## 🗃️ Base de Données

### Tables principales
- `users` - Utilisateurs (admin et users)
- `posts` - Articles avec images et extraits
- `categories` - Catégories d'articles
- `comments` - Commentaires et réponses
- `likes` - Likes sur les articles

### Schéma relationnel
```
users (1) ----< (N) posts
users (1) ----< (N) comments
users (1) ----< (N) likes
posts (1) ----< (N) comments
posts (1) ----< (N) likes
categories (1) ----< (N) posts
comments (1) ----< (N) comments (replies)
```

## 🎨 Captures d'écran

### Page d'accueil
Liste des articles avec images, catégories et statistiques

### Détail d'un article
Article complet avec système de likes et commentaires

### Panel Admin
Interface d'administration pour gérer les articles et catégories

## 🔐 Système de Rôles

| Action | Visiteur | User | Admin |
|--------|----------|------|-------|
| Lire articles | ✅ | ✅ | ✅ |
| Liker | ❌ | ✅ | ✅ |
| Commenter | ❌ | ✅ | ✅ |
| Gérer articles | ❌ | ❌ | ✅ |
| Modérer | ❌ | ❌ | ✅ |

## 🧪 Tests

```bash
# Exécuter les tests
php artisan test

# Avec couverture
php artisan test --coverage
```

## 🚀 Déploiement

### Sur Railway.app
1. Connectez votre repo GitHub
2. Configurez les variables d'environnement
3. Railway détectera automatiquement Laravel

### Sur Render.com
1. Créez un nouveau Web Service
2. Liez votre repository
3. Configurez les build commands:
```bash
composer install --no-dev
npm install && npm run build
php artisan migrate --force
php artisan storage:link
```

## 📝 Commandes Artisan Utiles

```bash
# Créer un nouvel article (console)
php artisan tinker
>>> App\Models\Post::create([...])

# Nettoyer le cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Régénérer les assets
npm run build

# Voir les routes
php artisan route:list
```

## 🤝 Contribution

Les contributions sont les bienvenues ! 

1. Fork le projet
2. Créez votre branche (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👨‍💻 Auteur

**Votre Nom**
- GitHub: [@votre-username](https://github.com/votre-username)
- Email: votre.email@example.com

## 🙏 Remerciements

- Laravel Framework
- Bootstrap Team
- Bootstrap Icons
- La communauté open source

---

⭐ Si ce projet vous a été utile, n'hésitez pas à lui donner une étoile !
