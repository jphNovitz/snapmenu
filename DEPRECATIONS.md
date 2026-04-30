# Deprecations à corriger

## 1. `framework.yaml` — property_info.with_constructor_extractor

**Deprecation :** `symfony/framework-bundle 7.3` — la valeur par défaut changera en 8.0.

- [*] Ajouter dans `config/packages/framework.yaml` :
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

- [x] Dans `src/Entity/Store.php`, remplacer :
  ```php
  use Vich\UploaderBundle\Mapping\Annotation as Vich;
  ```
  par :
  ```php
  use Vich\UploaderBundle\Mapping\Attribute as Vich;
  ```
  > Les attributs PHP `#[Vich\Uploadable]` et `#[Vich\UploadableField(...)]` restent identiques.
