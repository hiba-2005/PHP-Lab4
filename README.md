# LAB 4 — Accès aux Données avec PDO (CRUD sécurisé)

## 🎯 Objectif
Implémenter un accès sécurisé à une base MySQL en PHP 7 avec :
- PDO configuré
- Requêtes préparées
- DAO (Filiere / Etudiant)
- Gestion des exceptions
- Journalisation des erreurs
- Transactions (COMMIT / ROLLBACK)

---

## 📂 Structure du projet
````
project/
├── bootstrap.php
├── test_dao.php
├── config/
│   └── db.php
├── logs/
│   └── pdo_errors.log
├── sql/
│   └── 001_create_db.sql
└── src/
    ├── Database/DBConnection.php
    ├── Log/Logger.php
    ├── Entity/Filiere.php
    ├── Entity/Etudiant.php
    ├── Dao/FiliereDao.php
    └── Dao/EtudiantDao.php
``````
---

## ⚙ Installation

### 1️⃣ Créer la base
mysql -u root -p < project/sql/001_create_db.sql

### 2️⃣ Vérifier la configuration
Modifier si nécessaire :
project/config/db.php

### 3️⃣ Lancer les tests
php project/test_dao.php

---

### Resultas
<img width="1366" height="715" alt="image" src="https://github.com/user-attachments/assets/fc467830-3f65-4763-8d21-66c8c9f941eb" />
<img width="1366" height="731" alt="image" src="https://github.com/user-attachments/assets/c781aa24-2ab8-43e0-96dd-2f41a5f02ccd" />


## ✅ Fonctionnalités

✔ CRUD Filiere  
✔ CRUD Etudiant  
✔ Clés étrangères  
✔ Contraintes d’unicité  
✔ Prepared Statements  
✔ Logger d’erreurs PDO  
✔ Transactions sécurisées  

---

## 📁 Fichier Log

Les erreurs sont enregistrées dans :

project/logs/pdo_errors.log

Format :

[DATE] ERROR: message | context={JSON}

---



## 🏁 Conclusion

Ce LAB démontre l’utilisation professionnelle de PDO avec architecture DAO, gestion des erreurs et transactions atomiques.
