<?php
require __DIR__ . '/bootstrap.php';

use App\Database\DBConnection;
use App\Log\Logger;
use App\Dao\FiliereDao;
use App\Dao\EtudiantDao;
use App\Entity\Filiere;
use App\Entity\Etudiant;

$logger = new Logger(__DIR__ . '/project/logs/pdo_errors.log');
DBConnection::init($logger);
$pdo = DBConnection::get();
$filiereDao = new FiliereDao($logger);
$etudiantDao = new EtudiantDao($logger);

try {
    $pdo->beginTransaction();
    $f = new Filiere(null, 'PHY', 'Physique');
    $filiereDao->insert($f);

  
    $e = new Etudiant(null, 'CNE1234', 'Test', 'Transaction', 'salma@example.com', (int)$f->getId());
    $etudiantDao->insert($e);

    $pdo->commit();
    echo "Transaction: COMMIT\n";
} catch (\PDOException $ex) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    $logger->error('Transaction rolled back: ' . $ex->getMessage(), ['method' => __FILE__ . ':transaction']);
    echo "Transaction: ROLLBACK (" . $ex->getMessage() . ")\n";
}