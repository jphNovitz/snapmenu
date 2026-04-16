# Issues Symfony 7.4 LTS

## Issue 2

**Titre:** Aligner l'entite `Category` avec son usage reel dans les controleurs et formulaires

**Contexte:** Le code applicatif utilise des proprietes `type` et `owner` sur `Category`, mais elles ne sont pas presentes dans l'entite actuelle.

**Probleme:**
- Le controleur filtre sur `type` et `owner`
- Le form type lit `getType()` et appelle `setOwner()`
- L'entite [Category.php](/home/jiffy/dev/snapmenu/src/Entity/Category.php:11) ne contient ni ces champs ni ces methodes

**Impact:**
- Risque de bugs runtime
- Domaine incoherent
- Migration Symfony/Doctrine plus risquee car le modele ne reflete pas le comportement reel

**Proposition:**
- Ajouter explicitement les champs/manipulations manquants a `Category`
- Ou supprimer cette logique des controleurs/formulaires si elle n'est plus voulue
- Revoir les requetes repository associees

**Fichiers concernes:**
- [src/Entity/Category.php](/home/jiffy/dev/snapmenu/src/Entity/Category.php:11)
- [src/Form/CategoryType.php](/home/jiffy/dev/snapmenu/src/Form/CategoryType.php:35)
- [src/Controller/Admin/Category/CategoryController.php](/home/jiffy/dev/snapmenu/src/Controller/Admin/Category/CategoryController.php:30)

**Criteres d'acceptation:**
- `Category` reflete completement le domaine reellement utilise
- Plus aucun appel a des proprietes/methodes inexistantes
- Les tests CRUD et metier sur les categories passent

**Priorite:** Haute

## Issue 3

**Titre:** Supprimer `\Serializable` de l'entite `Store` et nettoyer la serialisation legacy

**Contexte:** `Store` implemente encore `\Serializable` et contient des methodes de serialisation incompletes.

**Probleme:**
- `Serializable` est une approche legacy
- `__unserialize()` est laisse avec un `TODO`
- Melange de plusieurs mecanismes de serialisation dans une entite Doctrine

**Impact:**
- Dette technique elevee
- Risque de comportement imprevisible
- Mauvais point de depart pour une trajectoire Symfony 7.4 / PHP moderne

**Proposition:**
- Retirer `implements \Serializable`
- Supprimer les methodes legacy inutiles
- Conserver uniquement une strategie explicite si un vrai besoin existe

**Fichiers concernes:**
- [src/Entity/Store.php](/home/jiffy/dev/snapmenu/src/Entity/Store.php:15)

**Criteres d'acceptation:**
- `Store` n'implemente plus `Serializable`
- Plus de methodes de serialisation inachevees
- Aucun test ou flux applicatif ne depend d'une serialisation implicite de l'entite

**Priorite:** Haute

## Issue 4

**Titre:** Corriger le constructeur invalide de `OpeningHours`

**Contexte:** Le constructeur de `OpeningHours` reference une variable inexistante.

**Probleme:**
- Le constructeur utilise `$openTime` sans definition
- Les heures par defaut sont donc implementees de maniere incorrecte

**Impact:**
- Bug direct
- Instanciation fragile
- Risque de casser les formulaires, fixtures ou tests

**Proposition:**
- Corriger le constructeur
- Initialiser explicitement `openTime` et `closeTime`
- Verifier si ces valeurs par defaut doivent vivre dans le constructeur, le formulaire ou les fixtures

**Fichiers concernes:**
- [src/Entity/OpeningHours.php](/home/jiffy/dev/snapmenu/src/Entity/OpeningHours.php:31)

**Criteres d'acceptation:**
- L'entite est instanciable sans erreur
- Les valeurs par defaut sont coherentes et testees
- Les tests d'horaires passent

**Priorite:** Haute

## Issue 5

**Titre:** Refactorer `StoreGlobalSubscriber` pour retirer la logique de redirection globale fragile

**Contexte:** Un subscriber sur `KernelEvents::CONTROLLER` pilote la redirection globale et injecte un global Twig.

