# 🚗 CERI Car

**CERI Car** est une plateforme web de covoiturage développée dans le cadre d'un projet universitaire en **Licence 3 Informatique** à l'[Université d'Avignon] (CERI - Centre d'Enseignement et de Recherche en Informatique).

Réalisée par **Chiheb Eddine KEBBAS**.L'application est actuellement déployée et opérationnelle sur le site de l'université.

---

## 📌 Fonctionnalités Principales

- **👤 Authentification & Profil** : Inscription et connexion sécurisées pour les utilisateurs (Internautes). Gestion du profil personnel.
- **📍 Proposer un Trajet** : Création de nouvelles offres de de covoiturage (Lieu de départ, destination, horaires) associées à un véhicule.
- **🔍 Recherche de Trajets** : Moteur de recherche performant pour trouver un voyage selon des critères comme la date, l'heure ou le trajet.
- **🎟️ Réservation** : Système intégré de réservation avec possibilité pour les internautes de réserver leurs places pour un trajet donné.
- **🚗 Gestion des Véhicules** : Enregistrement et référencement des véhicules utilisés pour les voyages, en incluant un système de classification par marques et types.

---

## 🛠️ Architecture & Technologies

Le projet repose sur le robuste framework PHP **Yii2** et utilise une architecture MVC (Modèle-Vue-Contrôleur).

- **Backend** : PHP 7.4+, [Framework Yii2](https://www.yiiframework.com/).
- **Frontend** : HTML5, CSS3, intégré avec le moteur de rendu de Yii.
- **Base de données** : Modélisation entité-relation avec les classes clés `Internaute`, `Reservation`, `Voyage`, `Trajet`, `MarqueVehicule` et `TypeVehicule`.
- **Environnement & Déploiement** : Support pour les environnements virtualisés avec **Docker** (`docker-compose.yml`) et **Vagrant** (`Vagrantfile`).
- **Dépendances** : Gérées via **Composer**.

---

## 🚀 Installation Locale

Si vous souhaitez faire tourner le projet en environnement de développement local :

### Prérequis
- PHP >= 7.4.0
- [Composer](https://getcomposer.org/)
- Environnement Web (Apache/Nginx/Serveur embarqué PHP)

### Étapes
1. **Cloner le répertoire du projet**
2. **Installer les dépendances** :
   ```bash
   composer install
   ```
3. **Configuration de l'environnement** :
   Veillez à renseigner vos paramètres de base de données dans le fichier approprié sous `config/` (ex: `db.php`).
4. **Exécuter les migrations Yii** (si présentes/nécessaires) :
   ```bash
   php yii migrate
   ```
5. **Démarrer l'application** avec le serveur intégré :
   ```bash
   php yii serve
   ```
   L'application sera alors accessible sur `http://localhost:8080`.

---

*Projet réalisé avec implication et rigueur durant l'année de L3 Informatique. Déployé sur les infrastructures de l'Université d'Avignon.*