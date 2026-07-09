$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $PSScriptRoot
$modelPath = Join-Path $projectRoot 'app\Models\MaintenanceTask.php'
$backupPath = Join-Path $PSScriptRoot 'MaintenanceTask.php.safe-backup'

if (-not (Test-Path -LiteralPath $backupPath)) {
    Copy-Item -LiteralPath $modelPath -Destination $backupPath
}

$content = Get-Content -LiteralPath $modelPath -Raw
$fixed = "return `$this->belongsTo(MaintenanceRequest::class, 'request_id');"
$buggy = "return `$this->belongsTo(MaintenanceRequest::class, 'maintenance_request_id');"

if (-not $content.Contains($fixed)) {
    throw 'The expected fixed relationship was not found. No file was changed.'
}

$utf8NoBom = New-Object System.Text.UTF8Encoding($false)
[System.IO.File]::WriteAllText($modelPath, $content.Replace($fixed, $buggy), $utf8NoBom)
Write-Host 'Demo bug activated: the relationship now uses the incorrect maintenance_request_id key.' -ForegroundColor Yellow
Write-Host 'Run: php artisan test --filter=MaintenanceTaskRelationshipTest'
