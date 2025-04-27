***
**Auteurs : 
Abib Aicia , Moucer Bahdja**

# Application de Réservation de Restaurant (PHP / MVC)

## Présentation
Cette application web permet aux clients de réserver une table en ligne et à l’équipe du restaurant de gérer les réservations dans un tableau de bord administrateur.  
Elle a été développée dans le cadre du projet « Développement web ».

## Fonctionnalités principale
 **Réservation en ligne** | Formulaire (nom,prenom ,e-mail, date, créneau). Validation côté client et serveur. |
 **Notifications e-mail** | Envoi automatique de confirmation au client (PHP Mailer). |
 **Sécurité** | Requêtes préparées PDO,filtrage des entrées.

## Architecture


## Technologies utilisées
- **Backend** : PHP 8.3 (MVC maison)
- **Base de données** : MySQL (PhpMyAdmin)
- **Frontend** : HTML, CSS, JS
- **E-mails** : [PHPMailer](https://github.com/PHPMailer/PHPMailer) (installé via Composer)

## Prérequis
- PHP ≥ 7.4 avec les extensions *pdo_mysql*, *openssl*, *mbstring*
- MySQL 8
- **Composer** (obligatoire pour installer PHPMailer et que l’envoi d’e-mails fonctionne)
- XAMPP pour un environnement local « tout-en-un »

## Installation rapide

```bash
# 1. Cloner le dépôt
git clone https://github.com/Abib-Alicia/restaurant-reservation.git
cd restaurant-reservation

# 2. Installer les dépendances PHP (PHPMailer)
composer install

# 3. Configurer la base
#    - créer une base 'reservationdb'
#    - importer le script SQL fourni (reservationdb.sql)

# 4. Lancer le serveur local
http://localhost/reservation-site/public
``` 