**Probleme:**
- Condition de routage fragile
- Beaucoup de code commente
- Couplage fort entre flux HTTP, Twig et repository
- Controle de navigation applique trop tot dans le cycle de requete

**Impact:**
- Effets de bord difficiles a diagnostiquer
- Complexite inutile pour les tests et migrations
- Risque de regressions sur routes admin/fallback

**Proposition:**
- Deplacer la logique vers un service explicite ou un listener plus cible
- Clarifier les cas d'exclusion
- Supprimer le code mort
- Encadrer le comportement par des tests fonctionnels

**Fichiers concernes:**
- [src/EventSubscriber/StoreGlobalSubscriber.php](/home/jiffy/dev/snapmenu/src/EventSubscriber/StoreGlobalSubscriber.php:17)
- [src/Repository/StoreRepository.php](/home/jiffy/dev/snapmenu/src/Repository/StoreRepository.php:30)

**Criteres d'acceptation:**
- La logique de redirection est lisible et testable
- Les routes admin et fallback ont un comportement explicite
- Plus de code commente inutile dans le subscriber

**Priorite:** Haute

## Issue 6

**Titre:** Sortir la logique metier des controleurs CRUD

**Contexte:** Plusieurs controleurs manipulent directement Doctrine et portent de la logique metier applicative.

**Probleme:**
- `persist/flush/remove` dans les controleurs
- `getRepository()` appele depuis les actions
- `getUser()` utilise sans typage metier clair
- Logique d'activation/desactivation dans les controllers

**Impact:**
- Controleurs trop gros
- Tests plus difficiles
- Couplage fort a l'infrastructure
- Migration plus couteuse

**Proposition:**
- Introduire des services applicatifs cibles
- Injecter les repositories directement au lieu de passer par `EntityManager`
- Reserver les controleurs a l'orchestration HTTP

**Fichiers concernes:**
- [src/Controller/Admin/Category/CategoryController.php](/home/jiffy/dev/snapmenu/src/Controller/Admin/Category/CategoryController.php:18)
- [src/Controller/Admin/Store/StoreController.php](/home/jiffy/dev/snapmenu/src/Controller/Admin/Store/StoreController.php:24)
- [src/Controller/Admin/ProductController.php](/home/jiffy/dev/snapmenu/src/Controller/Admin/ProductController.php:29)

**Criteres d'acceptation:**
- Les controleurs ne contiennent plus la logique metier centrale
- Les operations principales passent par des services dedies
- Les responsabilites HTTP et domaine sont separees

**Priorite:** Haute

## Issue 7

**Titre:** Simplifier la configuration securite et supprimer le provider `chain` avec utilisateur `in_memory`

**Contexte:** La securite combine un provider Doctrine et un provider memoire dans un `chain_provider`.

**Probleme:**
- Configuration plus complexe que necessaire
- Modele de roles ambigu
- Risque de confusion entre utilisateurs applicatifs et compte technique

**Impact:**
- Authentification moins lisible
- Maintenance plus difficile
- Migration securite Symfony plus delicate

**Proposition:**
- Conserver un provider principal Doctrine
- Externaliser le besoin admin technique si necessaire
- Clarifier les roles et la hierarchie d'acces

**Fichiers concernes:**
- [config/packages/security.yaml](/home/jiffy/dev/snapmenu/config/packages/security.yaml:6)
- [src/Controller/LoginController.php](/home/jiffy/dev/snapmenu/src/Controller/LoginController.php:27)

**Criteres d'acceptation:**
- La securite repose sur une strategie simple et explicite
- Les comptes et roles sont coherents
- Les tests de login/acces admin restent verts

**Priorite:** Moyenne-haute

## Issue 8

**Titre:** Reactiver et clarifier la strategie CSRF globale

**Contexte:** La config `framework` laisse `csrf_protection` commente.

**Probleme:**
- Signal contradictoire dans une application basee sur les formulaires Symfony
- Risque de confusion entre protection framework et protection des forms

