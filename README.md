Projet BA2

Partie Backend du projet BA2 qui est un site web servant à donné une piste de diagnostique pour les personnes atteinte de trouble dys/TDA(H), ...

Partie backend comprend :

gestion des accès à la base de donnée :
    gerer l'ajouter/suppression élève : manuellement/àpd un fichier
    gerer l'ajout/suppression des prof
    gerer l'ajout d'un classe regroupant des élève ainsi que son attribution au différents prof
    gerer le stockage des résultats des test
    gerer l'autentification des prof/admins.
    gerer la notification des parents par mails + invité à faire test de leur côté.

renvoi des données au frontend par json :
    gerer le contenu de l'affichage des différentes classes que chaque prof possède
    gerer la notification au près des admins de test "positif"
    gerer dire si connecté ou pas pour frontend savoir si faut afficher ou par certaines chose.

    

Plus tard, il serait question de gerer l'ajout de questionnaire de manière interactive.
La méthode pour le faire est encore à determiner. Celà signifie qu'il faudra pensé à comment stocker la question, l'éventuelle réponse, la/les questions qui en decoulent, l'impacte sur un trouble.

Eventuellement plus tard, stocker les informations sur la bdd ainsi on peut permeterre a des professionel de rajouter des informations. Pareil pour le contact de professionnel.

Début d'algorithm à implémenté fait dans algo.txt

strucutre des données :
    professeur :
        -Id
        -Nom
        -Prenom
        -Email
        -Mdp
        -Admin ou pas
    
    eleve :
        -Id
        -Nom
        -Prenom
        -Annee
        -IdClasse
    posède un lien unique vers classe

    classe :
        -Id
        -Nom
    possède un lien many to many avec prof

    test :
        -Id
        -IdEleve
        -IdProf
        -Date
        -Différence score pour les troubles traité.

    contact  :
        -Id
        -Nom
        -Prenom
        -Email
        -Descriptions
        -Troubles
    
    fiche info :
        -Id
        -Nom
        -Trouble
        //info stocker dans fichier dans \fiches\Nom.json faudrai faire ensuite lecture et renvoyer vers editor pour le import dedans
        //et passé en read only pour ça.
