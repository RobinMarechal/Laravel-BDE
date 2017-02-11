

# <u>Front Office :

## Disposition générale

- Menu
- Contenu dynamique (vue)
- les 5 (ou 10) produits les plus populaires (avec un lien "tout voir")
- Latest news ? (avec un lien "tout voir")
- Footer

<hr/>

## Accueil
 url : *[.../]*
 
- Rapide présentation du site
- Liens vers les produits et la confection de menus
- Lien vers l'espace d'administration ?

## Produits 
**Index :**

url : *[.../products]*

- Liste des produits triables selon le nom et/ou le prix
- Liste des produits par catégorie (ex : pizzas, boissons, barres etc...)
- Lien vers la confection de menus

**Produits par catégories :**

url : *[.../products/non-de-la-categorie]*

- Liste des produits de cette catégorie


## Menus

**index :**

url : *[.../menus]*

- Liste des menus possibles + prix + lien vers *[.../menus/creation/nom-du-menu]* pour faire son menu

<br/>

**Creation de menu**

url : *[.../menus/creation/nom-du-menu]*

- Liste des choix possible par catégorie selon le menu. 
	Ex : pour un menu C++ (Plat + boisson + article): 
		- Une section pour le choix du plat (produits dans la catégorie "plat"), 
		- Une section pour le choix de la boissons (produits dans la catégorie "boissons")
		- Une section pour le choix de la catégorie de l'article (produits dans la catégorie "articles")

(C'est un exemple, à arranger comme vous le souhaitez, par exemple avec des champs HTML de type "select")

Les trois champs sont obligatoires (required) (sinon ce n'est pas ce menu là), puis un bouton "Valider" qui amène vers un récapitulatif du menus

<br/>
**Récapitulatif du menu**

url : *[.../menus/creation/nom-du-menu/check]*

- Simple résumé du menu choisis avec le prix et le contenu. Disposé par exemple (sans CSS) :

> Menu C++ :
> 
> - Plat : *Pizza royale*
> - Boisson : *Oasis tropical*
> - Article : *Chips poulet rôti*
> 
> Prix : 3,60€

<hr>

# <u>Back Office 

## Disposition générale

- Menu (peut etre (et surement) pas le même que le front-office)
- Contenu dynamique (vue)
- Dernières modifications (qu'est-ce qui a été modifié, comment, par qui, quand)
- Statistiques ? A voir avec la Kfet (Pourquoi pas : les chiffres du mois, de la semaine... En graphique ? A voir tout tout tout à la fin)
- Footer

/!\ Accessible **Uniquement** par les membres connectés ayant le level suffisant (à gérer avec des middlewares)

<hr />

## Index:

url : *[.../admin]*

- Rapide description de l'espace d'administration
- Liens vers :
	- Liste des produits
	- Liste des menus

## Produits :

**Index :**

url : *[.../admin/products]*

- Liste des produits (comment pour le front-office) mais avec des contrôles : boutons éditer/supprimer/+/- etc...
- Lien vers "Ajouter un nouveau produit" (*[.../admin/products/create]*)

**Ajout :**

url : *[.../admin/products/create]*

- Formulaire d'ajout d'un produit

**Liste des catégories**

url : *[.../admin/categories]*

- Liste des catégories (avec contrôles : supprimer, modifier...)
- Bouton "ajouter une catégorie"

**Ajouter une catégorie**

url : *[.../admin/categories/create]*

- Formulaire de création d'une catégorie de produits

## Menus

**Index :**

url : *[.../admin/menus]*
- Liste des menus (comme pour le front office) + contrôles : boutons éditer/supprimer
- Lien vers ajouter un nouveau menu (*[.../admin/menus/create]*)

**Ajout :**

url : *[.../admin/menus/create]*

- Formulaire d'ajout d'un menu.

> *Idée : Un champs de type select (liste des catégories) pour ajouter une catégorie + un bouton "+" pour ajouter un autre champs de type select (liste des catégories) + un champs pour rentrer le prix du menu.*

##Statistiques 
*(A voir selon l'avancement du projet...)*