**Impact:**
- Securite moins lisible
- Configuration incomplete pour une base Symfony moderne

**Proposition:**
- Activer explicitement la protection CSRF si c'est la strategie retenue
- Verifier les formulaires et actions POST sensibles
- Documenter le comportement attendu

**Fichiers concernes:**
- [config/packages/framework.yaml](/home/jiffy/dev/snapmenu/config/packages/framework.yaml:2)

**Criteres d'acceptation:**
- La strategie CSRF est explicite
- Les formulaires et suppressions POST sont couverts
- Les tests fonctionnels POST restent valides

**Priorite:** Moyenne

## Issue 9

**Titre:** Epurer les `FormType` qui embarquent de la logique metier et du contexte utilisateur

**Contexte:** Certains formulaires injectent `Security` et manipulent le domaine au travers de listeners.

**Probleme:**
- `CategoryType` decide du comportement metier selon l'utilisateur
- `ProductType` filtre ses entites via `Security`
- Affectation de `owner/store` faite dans un form event

**Impact:**
- Formulaires trop intelligents
- Couplage fort au contexte HTTP/securite
- Tests unitaires plus difficiles

**Proposition:**
- Deplacer la logique metier hors des `FormType`
- Passer les donnees necessaires par options explicites
- Utiliser des query services ou repositories dedies

**Fichiers concernes:**
- [src/Form/CategoryType.php](/home/jiffy/dev/snapmenu/src/Form/CategoryType.php:21)
- [src/Form/ProductType.php](/home/jiffy/dev/snapmenu/src/Form/ProductType.php:22)

**Criteres d'acceptation:**
- Les `FormType` restent centres sur la structure du formulaire
- Le contexte metier n'est plus lu directement depuis `Security`
- Le comportement est couvert par des tests

**Priorite:** Moyenne-haute

## Issue 10

**Titre:** Nettoyer `composer.json` pour preparer la montee vers Symfony 7.4 LTS

**Contexte:** Les dependances Symfony sont figees en `7.1.*` et certaines contraintes sont trop larges.

**Probleme:**
- Contraintes `*` sur certains bundles
- Dependances d'outillage presentes en production
- Verrouillage trop strict sur 7.1

**Impact:**
- Upgrade plus risque
- Resolution Composer moins previsible
- Maintenance plus couteuse

**Proposition:**
- Remplacer les `*` par des contraintes explicites
- Deplacer les paquets purement dev dans `require-dev`
- Preparer le passage de `extra.symfony.require` vers la cible 7.4
- Verifier la compatibilite des bundles tiers

**Fichiers concernes:**
- [composer.json](/home/jiffy/dev/snapmenu/composer.json:6)

**Criteres d'acceptation:**
- Aucune dependance applicative critique n'utilise `*`
- Les dependances de dev sont dans `require-dev`
- Le projet est pret a cibler Symfony 7.4 cote Composer

**Priorite:** Haute

## Issue 11

**Titre:** Moderniser la configuration de tests et remonter les deprecations

**Contexte:** La suite de tests repose encore sur PHPUnit 9.5 avec une config de compatibilite permissive.

**Probleme:**
- `convertDeprecationsToExceptions="false"`
- `SymfonyTestsListener` legacy
- Base de tests peu exigeante pour preparer un upgrade de framework

**Impact:**
- Les deprecations passent sous le radar
- La montee vers Symfony 7.4 devient plus risquee
- La dette s'accumule silencieusement

**Proposition:**
- Faire remonter les deprecations
- Moderniser progressivement la config PHPUnit / bridge Symfony
- Nettoyer les tests pour qu'ils passent sans masquage de warnings structurels

**Fichiers concernes:**
- [phpunit.xml.dist](/home/jiffy/dev/snapmenu/phpunit.xml.dist:4)

**Criteres d'acceptation:**
- Les deprecations Symfony/PHP sont visibles et traitees
- La config de test est alignee avec une stack Symfony moderne
- La suite reste executable en CI

**Priorite:** Haute
