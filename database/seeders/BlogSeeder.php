<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un administrateur
        $admin = User::create([
            'name' => 'Admin Blog',
            'email' => 'admin@blog.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Créer quelques utilisateurs
        $users = [];
        $users[] = User::create([
            'name' => 'GBABLI Nahine',
            'email' => 'nahine@example.com',
            'password' => bcrypt('password'),
        ]);
        $users[] = User::create([
            'name' => 'Sophie Leclerc',
            'email' => 'sophie@example.com',
            'password' => bcrypt('password'),
        ]);
        $users[] = User::create([
            'name' => 'Lucas Bernard',
            'email' => 'lucas@example.com',
            'password' => bcrypt('password'),
        ]);

        // Créer des catégories
        $categories = [
            ['name' => 'Technologie', 'slug' => 'technologie'],
            ['name' => 'Tutoriels', 'slug' => 'tutoriels'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle'],
            ['name' => 'Voyages', 'slug' => 'voyages'],
            ['name' => 'Cuisine', 'slug' => 'cuisine'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::create($cat);
        }

        // Créer des articles avec images
        $posts = [
            [
                'title' => 'Introduction à Laravel 11',
                'content' => "Laravel 11 apporte de nombreuses améliorations et fonctionnalités. Dans cet article, nous allons explorer les principales nouveautés.\n\nLaravel continue d'être le framework PHP le plus populaire grâce à son élégance et sa simplicité. Les développeurs apprécient particulièrement son système de routing, son ORM Eloquent, et son système de templates Blade.\n\nLes nouveautés de Laravel 11 incluent des améliorations de performances, une meilleure gestion des files d'attente, et de nouveaux helpers utiles pour le développement quotidien.",
                'excerpt' => 'Découvrez les nouveautés de Laravel 11 et comment elles peuvent améliorer vos projets.',
                'category_id' => $categoryModels[0]->id,
                'image' => 'images/php-blog.svg',
            ],
            [
                'title' => 'Les meilleures pratiques en PHP moderne',
                'content' => "PHP a beaucoup évolué ces dernières années. Voici les meilleures pratiques à adopter en 2026.\n\nL'utilisation des types stricts, des attributs PHP 8+, et des fonctionnalités modernes comme les enums et les propriétés readonly permet d'écrire du code plus robuste et maintenable.\n\nN'oubliez pas d'utiliser Composer pour gérer vos dépendances, PHPUnit pour vos tests, et PHPStan ou Psalm pour l'analyse statique de votre code.",
                'excerpt' => 'Guide complet des meilleures pratiques PHP pour écrire du code moderne et maintenable.',
                'category_id' => $categoryModels[1]->id,
                'image' => 'images/tutoriel-blog.svg',
            ],
            [
                'title' => 'Comment optimiser les performances de votre site',
                'content' => "Les performances web sont cruciales pour l'expérience utilisateur. Voici comment optimiser votre site.\n\nCommencez par optimiser vos images en utilisant des formats modernes comme WebP. Minimisez vos fichiers CSS et JavaScript. Utilisez un CDN pour servir vos ressources statiques.\n\nN'oubliez pas la mise en cache ! Laravel offre d'excellents outils de cache que vous devriez utiliser pour améliorer les temps de chargement.",
                'excerpt' => 'Astuces et techniques pour optimiser les performances de votre application web.',
                'category_id' => $categoryModels[0]->id,
                'image' => 'images/web-blog.svg',
            ],
            [
                'title' => 'Mon voyage au Japon',
                'content' => "Le Japon est un pays fascinant qui mélange tradition et modernité. Voici mon récit de voyage.\n\nDe Tokyo à Kyoto, en passant par Osaka, chaque ville a son charme unique. La nourriture est exceptionnelle, les gens sont accueillants, et la culture est riche.\n\nJe recommande de visiter les temples de Kyoto tôt le matin pour éviter la foule. Le Mont Fuji est également un incontournable si vous aimez la randonnée.",
                'excerpt' => 'Récit de mon voyage inoubliable au pays du soleil levant.',
                'category_id' => $categoryModels[3]->id,
                'image' => 'images/lifestyle-blog.svg',
            ],
            [
                'title' => 'Recette : Tarte aux pommes maison',
                'content' => "Rien de mieux qu'une tarte aux pommes faite maison. Voici ma recette secrète !\n\nPour la pâte : 250g de farine, 125g de beurre, 1 œuf, une pincée de sel. Pour la garniture : 6 pommes, 100g de sucre, cannelle.\n\nPréchauffez le four à 180°C. Étalez la pâte dans un moule, disposez les pommes en tranches, saupoudrez de sucre et de cannelle. Enfournez 40 minutes. C'est prêt !",
                'excerpt' => 'La recette parfaite pour une tarte aux pommes croustillante et savoureuse.',
                'category_id' => $categoryModels[4]->id,
                'image' => 'images/productivity-blog.svg',
            ],
            [
                'title' => 'Guide complet de Git pour débutants',
                'content' => "Git est un outil essentiel pour tout développeur. Ce guide vous apprendra les bases.\n\nCommencez par comprendre les concepts de commit, branch, et merge. Utilisez git init pour créer un nouveau dépôt, git add pour ajouter des fichiers, et git commit pour enregistrer vos changements.\n\nLes branches sont puissantes : créez une branche avec git branch, changez de branche avec git checkout, et fusionnez avec git merge.",
                'excerpt' => 'Apprenez à maîtriser Git et le contrôle de version en quelques étapes simples.',
                'category_id' => $categoryModels[1]->id,
                'image' => 'images/tutoriel-blog.svg',
            ],
            [
                'title' => 'Minimalisme : vivre avec moins',
                'content' => "Le minimalisme n'est pas seulement une tendance, c'est un mode de vie qui apporte sérénité et clarté.\n\nCommencez par désencombrer votre espace. Gardez seulement ce qui vous apporte de la joie ou est réellement utile. Un espace épuré aide à clarifier l'esprit.\n\nLe minimalisme s'applique aussi au numérique : désabonnez-vous des newsletters inutiles, supprimez les applications que vous n'utilisez pas.",
                'excerpt' => 'Découvrez comment le minimalisme peut transformer votre vie et vous apporter plus de bonheur.',
                'category_id' => $categoryModels[2]->id,
                'image' => 'images/lifestyle-blog.svg',
            ],
            [
                'title' => 'Docker pour les développeurs PHP',
                'content' => "Docker révolutionne la façon dont nous développons et déployons nos applications. Voici pourquoi.\n\nAvec Docker, vous pouvez créer des environnements de développement reproductibles. Plus de 'ça marche sur ma machine' ! Utilisez docker-compose pour orchestrer plusieurs conteneurs.\n\nPour PHP, créez un Dockerfile avec PHP-FPM, Nginx, et MySQL. Vous aurez un environnement complet et isolé.",
                'excerpt' => 'Maîtrisez Docker pour créer des environnements de développement modernes et efficaces.',
                'category_id' => $categoryModels[1]->id,
                'image' => 'images/tech-blog.svg',
            ],
        ];

        $postModels = [];
        foreach ($posts as $index => $postData) {
            $post = Post::create([
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']) . '-' . uniqid(),
                'content' => $postData['content'],
                'excerpt' => $postData['excerpt'],
                'image' => $postData['image'] ?? null,
                'category_id' => $postData['category_id'],
                'user_id' => $admin->id,
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
            $postModels[] = $post;

            // Ajouter des likes aléatoires
            $likersCount = rand(2, count($users));
            $likers = collect($users)->random($likersCount);
            foreach ($likers as $liker) {
                Like::create([
                    'user_id' => $liker->id,
                    'post_id' => $post->id,
                ]);
            }

            // Ajouter des commentaires aléatoires
            $commentsCount = rand(1, 4);
            for ($i = 0; $i < $commentsCount; $i++) {
                $commenter = $users[array_rand($users)];
                $comment = Comment::create([
                    'user_id' => $commenter->id,
                    'post_id' => $post->id,
                    'body' => $this->getRandomComment(),
                ]);

                // Ajouter des réponses aléatoires
                if (rand(0, 1)) {
                    $replier = $users[array_rand($users)];
                    Comment::create([
                        'user_id' => $replier->id,
                        'post_id' => $post->id,
                        'parent_id' => $comment->id,
                        'body' => $this->getRandomReply(),
                    ]);
                }
            }
        }

        $this->command->info('✅ Seeding terminé avec succès!');
        $this->command->info('📧 Admin: admin@blog.com / password');
        $this->command->info('📊 Créé: ' . count($categoryModels) . ' catégories, ' . count($postModels) . ' articles');
    }

    private function getRandomComment(): string
    {
        $comments = [
            "Excellent article ! Merci pour le partage.",
            "Très intéressant, j'ai appris beaucoup de choses.",
            "Super contenu, continuez comme ça !",
            "J'attends avec impatience vos prochains articles.",
            "Merci pour ces explications claires et précises.",
            "Article très complet, félicitations !",
            "C'est exactement ce que je cherchais, merci !",
            "Très bon article, bien écrit et instructif.",
        ];
        return $comments[array_rand($comments)];
    }

    private function getRandomReply(): string
    {
        $replies = [
            "Je suis d'accord avec toi !",
            "Merci pour ton retour !",
            "Content que ça t'ait plu !",
            "Oui, c'est un sujet passionnant.",
            "Merci pour ton commentaire !",
            "Ravi que l'article t'ait été utile !",
        ];
        return $replies[array_rand($replies)];
    }
}
