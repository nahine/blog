<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class FreshContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Tout supprimer (likes, commentaires, articles, utilisateurs)
        Schema::disableForeignKeyConstraints();
        Like::query()->delete();
        Comment::query()->delete();
        Post::query()->delete();
        User::query()->delete();
        Schema::enableForeignKeyConstraints();

        // 2) Créer l'administrateur (le propriétaire du blog)
        $admin = User::create([
            'nom'               => 'Nahine Combari',
            'email'             => 'combarinahine@gmail.com',
            'password'          => bcrypt('password'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        // 3) Catégories (créées si elles n'existent pas déjà)
        $categories = [];
        foreach ([
            'Technologie' => 'technologie',
            'Tutoriels'   => 'tutoriels',
            'Lifestyle'   => 'lifestyle',
            'Voyages'     => 'voyages',
            'Cuisine'     => 'cuisine',
        ] as $name => $slug) {
            $categories[$slug] = Category::firstOrCreate(['slug' => $slug], ['nom' => $name]);
        }

        // 4) Articles de qualité avec de vraies photos (Unsplash)
        $img = fn (string $id) => "https://images.unsplash.com/photo-{$id}?auto=format&fit=crop&w=1280&q=80";

        $posts = [
            [
                'title'    => "L'intelligence artificielle au quotidien : ce qui change vraiment",
                'category' => 'technologie',
                'image'    => $img('1677442136019-21780ecad995'),
                'excerpt'  => "De l'assistant vocal au correcteur intelligent, l'IA s'invite partout. Faisons le tri entre le marketing et les usages réellement utiles.",
                'content'  => "L'intelligence artificielle n'est plus un sujet réservé aux laboratoires de recherche. Elle est désormais présente dans nos téléphones, nos voitures, nos outils de travail et même nos cuisines connectées.\n\nMais derrière le terme « IA », on trouve des réalités très différentes. Les modèles de langage comme ceux qui alimentent les assistants conversationnels savent rédiger, résumer et traduire avec une aisance impressionnante. D'autres systèmes, plus discrets, recommandent un film, filtrent un spam ou détectent une fraude bancaire en quelques millisecondes.\n\nLe vrai changement n'est pas la magie apparente, mais le gain de temps. Bien utilisée, l'IA prend en charge les tâches répétitives pour nous laisser l'essentiel : réfléchir, décider, créer. Le défi des prochaines années sera d'apprendre à collaborer avec ces outils sans leur déléguer notre esprit critique.",
            ],
            [
                'title'    => "Bien débuter avec Laravel : le guide pour ne pas se perdre",
                'category' => 'tutoriels',
                'image'    => $img('1461749280684-dccba630e2f6'),
                'excerpt'  => "Routes, contrôleurs, Blade, Eloquent... Voici une feuille de route claire pour construire votre première application Laravel sereinement.",
                'content'  => "Laravel est aujourd'hui l'un des frameworks PHP les plus appréciés, et ce n'est pas un hasard : il combine une syntaxe élégante avec une documentation exemplaire.\n\nPour démarrer, retenez trois piliers. Les **routes** définissent les adresses de votre site et les relient à du code. Les **contrôleurs** organisent la logique de chaque page. Enfin, **Blade**, le moteur de templates, permet d'écrire des vues lisibles mêlant HTML et données dynamiques.\n\nCôté base de données, **Eloquent** transforme vos tables en objets PHP faciles à manipuler : un article devient un modèle `Post`, ses commentaires une simple relation. Vous écrivez `Post::published()->get()` plutôt qu'une longue requête SQL.\n\nLe secret pour progresser ? Construire un vrai projet, même petit. Un blog comme celui-ci est l'exercice idéal : il couvre l'authentification, les relations, les formulaires et l'administration.",
            ],
            [
                'title'    => "Sécuriser son site web : 7 réflexes essentiels",
                'category' => 'technologie',
                'image'    => $img('1550751827-4bd374c3f58b'),
                'excerpt'  => "La sécurité n'est pas une option. Voici les bonnes pratiques simples qui protègent réellement vos utilisateurs et vos données.",
                'content'  => "Un site sécurisé inspire confiance. Heureusement, la majorité des attaques courantes se préviennent avec quelques réflexes de base.\n\nPremièrement, forcez le HTTPS partout : les échanges chiffrés empêchent l'interception des mots de passe. Deuxièmement, ne stockez jamais un mot de passe en clair ; un algorithme de hachage moderne comme bcrypt est indispensable.\n\nTroisièmement, validez systématiquement les données reçues d'un formulaire. Quatrièmement, protégez vos formulaires contre la falsification de requêtes (CSRF) — Laravel le fait automatiquement avec son jeton de sécurité. Cinquièmement, échappez vos sorties pour éviter les injections de scripts.\n\nEnfin, maintenez vos dépendances à jour et limitez les droits d'accès au strict nécessaire. La sécurité est un entretien continu, pas une case à cocher une fois pour toutes.",
            ],
            [
                'title'    => "Voyage au Japon : carnet d'un premier séjour",
                'category' => 'voyages',
                'image'    => $img('1493976040374-85c8e12f0c0e'),
                'excerpt'  => "Entre tradition et modernité, le Japon bouscule tous les repères. Récit d'un voyage entre temples millénaires et néons de Tokyo.",
                'content'  => "Arriver à Tokyo, c'est plonger dans une ville qui ne dort jamais. Les carrefours saturés de néons côtoient des sanctuaires silencieux où l'on vient prier à l'aube. Ce contraste permanent est ce qui rend le Japon si fascinant.\n\nÀ Kyoto, le rythme ralentit. Les ruelles pavées du quartier de Gion, les milliers de portiques rouges du Fushimi Inari et les jardins de mousse invitent à la contemplation. Levez-vous tôt : la lumière du matin et le calme valent largement quelques heures de sommeil.\n\nCôté cuisine, chaque repas est une découverte : ramen fumants, sushis d'une fraîcheur incomparable, pâtisseries au matcha. Et partout, une politesse et une propreté qui marquent durablement.\n\nMon conseil : laissez de la place à l'imprévu. Les plus beaux souvenirs naissent souvent au détour d'une ruelle, loin des itinéraires planifiés.",
            ],
            [
                'title'    => "Le minimalisme : vivre mieux avec moins",
                'category' => 'lifestyle',
                'image'    => $img('1493809842364-78817add7ffb'),
                'excerpt'  => "Désencombrer son espace, c'est aussi alléger son esprit. Petit guide pour adopter un quotidien plus simple et plus serein.",
                'content'  => "Le minimalisme n'est pas une compétition à celui qui possède le moins. C'est une démarche : garder ce qui a du sens et se libérer du superflu.\n\nCommencez petit, par un tiroir ou une étagère. Pour chaque objet, posez-vous une question simple : est-il utile, ou me rend-il heureux ? Si la réponse est non aux deux, il peut probablement partir.\n\nLe désencombrement vaut aussi pour le numérique. Désabonnez-vous des newsletters que vous ne lisez jamais, désinstallez les applications qui captent votre attention sans rien vous apporter, rangez votre bureau virtuel.\n\nLe résultat est souvent inattendu : moins de choses à gérer, c'est plus de temps, plus de clarté et, paradoxalement, un plus grand sentiment d'abondance.",
            ],
            [
                'title'    => "Recette : la tarte aux pommes maison, croustillante à souhait",
                'category' => 'cuisine',
                'image'    => $img('1568571780765-9276ac8b75a2'),
                'excerpt'  => "Une pâte dorée, des pommes fondantes et un parfum de cannelle : la recette inratable du dessert préféré des familles.",
                'content'  => "Rien ne réconforte autant qu'une tarte aux pommes tout juste sortie du four. Voici une recette simple, pour 6 personnes.\n\n**Pour la pâte :** 250 g de farine, 125 g de beurre froid en morceaux, 1 œuf, 2 cuillères d'eau froide et une pincée de sel. Sablez le beurre et la farine du bout des doigts, ajoutez l'œuf et l'eau, formez une boule sans trop travailler la pâte, puis laissez reposer 30 minutes au frais.\n\n**Pour la garniture :** 6 pommes, 80 g de sucre et une cuillère à café de cannelle.\n\nPréchauffez le four à 180 °C. Étalez la pâte dans un moule, piquez le fond à la fourchette. Disposez les pommes en tranches fines, en rosace, saupoudrez de sucre et de cannelle. Enfournez 40 minutes jusqu'à ce que les bords soient dorés.\n\nServez tiède, éventuellement avec une boule de glace vanille. Succès garanti !",
            ],
            [
                'title'    => "Mieux s'organiser : la méthode pour des journées productives",
                'category' => 'lifestyle',
                'image'    => $img('1484480974693-6ca0a78fb36b'),
                'excerpt'  => "Listes interminables, distractions, fatigue... Découvrez quelques principes simples pour reprendre le contrôle de votre temps.",
                'content'  => "Être productif ne signifie pas en faire toujours plus, mais faire ce qui compte vraiment. La première étape consiste à distinguer l'urgent de l'important.\n\nChaque matin, identifiez vos trois priorités du jour. Pas dix : trois. Si vous ne faisiez que cela, votre journée serait déjà réussie. Le reste viendra en bonus.\n\nProtégez votre attention : regroupez vos e-mails sur deux ou trois créneaux, coupez les notifications inutiles, et travaillez par blocs de concentration de 25 à 50 minutes suivis d'une vraie pause.\n\nEnfin, n'oubliez pas le repos. Un cerveau fatigué prend de mauvaises décisions. Dormir suffisamment et déconnecter le soir font partie intégrante d'une bonne organisation.",
            ],
            [
                'title'    => "Pourquoi tout le monde parle des applications web modernes",
                'category' => 'technologie',
                'image'    => $img('1467232004584-a241de8bcf5d'),
                'excerpt'  => "Rapides, fluides, accessibles partout : les applications web ont changé nos habitudes. Décryptage de ce qui se cache derrière.",
                'content'  => "En quelques années, le navigateur est devenu une véritable plateforme. On y édite des documents, on y monte des vidéos, on y gère une entreprise — sans rien installer.\n\nCette révolution repose sur des technologies devenues très matures : un HTML structuré, un CSS capable d'animations soignées et un JavaScript puissant. Côté serveur, des frameworks comme Laravel orchestrent les données, l'authentification et la sécurité.\n\nL'expérience utilisateur est au cœur des préoccupations. Une page doit se charger vite, réagir instantanément et fonctionner aussi bien sur mobile que sur ordinateur. Les interactions sans rechargement — comme aimer un article ou publier un commentaire — sont aujourd'hui la norme.\n\nLa prochaine étape ? Des applications encore plus intelligentes, capables de s'adapter à chaque utilisateur, tout en respectant sa vie privée et ses données.",
            ],
        ];

        foreach ($posts as $i => $data) {
            Post::create([
                'titre'          => $data['title'],
                'slug'           => Str::slug($data['title']) . '-' . Str::lower(Str::random(6)),
                'contenu'        => $data['content'],
                'extrait'        => $data['excerpt'],
                'image'          => $data['image'],
                'categorie_id'   => $categories[$data['category']]->id,
                'utilisateur_id' => $admin->id,
                'publie_le'      => now()->subMonths(count($posts) - $i)->subDays($i * 3),
            ]);
        }

        $this->command?->info('✅ Réinitialisation terminée.');
        $this->command?->info('👤 Admin : combarinahine@gmail.com / password');
        $this->command?->info('📝 ' . count($posts) . ' articles créés avec photos.');
    }
}
