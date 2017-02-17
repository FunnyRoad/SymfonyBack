# Deploy new preprod version

Pour une mise en preprod, il faut suivre les étapes suivantes.

* Supprimer le cache, env-dev et env-prod
* Veiller à ce que le code mis en preprod soit bien à jour sur git
* Copier sur le serveur de preprod les sources avec la commande scp
* Mettre à jour les bundles si necessaire via composer.

## Lancer le serveur
Si vous souhaitez lancer le serveur, veillez à bien suivre ce qui est décrit ci-dessous:
* Se connecter au serveur via ssh.
* Se déplacer vers le repertoire du projet
* executer la commande: bin/console server:start ip_serveur:8080

Vous pouvez connaitre l'ip du serveur via la commande ifconfig

## Arreter le serveur
Si vous souhaitez lancer le serveur, veillez à bien suivre ce qui est décrit ci-dessous:
* Se connecter au serveur via ssh.
* Se déplacer vers le repertoire du projet
* executer la commande: bin/console server:stop ip_serveur:8080

Vous pouvez connaitre l'ip du serveur via la commande ifconfig

## Copie des sources sur le serveur
scp -r local_directory/src/ login@vps376653.ovh.net:/home/funnyroad/webapps/src
Vous aurez besoin des droits d'accès pour executer cette action

