$ErrorActionPreference = 'Stop'

$projectRoot = Split-Path -Parent $PSScriptRoot
$modelPath = Join-Path $projectRoot 'app\Models\MaintenanceTask.php'
$content = Get-Content -LiteralPath $modelPath -Raw
$buggy = "return `$this->belongsTo(MaintenanceRequest::class, 'maintenance_request_id');"
$fixed = "return `$this->belongsTo(MaintenanceRequest::class, 'request_id');"

if ($content.Contains($buggy)) {
    $utf8NoBom = New-Object System.Text.UTF8Encoding($false)
    [System.IO.File]::WriteAllText($modelPath, $content.Replace($buggy, $fixed), $utf8NoBom)
    Write-Host 'Bug fixed: MaintenanceTask now uses request_id explicitly.' -ForegroundColor Green
} elseif ($content.Contains($fixed)) {
    Write-Host 'The fix is already present.' -ForegroundColor Green
} else {
    throw 'Neither the demo bug nor the expected fixed relationship was found.'
}

Write-Host 'Verify with: php artisan test --filter=MaintenanceTaskRelationshipTest'
