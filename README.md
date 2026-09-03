# Boris Lumière — Site web + espace admin

Site vitrine et catalogue en ligne pour **Boris Lumière**, commerce de vente de câbles,
appareillages électriques, informatique, vidéosurveillance et télécom à Douala.

Le client parcourt le catalogue, ajoute des produits à son panier, télécharge un PDF
récapitulatif, puis envoie sa commande sur WhatsApp pour finaliser prix, paiement et
livraison directement avec Boris. Aucun paiement en ligne n'est géré par le site — voir
le cahier des charges pour le détail complet du projet.

---

## Stack technique

| Composant | Choix |
|---|---|
| Backend | Laravel 13 |
| Frontend | Blade + Alpine.js + Tailwind CSS |
| Base de données | SQLite en développement — bascule vers PostgreSQL au déploiement |
| PDF | `barryvdh/laravel-dompdf` |
| Authentification admin | Laravel Breeze (Blade) |
| Hébergement cible | Render (déploiement Docker) |

---

## Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              # Back-office (produits, catégories, dashboard)
│   │   ├── HomeController.php
│   │   ├── CatalogueController.php
│   │   ├── CartController.php  # Panier + génération PDF + lien WhatsApp
│   │   └── ContactController.php
│   └── Requests/Admin/         # Validation des formulaires admin
├── Models/
│   ├── Category.php
│   └── Product.php
└── Services/
    └── CartService.php         # Logique du panier (session, sans table BDD)

database/
├── migrations/                 # categories, products (+ tables Breeze)
└── seeders/                    # Compte admin démo + catégories + produits d'exemple

resources/views/
├── components/
│   ├── layouts/
│   │   ├── public.blade.php    # Layout du site public (header/nav/footer/WhatsApp)
│   │   └── admin.blade.php     # Layout de l'espace admin (sidebar)
│   ├── product-card.blade.php
│   └── whatsapp-float.blade.php
├── public/                      # Accueil, catalogue, panier, contact
├── admin/                       # Dashboard, CRUD produits, CRUD catégories
└── pdf/order.blade.php          # Récapitulatif PDF de commande

scripts/00-laravel-deploy.sh      # Exécuté automatiquement au démarrage du conteneur Render
Dockerfile                        # Image de production (différente de Sail)
```

**Pourquoi une structure aussi séparée ?** `Services/CartService` isole la logique du
panier des contrôleurs — si demain le panier doit changer de mécanisme (ex. passer en
base de données pour suivre les commandes), un seul fichier change. Les `Http/Requests`
séparent la validation des contrôleurs, qui restent courts et lisibles. C'est la
structure standard recommandée par Laravel pour rester "scalable" au-delà d'un petit
projet.

---

## Installation en local

### 1. Prérequis

- PHP ≥ 8.3, Composer
- Node.js + npm
- PostgreSQL (ou SQLite en dépannage — voir plus bas)

### 2. Cloner et installer les dépendances

```bash
composer install
npm install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

Le `.env.example` est préconfiguré en **SQLite** pour démarrer immédiatement sans
installer de serveur de base de données :

```
DB_CONNECTION=sqlite
```

Crée le fichier de base :

```bash
touch database/database.sqlite
```

**Au moment du déploiement**, on basculera sur PostgreSQL (géré nativement par Render,
sauvegardes automatiques incluses). Il suffira alors de commenter la ligne SQLite et de
décommenter/remplir le bloc PostgreSQL déjà présent dans `.env.example` :

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=boris_lumiere
DB_USERNAME=postgres
DB_PASSWORD=
```

Aucun code applicatif ne change entre les deux — Eloquent et les migrations sont
agnostiques du moteur de base de données.

### 4. Base de données

```bash
php artisan migrate --seed
```

Ça crée toutes les tables et ajoute :
- un compte admin de démo : **boris@borislumiere.com** / **password** (à changer avant la mise en production)
- les 4 catégories du cahier des charges
- 12 produits d'exemple (à remplacer par les vrais produits/photos depuis l'admin)

### 5. Lier le stockage des images

```bash
php artisan storage:link
```

Indispensable pour que les photos de produits uploadées depuis l'admin soient
accessibles publiquement.

### 6. Compiler les assets et lancer le serveur

```bash
npm run dev      # dans un premier terminal (compilation CSS/JS à chaud)
php artisan serve # dans un second terminal
```

Le site est sur `http://localhost:8000`, l'admin sur `http://localhost:8000/admin`
(connexion requise).

---

## Configuration importante

### Numéro WhatsApp

Le numéro utilisé pour tous les boutons WhatsApp du site est défini dans `.env` :

```
WHATSAPP_NUMBER=237680659724
```

Format international, sans `+` ni espaces. Modifie cette valeur si le numéro change —
aucun code à toucher ailleurs, le bouton flottant, les fiches produits et le panier le
lisent tous depuis `config('services.whatsapp.number')`.

### Ajouter/modifier des produits

Une fois connecté sur `/admin`, tout se fait depuis l'interface :
- **Produits** → ajouter/modifier/supprimer, avec upload direct d'une photo depuis la
  galerie (pas besoin de lien d'image).
- **Catégories** → gérer les 4 familles de produits (ou en ajouter).

Le tableau de bord (`/admin`) affiche le nombre total de produits, la répartition par
catégorie, et alerte sur les produits à stock faible (≤ 3).

---

## Le parcours panier → PDF → WhatsApp (rappel du fonctionnement)

1. Le client ajoute des produits au panier (stocké en session, pas de compte requis).
2. Sur la page panier, il télécharge un PDF récapitulatif (`barryvdh/laravel-dompdf`).
3. Il clique sur "Envoyer sur WhatsApp" → un message pré-rempli s'ouvre avec le détail
   de la commande.
4. **Limite technique assumée** : WhatsApp ne permet pas l'envoi automatique d'une
   pièce jointe via un lien web — le message invite donc le client à joindre
   manuellement le PDF déjà téléchargé. Boris et le client finalisent ensuite prix,
   paiement et livraison directement dans la conversation.

---

## Déploiement

Pas encore configuré à ce stade — le projet tourne pour l'instant en local avec
SQLite pour avancer vite sur les fonctionnalités. Quand tu seras prêt à déployer sur
Render : bascule `.env` vers PostgreSQL (voir ci-dessus), crée une base PostgreSQL sur
Render, puis on ajoutera à ce moment-là le `Dockerfile` de production et la
configuration de déploiement.

---

## Prochaines évolutions possibles (hors périmètre V1)

- Suivi des commandes envoyées (actuellement tout se passe sur WhatsApp, rien n'est
  enregistré côté site)
- Version anglaise du site
- Paiement Mobile Money
- Statistiques de visite
