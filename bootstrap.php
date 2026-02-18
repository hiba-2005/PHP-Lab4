<?php
declare(strict_types=1);

// Autoload minimal 
spl_autoload_register(function(string $class){
    $prefix = 'App\\'; $base = __DIR__ . '/project/src/'; $len = strlen($prefix);
    if (strncmp($class, $prefix, $len) !== 0) return;
    $rel = substr($class, $len);
    $file = $base . str_replace('\\', DIRECTORY_SEPARATOR, $rel) . '.php';
    if (is_file($file)) require $file;
});

use App\Log\Logger;
use App\Database\DBConnection;
use App\Dao\FiliereDao;
use App\Dao\EtudiantDao;
use App\Entity\Filiere;
use App\Entity\Etudiant;

$logger = new Logger(__DIR__ . '/project/logs/pdo_errors.log');
DBConnection::init($logger);
$filiereDao = new FiliereDao($logger);
$etudiantDao = new EtudiantDao($logger);

function out(string $label, $value): void {
    echo "[CHECK] $label => " . (is_scalar($value) ? $value : json_encode($value, JSON_UNESCAPED_UNICODE)) . PHP_EOL;
}


$f = new Filiere(null, 'PHY', 'Physique');
$idF = $filiereDao->insert($f);
out('Filiere insert id', $idF);
$foundF = $filiereDao->findById($idF);
out('Filiere findById', $foundF ? $foundF->getCode() . ' / ' . $foundF->getLibelle() : 'null');
$allF = $filiereDao->findAll();
out('Filiere findAll count', count($allF));
$f->setLibelle('Physique Fondamentale');
out('Filiere update', $filiereDao->update($f));
out('Filiere delete', $filiereDao->delete($idF));

$fInfo = $filiereDao->findById(1);
if (!$fInfo) { $tmp = new Filiere(null, 'PHY', 'Physique'); $filiereDao->insert($tmp); $fInfo = $tmp; }
$e = new Etudiant(null, 'CNE9876', 'Ouirouane', 'Hajar', 'Ouirouanehajar@example.com', (int)$fInfo->getId());
$idE = $etudiantDao->insert($e);
out('Etudiant insert id', $idE);
$foundE = $etudiantDao->findById($idE);
out('Etudiant findById', $foundE ? $foundE->getEmail() : 'null');
$allE = $etudiantDao->findAll();
out('Etudiant findAll count', count($allE));
$e->setNom('Martin-Updated');
out('Etudiant update', $etudiantDao->update($e));
out('Etudiant delete', $etudiantDao->delete($idE));


try {
    $e1 = new Etudiant(null, 'CNE1043', 'salma', 'salma', 'salma@example.com', (int)$fInfo->getId());
    $etudiantDao->insert($e1);
    out('email Duplicate test', 'unexpected success');
} catch (\PDOException $ex) {
    out(' email Duplice test', 'OK (exception)');
}


$pdo = DBConnection::get();
try {
    $pdo->beginTransaction();
    $fT = new Filiere(null, 'bio', 'bioligie');
    $filiereDao->insert($fT);
    $eT = new Etudiant(null, 'CNE7000', 'ali', 'ahmed', 'aliahmed@example.com', (int)$fT->getId());
    $etudiantDao->insert($eT);
    $pdo->commit();
    out('Transaction', 'COMMIT');
} catch (\PDOException $ex) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    out('Transaction', 'ROLLBACK: ' . $ex->getMessage());
}