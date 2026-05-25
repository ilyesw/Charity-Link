# 🤝 Charity-Link

<div align="center">

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Bootstrap Icons](https://img.shields.io/badge/Bootstrap_Icons-1.11-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://icons.getbootstrap.com)
[![Vite](https://img.shields.io/badge/Vite-8.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)](https://alpinejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Gemini AI](https://img.shields.io/badge/Gemini_AI-2.0_Flash-4285F4?style=for-the-badge&logo=google&logoColor=white)](https://ai.google.dev)
[![License](https://img.shields.io/badge/Licence-MIT-green?style=for-the-badge)](LICENSE)

**Plateforme humanitaire tunisienne · Tunisian Humanitarian Platform**

</div>

---

## 🇫🇷 Version Française

### 📖 Description

**Charity-Link** est une plateforme web complète dédiée à la solidarité et au don en Tunisie. Elle met en relation des donateurs, des associations caritatives et des bénévoles autour de campagnes de collecte, de besoins déclarés et de missions de bénévolat. L'application intègre un assistant IA (Google Gemini) pour guider les donateurs dans leurs choix, ainsi qu'un système de transparence financière pour chaque campagne.

---

### ✨ Fonctionnalités

| Fonctionnalité | Description | Statut |
|---|---|---|
| 🔐 Authentification multi-rôles | Donateur, Association, Bénévole, Admin (via Laravel Breeze) | ✅ |
| 🏢 Gestion des associations | Inscription, validation admin, profil complet avec documents | ✅ |
| 📣 Campagnes de collecte | Création, suivi de progression, galerie photos, notation ⭐ | ✅ |
| 💸 Dons multi-types | Don monétaire, don nature (matériel), don de compétence | ✅ |
| 🙏 Déclaration de besoins | Formulaire public de besoin d'aide avec anonymat optionnel | ✅ |
| 🙌 Module bénévolat | Tâches ouvertes, candidature, compte-rendu, archivage | ✅ |
| 🤖 Chatbot IA | Assistant Gemini 2.0 Flash pour recommander des associations | ✅ |
| 💰 Transparence financière | Tableau entrées/sorties par campagne, solde en temps réel | ✅ |
| 🔔 Notifications | Système de notifications en temps réel pour les utilisateurs | ✅ |
| 🌐 Internationalisation | Interface bilingue Français / Anglais commutable | ✅ |
| 📊 Export Admin | Export des dons en PDF (DomPDF) et Excel (Maatwebsite) | ✅ |
| 🛡️ Panel Admin | Gestion utilisateurs (blocage/suppression), validation entités | ✅ |
| 👤 Profil utilisateur | Modification des infos, changement d'avatar | ✅ |
| 📎 Pièces jointes | Upload de justificatifs pour les besoins et documents RNE/fiscal | ✅ |

---

### 🛠️ Stack Technique

| Catégorie | Technologie | Version |
|---|---|---|
| 🖥️ Backend | Laravel (PHP) | 13.x / PHP 8.3 |
| 🎨 CSS Framework | Bootstrap | 5.3 (via CDN) |
| 🎨 Icônes | Bootstrap Icons | 1.11 (via CDN) |
| 📄 Templates | Blade (Laravel) | natif |
| ⚡ Build Tool | Vite + laravel-vite-plugin | 8.x |
| 🗄️ Base de données | MySQL | 8.x |
| 🤖 IA | Google Gemini API | 2.0 Flash Lite |
| 📄 Export PDF | barryvdh/laravel-dompdf | ^3.1 |
| 📊 Export Excel | maatwebsite/excel | ^3.1 |
| 🔄 HTTP Client | Guzzle HTTP | ^7.10 |
| 🔑 Auth | Laravel Breeze | ^2.4 |
| 🧪 Tests | PHPUnit | ^12.5 |

---

### 🗂️ Structure du Projet

```
Charity-Link/
├── app/
│   ├── Exports/
│   │   └── DonsExport.php          # Export Excel des dons
│   ├── Helpers/                    # Fonctions utilitaires
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php         # Gestion admin (users, entités, exports)
│   │   │   ├── AssociationController.php   # CRUD associations
│   │   │   ├── BesoinController.php        # Déclaration & gestion des besoins
│   │   │   ├── CampaignController.php      # CRUD campagnes + transparence + notation
│   │   │   ├── ChatbotController.php       # Intégration Gemini AI
│   │   │   ├── DonationController.php      # Gestion des dons
│   │   │   ├── NotificationController.php  # Notifications utilisateur
│   │   │   ├── ProfileController.php       # Profil & avatar
│   │   │   └── TacheController.php         # Module bénévolat
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php         # Accès réservé aux admins
│   │   │   └── SetLocale.php              # Changement de langue (fr/en)
│   │   └── Requests/                       # Form Requests (validation)
│   ├── Models/
│   │   ├── Association.php         # Modèle association (statuts, scopes)
│   │   ├── Besoin.php              # Modèle besoin (anonymat, pièces jointes)
│   │   ├── Campaign.php            # Modèle campagne (progression, solde, rating)
│   │   ├── CampaignPhoto.php       # Galerie photos de campagne
│   │   ├── CampaignRating.php      # Notation ⭐ des campagnes
│   │   ├── CampaignTransaction.php # Entrées/sorties financières
│   │   ├── Donation.php            # Modèle don (monétaire, nature, compétence)
│   │   ├── Notification.php        # Notifications en base
│   │   ├── Tache.php               # Tâches bénévoles
│   │   └── User.php                # Utilisateur multi-rôles
│   ├── Providers/                  # Service Providers Laravel
│   └── View/                       # View Composers
├── database/
│   ├── migrations/                 # 25 migrations (users, campagnes, dons, etc.)
│   ├── factories/                  # Factories pour les tests
│   └── seeders/                    # Seeders de données initiales
├── lang/
│   ├── fr.json                     # Traductions françaises
│   └── en.json                     # Traductions anglaises
├── resources/
│   ├── css/                        # Styles CSS
│   ├── js/                         # JavaScript (Alpine.js, Axios)
│   └── views/
│       ├── admin/                  # Vues panel administration
│       ├── associations/           # Vues associations
│       ├── auth/                   # Vues login/register (Breeze)
│       ├── besoins/                # Vues besoins
│       ├── campaigns/              # Vues campagnes (show, create, edit, transparence)
│       ├── chatbot/                # Interface chatbot IA
│       ├── components/             # Composants Blade réutilisables
│       ├── dashboard/              # Tableau de bord utilisateur
│       ├── donations/              # Vues dons & historique
│       ├── exports/                # Templates PDF
│       ├── layouts/                # Layouts principaux
│       ├── notifications/          # Vues notifications
│       ├── profile/                # Vues profil utilisateur
│       ├── taches/                 # Vues bénévolat
│       ├── dashboard.blade.php     # Dashboard principal
│       └── welcome.blade.php       # Page d'accueil publique
├── routes/
│   ├── web.php                     # Routes web (auth, campagnes, admin, chatbot…)
│   ├── auth.php                    # Routes d'authentification (Breeze)
│   └── console.php                 # Commandes Artisan
├── .env.example                    # Configuration d'exemple
├── composer.json                   # Dépendances PHP
├── package.json                    # Dépendances Node.js
├── tailwind.config.js              # Configuration Tailwind
└── vite.config.js                  # Configuration Vite
```

---

### 🚀 Installation

#### Prérequis

- PHP >= 8.3
- Composer >= 2.x
- Node.js >= 18.x & npm
- MySQL >= 8.x (ou XAMPP)

#### Étapes

**1. Cloner le dépôt**
```bash
git clone https://github.com/votre-utilisateur/Charity-Link.git
cd Charity-Link
```

**2. Installer les dépendances PHP**
```bash
composer install
```

**3. Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configurer la base de données** dans `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=charity_link
DB_USERNAME=root
DB_PASSWORD=
```

**5. Configurer la clé API Gemini** dans `.env` :
```env
GEMINI_API_KEY=votre_cle_api_google_gemini
```

**6. Exécuter les migrations**
```bash
php artisan migrate
```

**7. Installer les dépendances Node.js et compiler les assets**
```bash
npm install
npm run build
```

**8. Lancer le serveur de développement**
```bash
# Tout-en-un (serveur + queue + logs + Vite)
composer run dev

# Ou séparément :
php artisan serve
npm run dev
```

**9. Accéder à l'application**

Ouvrez votre navigateur sur : [http://localhost:8000](http://localhost:8000)

---

### 🔑 Rôles Utilisateurs

| Rôle | Accès |
|---|---|
| `admin` | Panel d'administration complet, validation, exports, gestion utilisateurs |
| `association` | Gestion de son association, campagnes, tâches bénévoles |
| `donateur` | Faire des dons, consulter l'historique, noter les campagnes |
| `benevole` | Postuler aux tâches, soumettre des comptes-rendus |

---

### 🤝 Contribution

Les contributions sont les bienvenues ! Merci de suivre ces étapes :

1. **Forker** le dépôt
2. **Créer** une branche pour votre fonctionnalité
   ```bash
   git checkout -b feature/ma-fonctionnalite
   ```
3. **Commiter** vos modifications
   ```bash
   git commit -m "feat: ajout de ma fonctionnalité"
   ```
4. **Pousser** la branche
   ```bash
   git push origin feature/ma-fonctionnalite
   ```
5. Ouvrir une **Pull Request**

---

### 📜 Licence

Ce projet est distribué sous licence **MIT**. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

<div align="center">

**Fait avec ❤️ pour la solidarité tunisienne**

</div>

---
---

## 🇬🇧 English Version

### 📖 Description

**Charity-Link** is a comprehensive web platform dedicated to solidarity and charitable giving in Tunisia. It connects donors, charitable associations, and volunteers through fundraising campaigns, declared needs, and volunteer missions. The application integrates an AI assistant (Google Gemini) to guide donors, and features a financial transparency system for every campaign.

---

### ✨ Features

| Feature | Description | Status |
|---|---|---|
| 🔐 Multi-role Authentication | Donor, Association, Volunteer, Admin (via Laravel Breeze) | ✅ |
| 🏢 Association Management | Registration, admin validation, full profile with documents | ✅ |
| 📣 Fundraising Campaigns | Creation, progress tracking, photo gallery, star rating ⭐ | ✅ |
| 💸 Multi-type Donations | Monetary, in-kind (material), and skills-based donations | ✅ |
| 🙏 Needs Declaration | Public help request form with optional anonymity | ✅ |
| 🙌 Volunteering Module | Open tasks, applications, mission reports, archiving | ✅ |
| 🤖 AI Chatbot | Gemini 2.0 Flash assistant to recommend associations | ✅ |
| 💰 Financial Transparency | Income/expense ledger per campaign, real-time balance | ✅ |
| 🔔 Notifications | Real-time notification system for users | ✅ |
| 🌐 Internationalization | Switchable bilingual interface: French / English | ✅ |
| 📊 Admin Exports | Donation exports to PDF (DomPDF) and Excel (Maatwebsite) | ✅ |
| 🛡️ Admin Panel | User management (block/delete), entity validation | ✅ |
| 👤 User Profile | Edit info, change avatar | ✅ |
| 📎 File Attachments | Upload of supporting documents for needs and fiscal/RNE docs | ✅ |

---

### 🛠️ Tech Stack

| Category | Technology | Version |
|---|---|---|
| 🖥️ Backend | Laravel (PHP) | 13.x / PHP 8.3 |
| 🎨 CSS Framework | Bootstrap | 5.3 (via CDN) |
| 🎨 Icons | Bootstrap Icons | 1.11 (via CDN) |
| 📄 Templates | Blade (Laravel) | built-in |
| ⚡ Build Tool | Vite + laravel-vite-plugin | 8.x |
| 🗄️ Database | MySQL | 8.x |
| 🤖 AI | Google Gemini API | 2.0 Flash Lite |
| 📄 PDF Export | barryvdh/laravel-dompdf | ^3.1 |
| 📊 Excel Export | maatwebsite/excel | ^3.1 |
| 🔄 HTTP Client | Guzzle HTTP | ^7.10 |
| 🔑 Auth | Laravel Breeze | ^2.4 |
| 🧪 Tests | PHPUnit | ^12.5 |

---

### 🗂️ Project Structure

```
Charity-Link/
├── app/
│   ├── Exports/
│   │   └── DonsExport.php          # Excel donation export
│   ├── Helpers/                    # Utility functions
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php         # Admin panel (users, entities, exports)
│   │   │   ├── AssociationController.php   # Association CRUD
│   │   │   ├── BesoinController.php        # Needs declaration & management
│   │   │   ├── CampaignController.php      # Campaign CRUD + transparency + rating
│   │   │   ├── ChatbotController.php       # Gemini AI integration
│   │   │   ├── DonationController.php      # Donation management
│   │   │   ├── NotificationController.php  # User notifications
│   │   │   ├── ProfileController.php       # Profile & avatar
│   │   │   └── TacheController.php         # Volunteering module
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php         # Admin-only access guard
│   │   │   └── SetLocale.php              # Language switcher (fr/en)
│   │   └── Requests/                       # Form Requests (validation)
│   ├── Models/
│   │   ├── Association.php         # Association model (statuses, scopes)
│   │   ├── Besoin.php              # Need model (anonymity, attachments)
│   │   ├── Campaign.php            # Campaign model (progress, balance, rating)
│   │   ├── CampaignPhoto.php       # Campaign photo gallery
│   │   ├── CampaignRating.php      # Campaign star ratings
│   │   ├── CampaignTransaction.php # Financial income/expense records
│   │   ├── Donation.php            # Donation model (monetary, in-kind, skills)
│   │   ├── Notification.php        # Database notifications
│   │   ├── Tache.php               # Volunteer tasks
│   │   └── User.php                # Multi-role user model
│   └── Providers/                  # Laravel Service Providers
├── database/
│   ├── migrations/                 # 25 migrations
│   ├── factories/                  # Model factories for testing
│   └── seeders/                    # Initial data seeders
├── lang/
│   ├── fr.json                     # French translations
│   └── en.json                     # English translations
├── resources/
│   ├── css/                        # Stylesheets
│   ├── js/                         # JavaScript (Alpine.js, Axios)
│   └── views/                      # Blade templates (14 modules)
├── routes/
│   ├── web.php                     # Web routes
│   ├── auth.php                    # Auth routes (Breeze)
│   └── console.php                 # Artisan commands
├── .env.example                    # Example environment config
├── composer.json                   # PHP dependencies
├── package.json                    # Node.js dependencies
├── tailwind.config.js              # Tailwind configuration
└── vite.config.js                  # Vite configuration
```

---

### 🚀 Installation

#### Prerequisites

- PHP >= 8.3
- Composer >= 2.x
- Node.js >= 18.x & npm
- MySQL >= 8.x (or XAMPP)

#### Steps

**1. Clone the repository**
```bash
git clone https://github.com/your-username/Charity-Link.git
cd Charity-Link
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Set up the environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure the database** in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=charity_link
DB_USERNAME=root
DB_PASSWORD=
```

**5. Configure the Gemini API key** in `.env`:
```env
GEMINI_API_KEY=your_google_gemini_api_key
```

**6. Run migrations**
```bash
php artisan migrate
```

**7. Install Node.js dependencies and compile assets**
```bash
npm install
npm run build
```

**8. Start the development server**
```bash
# All-in-one (server + queue + logs + Vite)
composer run dev

# Or separately:
php artisan serve
npm run dev
```

**9. Open the application**

Navigate to: [http://localhost:8000](http://localhost:8000)

---

### 🔑 User Roles

| Role | Access |
|---|---|
| `admin` | Full admin panel, validation, exports, user management |
| `association` | Manage their association, campaigns, and volunteer tasks |
| `donateur` | Make donations, view history, rate campaigns |
| `benevole` | Apply for tasks, submit mission reports |

---

### 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch
   ```bash
   git checkout -b feature/my-feature
   ```
3. **Commit** your changes
   ```bash
   git commit -m "feat: add my feature"
   ```
4. **Push** the branch
   ```bash
   git push origin feature/my-feature
   ```
5. Open a **Pull Request**

---

### 📜 License

This project is distributed under the **MIT** license. See the [LICENSE](LICENSE) file for details.

---

<div align="center">

**Made with ❤️ for Tunisian solidarity**

</div>
