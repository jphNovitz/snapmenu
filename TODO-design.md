# TODO — Adaptation design QR Menu (Snapmanu Prototype)

> Source : [Claude Design — Snapmanu Prototype - QR Menu.html](https://claude.ai/design/p/019dd358-124a-74cf-b388-1b6346be9c26)
> Règle : DaisyUI en priorité, modifié via classes Tailwind.

---

## Groupe 1 — Changements HTML / classes uniquement

### Header (`templates/_partial/_header/_header.html.twig`)
- [x] Bouton QR Code : `btn` pill avec border 2.5px + shadow offset + texte "QR Code" visible
- [x] Bouton Appeler : idem, bg `base-100` (lime)
- [x] Logo : 2 spans pill (`snap!` ink/lime + store name blanc/ink `-rotate-3`), fallback image si logo défini

### Hero (`templates/default/_section/_hero.html.twig`)
- [x] `<h1>` : `text-[44px] md:text-[72px] font-black lowercase tracking-[-0.045em] leading-[0.92]` + `!` en `text-secondary`
- [x] Description : `font-medium text-sm md:text-base max-w-[460px]`
- [x] Chips d'info : `badge rounded-full bg-white border-2 font-mono shadow-[2px_2px_0]` (statut ● ouvert + adresse)
- [x] CTA : btn pill néobrutaliste avec shadow en `secondary` (pink)

### Menu items (`templates/menu/_menu.html.twig`)
- [ ] Prix : remplacer les divs prix par `<span class="badge badge-neutral font-black text-base px-3">` (pill noir/lime)
- [ ] Tags vegan/halal : `<span class="badge badge-sm badge-success rotate-1 border-2 shadow-[1.5px_1.5px_0]">` etc. par type
- [ ] Séparateur entre items : `border-b-2 border-dashed border-base-content/25`
- [ ] Nom produit : `font-extrabold text-lg tracking-tight`
- [ ] Description produit : `text-sm opacity-70`

### Footer (`templates/base.html.twig`)
- [x] `bg-neutral text-neutral-content` DaisyUI sur le footer
- [x] Grid : `grid grid-cols-2 md:grid-cols-4 gap-6`
- [x] Labels : `font-mono text-xs uppercase tracking-widest opacity-55`
- [x] Typo massive "à bientôt. snap." : `text-5xl font-black lowercase tracking-tight` + span avec `bg-primary text-primary-content rotate-[-2deg] px-2 rounded-md inline-block`
- [x] Remplacer les liens sociaux jphiweb par infos du store (nom, tél, email, adresse) — StoreDto n'a pas de champs réseaux sociaux

---

## Groupe 2 — Plus de travail

### 1. Polices Archivo + JetBrains Mono
- [x] Ajouter `<link>` Google Fonts dans `templates/base.html.twig`
- [x] Déclarer `--font-sans` et `--font-mono` dans `assets/styles/app.css` pour écraser Tailwind
- [ ] Télécharger et auto-héberger les polices (évite la dépendance Google Fonts en prod)
  - Outil : [google-webfonts-helper](https://gwfh.mranftl.com) — choisir Archivo (400/500/700/800/900) + JetBrains Mono (400/500/700)
  - Placer les fichiers dans `public/fonts/`
  - Remplacer le `<link>` Google Fonts par des `@font-face` dans `app.css`

### 2. Variables CSS design system → DaisyUI
- [x] `--color-secondary` → pink/pop `oklch(68% 0.27 345)`
- [x] `--color-accent` → volt blue `oklch(58% 0.24 265)` ✓
- [x] `--color-warning` → sun yellow `oklch(80% 0.18 60)`
- [x] `--color-error` → hot red `oklch(63% 0.23 30)` ✓
- [ ] Vérifier que `base-100` (lime) et `primary` (ink) sont bien utilisés partout de façon cohérente

### 3. Modal QR Code
Actuellement le QR est sur la page `/infos-contact`. À migrer dans une modale :
- [ ] `<dialog class="modal">` DaisyUI déclenché depuis le bouton header
- [ ] Carte stylée : `rotate-[-2deg] border-[3px] border-base-content shadow-[8px_8px_0] shadow-base-content`
- [ ] Sticker "scan & mange !" : span absolu `top-[-14px] right-[-10px] rotate-[8deg] badge badge-secondary border-2 shadow-[2px_2px_0]`
- [ ] QR code via `qr_code_url()` existant à l'intérieur
- [ ] Infos contact (tel, adresse, site, réseaux) avec icônes Lucide dans pills noirs
- [ ] Boutons "Copier le lien" + "Partager" (Web Share API)
- [ ] JS : open/close modal, clipboard copy, `navigator.share` avec fallback

### 4. Nav catégories sticky + scrollspy
- [x] `<nav>` sticky `top-[61px]` avec `overflow-x-auto scrollbar-hide` et `-mx-4`
- [x] `<button class="cat-chip btn btn-sm rounded-full">` par catégorie avec `data-target`
- [x] État actif via classe CSS `.is-active` (bg ink / text lime / shadow secondary)
- [x] JS scrollspy : scroll event sur sections + `getBoundingClientRect`
- [x] Scroll horizontal automatique du chip actif (`scrollIntoView inline: center`)

### 5. Cards de section menu
- [x] `<section>` card par catégorie : `border-[3px] rounded-[--radius-box] shadow-[6px_6px_0]`
- [x] 5 palettes de couleurs cycliques via `sStyles[loop.index0 % 5]`
- [x] `section-head` : pill `-rotate-[1.5deg]` avec numéro mono + nom catégorie
- [x] `sticker-float` : span absolu `-top-3 right-3.5` avec rotation variable par style
- [x] Menu intégré dans `default/index.html.twig` avec guard `{% if menu is defined %}`
- [x] Passer la variable `menu` au `DefaultController` via `CategoryRepository::findMenu()`

### 6. Toast feedback
- [ ] `<div class="toast toast-bottom toast-center">` avec `<div class="alert alert-neutral">`
- [ ] Caché par défaut (`hidden`), affiché 1.8s après copie du lien
- [ ] Style : `font-mono font-black uppercase text-sm`

---

## Priorité suggérée

1. **2** — CSS vars + polices (base de tout le reste)
2. **5** — Cards menu (gros impact visuel immédiat)
3. **Groupe 1** — Quick wins header/hero/items/footer
4. **3** — Modal QR
5. **4** — Scrollspy
6. **6** — Toast
