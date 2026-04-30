# Deprecations à corriger

## 1. `framework.yaml` — property_info.with_constructor_extractor

**Deprecation :** `symfony/framework-bundle 7.3` — la valeur par défaut changera en 8.0.

- [x] Ajouter dans `config/packages/framework.yaml` :
  ```yaml
  framework:
      property_info:
          with_constructor_extractor: false
  ```
  > `false` = comportement actuel. Passer à `true` si tu veux que le PropertyInfo
  > extrait aussi les propriétés définies via le constructeur.

---

## 2. `doctrine.yaml` — controller_resolver.auto_mapping

**Deprecation :** `doctrine/doctrine-bundle` — l'auto-mapping des entités dans les
paramètres de controller est déprécié. Remplacement : Symfony Mapped Route Parameters.

- [x] Ajouter dans `config/packages/doctrine.yaml` sous `orm:` :
  ```yaml
  doctrine:
      orm:
          controller_resolver:
              auto_mapping: false
  ```
- [x] Vérifier si des controllers utilisent l'injection automatique d'entité via
  paramètre de route (ex: `public function show(Store $store)` sans `#[MapEntity]`).
  Si oui, ajouter explicitement `#[MapEntity]` de `Symfony\Bridge\Doctrine\Attribute\MapEntity`.

---

## 3. `src/Entity/Store.php` — VichUploaderBundle Annotation → Attribute

**Deprecation :** `vich/uploader-bundle 2.9` — le namespace `Annotation` est déprécié,
utiliser `Attribute` à la place.

- [x] Déjà réglé : `Store.php` utilise `Vich\UploaderBundle\Mapping\Attribute as Vich`
  et les attributs `#[Vich\Uploadable]` / `#[Vich\UploadableField(...)]`.
- [x] Doublon nettoyé : l'ancienne annotation DocBlock `@Gedmo\Slug` coexistait avec
  `#[Gedmo\Slug]` sur le champ `slug` — le DocBlock a été supprimé.

> **Note Gedmo :** `gedmo/doctrine-extensions` v3.x n'a pas de namespace `Attribute`
> séparé. L'import `Gedmo\Mapping\Annotation as Gedmo` est correct et compatible avec
> la syntaxe PHP 8 `#[Gedmo\...]`.
